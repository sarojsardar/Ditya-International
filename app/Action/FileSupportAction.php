<?php
namespace App\Action;

use Illuminate\Support\Facades\Storage;

class FileSupportAction
{
    function __construct()
    {
        
    }

    public function uploadFile($file, $folderName)
    {
        $file = Storage::disk('public')->put($folderName, $file);
        $fileName =  asset('storage/'.$file);
        return $fileName;
    }

    public function removeFile($fileName)
    {
        try {
            unlink($fileName);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}