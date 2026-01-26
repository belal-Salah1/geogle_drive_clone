<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use Inertia\Inertia;

class FileController extends Controller
{
    public function myFiles()
    {
        return Inertia::render('MyFiles');
    }

    public function createFolder(StoreFolderRequest $request)
    {
        $data = $request->validated();
        $request->parent();

    }
}
