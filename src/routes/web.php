<?php
use Illuminate\Http\Request;
use Mmurattcann\UploadHelper\Upload;

Route::post("test", function (Request $request) {
   $image = $request->file("image");

   Upload::upload("store","test", "test-upload",$image);
})->name("test.upload");

