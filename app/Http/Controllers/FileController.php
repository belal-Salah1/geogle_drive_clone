<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FileController extends Controller
{
    public function myFiles(?string $folder = null)
    {
        if ($folder) {
            $folder = File::query()->where('created_by', Auth::id())->where('path', $folder)->firstOrFail();
        }
        // dd($folder);

        if (! $folder) {
            $folder = $this->getRoot();
        }
        // dd($folder);
        // $folder = $this->getRoot();

        $files = File::query()
            ->where('parent_id', $folder->id)
            ->where('created_by', Auth::id())
            ->orderBy('is_folder', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $files = FileResource::collection($files);

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
        $user = $request->id;
        $fileTree = $request->file_tree;

        if (! $parent) {
            $parent = $this->getRoot();
        }

        if (! empty($fileTree)) {
            $this->saveFileTree($fileTree, $parent, $user);
        } else {
            foreach ($data['files'] as $uploadedFile) {
                $path = $file->store('/files/'.$user->id);
                $model = new File;
                $model->is_folder = 0;
                $model->name = $uploadedFile->getClientOriginalName();
                $model->size = $uploadedFile->getSize();
                $model->mime = $uploadedFile->getMimeType();
                // $model->created_by = $user;
                $parent->appendNode($model);
                $model->save();

                $uploadedFile->storeAs($model->storagePath(), $model->name);
            }

        }

        // dd($data, $fileTree);
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
}
