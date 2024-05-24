<?php
namespace App\Helper;


class ImageUploadHelper{


    public function uploadImage($file, $foldername, $name = ''){

        if($file){            
            $directory = $foldername;
            // if (!file_exists($directory)) {
            //     mkdir($directory, 0777, true);
            // }
            $fileName = time().'-'.$name.'.'.$file->getClientOriginalExtension();
            // $file->move($directory, $fileName);
            $file->storeAs($directory, $fileName);
            // return url('/storage/uploads/staff-profiles/'.$fileName);
            return $fileName;

        }else{

            return '';

        }

    }

    public function deleteImage($fullPath){
        unlink(storage_path($fullPath));
    }

}