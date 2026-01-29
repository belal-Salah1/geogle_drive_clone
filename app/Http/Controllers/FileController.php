<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilesActionsRequest;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FileController extends Controller
{
    public function myFiles(Request $request, ?string $folder = null)
    {

        if ($folder) {
            $folder = File::query()->where('created_by', Auth::id())->where('path', $folder)->firstOrFail();
        }

        if (! $folder) {
            $folder = $this->getRoot();
        }

        $files = File::query()
            ->where('parent_id', $folder->id)
            ->where('created_by', Auth::id())
            ->orderBy('is_folder', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $files = FileResource::collection($files);

        if ($request->wantsJson()) {
            return $files;
        }
        $ancestors = FileResource::collection($folder->ancestors()->get()->push($folder));

        $folder = new FileResource($folder);

        return Inertia::render('MyFiles', compact('files', 'folder', 'ancestors'));
    }

    public function createFolder(StoreFolderRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;
        // dd($parent);
        if (! $parent) {
            $parent = $this->getRoot();
        }

        $file = new File;
        $file->is_folder = 1;
        $file->name = $data['name'];
        $parent->appendNode($file);
        $file->save();

        return redirect()->back();
    }

    public function store(StoreFileRequest $request)
    {
        $data = $request->validated();

        $parent = $request->parent;
        $user = $request->user();
        $fileTree = $request->file_tree;

        if (! $parent) {
            $parent = $this->getRoot();
        }

        if (! empty($fileTree)) {
            $this->saveFileTree($fileTree, $parent, $user);
        } else {
            foreach ($data['files'] as $file) {
                $model = new File;
                $model->is_folder = 0;
                $model->name = $file->getClientOriginalName();
                $model->size = $file->getSize();
                $model->mime = $file->getMimeType();
                $model->storage_path = 'files/'.$user->id.'/'.$model->name;
                $parent->appendNode($model);
                $model->save();

                $file->storeAs('files/'.$user->id, $model->name);
            }

        }

    }

    private function saveFileTree($tree, $parent, $user)
    {
        foreach ($tree as $name => $value) {
            if (is_array($value)) {
                // It's a folder
                $folder = new File;
                $folder->is_folder = 1;
                $folder->name = $name;
                $parent->appendNode($folder);
                $folder->save();
                $this->saveFileTree($value, $folder, $user);
            } else {
                // It's a file
                $file = $value;
                $model = new File;
                $model->is_folder = 0;
                $model->name = $name;
                $model->size = $file->getSize();
                $model->mime = $file->getMimeType();
                $model->storage_path = 'files/'.$user->id.'/'.$model->name;
                $parent->appendNode($model);
                $model->save();
                $file->storeAs($model->storagePath(), $model->name);
            }
        }
    }

    public function destroy(FilesActionsRequest $request)
    {

        $data = $request->validated();
        $parent = $request->parent;
        if ($data['all']) {
            $children = $parent->children;
            foreach ($children as $child) {
                $child->delete();
            }
        } else {
            foreach ($data['id'] ?? [] as $id) {
                $file = File::where('id', $id)->where('created_by', Auth::id())->first();
                if ($file) {
                    $file->delete();
                }
            }
        }

        return to_route('myFiles', ['folder' => $parent->path]);
    }

    public function dawnload(FilesActionsRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;

        $all = $data['all'] ?? false;
        $ids = $data['ids'] ?? [];

        if (! $all && empty($ids)) {
            return [
                'message' => 'Please select files to download',
            ];
        }

        if ($all) {
            $url = $this->createZip($parent->children);
            $filename = $parent->name.'.zip';
        } else {
            if (count($ids) == 1) {
                $file = File::find($ids[0]);
                if ($file->is_folder) {
                    if ($file->children->count() == 0) {
                        return [
                            'message' => 'The folder is empty',
                        ];
                    }
                    $url = $this->createZip($file->children);
                    $filename = $file->name.'.zip';
                } else {
                    $dest = 'public/'.pathinfo($file->storage_path);
                    Storage::copy($file->storage_path, $dest);

                    $url = assert(Storage::url($dest));
                    $filename = $file->name;
                }
            } else {
                $files = File::whereIn('id', $ids)->get();
                $url = $this->createZip($files);
                $filename = $parent->name.'.zip';
            }
        }

        return [
            'url' => $url,
            'filename' => $filename,
        ];

    }

    private function getRoot()
    {
        $root = File::query()->where('created_by', Auth::id())->whereIsRoot()->first();
        if (! $root) {
            $root = new File;
            $root->is_folder = 1;
            $root->name = 'Root';
            $root->saveAsRoot();
        }

        return $root;
    }

    public function createZip($files)
    {
        $zipPath = 'zip/'.Str::random().'.zip';
        $publicPath = 'public/'.$zipPath;
        if (! is_dir(dirname($publicPath))) {
            Storage::makeDirectory(dirname($publicPath));
        }

        $zipFile = Storage::path($publicPath);
        $zip = new \ZipArchive;

        if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE == true)) {
            $this->addFilesToZip($zip, $files);
        }

        $zip->close();

        return asset(Storage::url($zipPath));
    }

    private function addFilesToZip($zip, $files, $ancestors = '')
    {
        foreach ($files as $file) {
            if ($file->is_folder) {
                $this->addFilesToZip($zip, $file->children, $ancestors.$file->name.'/');
            } else {
                $zip->addFile(Storage::path($file->storage_path), $ancestors.$file->name);
            }
        }
    }
}
