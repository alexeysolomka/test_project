<?php


namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    public function resizeImage($file)
    {
        list($width, $height) = getimagesize($file);

        $newwidth = 100;
        $newheight = 50;

        switch ($file->getClientOriginalExtension()) {
            case "png":
                $src = imagecreatefrompng($file);
                break;
            case "jpeg":
            case "jpg":
                $src = imagecreatefromjpeg($file);
                break;
            case "gif":
                $src = imagecreatefromgif($file);
                break;
            default:
                $src = imagecreatefromjpeg($file);
                break;
        }

        $dst = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        return $dst;
    }
}
