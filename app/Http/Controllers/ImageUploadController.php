<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class ImageUploadController extends Controller
{
    public function fileStore(Request  $request){
        $fileName = time() . '.' . $request->file->getSize(). '.' .$request->file->getClientOriginalName();

        $request->file->move(public_path('files'), $fileName);
        return response()->json(['file' => $fileName]);

    }

    public function deleteFile($file){
        File::delete(public_path("files/$file"));
        return response()->json(['file' => $file]);
    }
}
