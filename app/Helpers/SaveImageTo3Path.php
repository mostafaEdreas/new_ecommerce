<?php

namespace App\Helpers;

use App\Traits\FileTrait;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class SaveImageTo3Path
{
    use FileTrait;

    private UploadedFile  $file;
    private string $realHieght;
    private string $realWidth;
    private bool $to3Path;

    public function __construct(UploadedFile $file, bool $to3Path = true)
    {
        $this ->to3Path = $to3Path ;
        $this->file = $file;
        $realSize =  getimagesize($this->file->getRealPath());
        if ($to3Path) {
            $this->realWidth = $realSize[0];
            $this->realHieght = $realSize[1];
        }
    }


    public  function saveImages(String $folder): string
    {
        $pathes = $this->getPaths($folder);
        // Ensure directories exist
        $this->ensureDirectoryExists("uploads/$folder/source/");
        if( $this->to3Path){
            $this->ensureDirectoryExists("uploads/$folder/resize200/");
            $this->ensureDirectoryExists("uploads/$folder/resize800/");
        }

        // Save to Source Director
        Image::make($this->file->getRealPath())->save($pathes->source);
        if( $this->to3Path){
            $this->resizeAndSave($pathes->resize200, 200);
            $this->resizeAndSave($pathes->resize800, 800);
        }

        return $pathes->fileName;
    }


    private  function getPaths(String $folder, bool $saveAsWebp = false)
    {
        $extension = $saveAsWebp ? 'webp' : $this->file->getClientOriginalExtension();
        $fileName   =  $this->createFileName() . '.' . $extension;
        $path['fileName'] = $fileName ;
        $path['source'] = base_path("uploads/$folder/source/" . $fileName);
        if( $this->to3Path){
            $path['resize200'] = base_path("uploads/$folder/resize200/" . $fileName);
            $path['resize800'] = base_path("uploads/$folder/resize800/" . $fileName);
        }

        return (object)$path;
    }


    private function resizeAndSave(string $path, int $targetSize)
    {

        if ($this->realWidth > $targetSize && $this->realHieght > $targetSize) {
            $width = ($this->realWidth / $this->realHieght) * $targetSize;
            $height = $width / ($this->realWidth / $this->realHieght);
            $img = Image::canvas($width, $height);
            $image = Image::make($this->file->getRealPath())->resize($width, $height, function ($c) {
                $c->aspectRatio();
                $c->upsize();
            });
            $img->insert($image, 'center');
            $img->save($path);
        } else {
            Image::make($this->file->getRealPath())->save($path);
        }
    }

    public static function deleteImage($fileName, string $folder)
    {
        if ($fileName) {
            $img_path = base_path() . "/uploads/$folder/source/";
            $img_path200 = base_path() . "/uploads/$folder/resize200/";
            $img_path800 = base_path() . "/uploads/$folder/resize800/";
            $filePaths = [
                sprintf($img_path . '%s', $fileName),
                sprintf($img_path200 . '%s', $fileName),
                sprintf($img_path800 . '%s', $fileName)
            ];
            foreach ($filePaths as $filePath) {
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
}
