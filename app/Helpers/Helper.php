<?php

namespace App\Helpers;

class Helper
{

    public $noimage = 'uploads/noimage.png';

    public static function cssFilesPath(string $string){
        return url('resources/assets/front/css/'.$string);
    }
    public static function pluginsFilesPath(string $string){
        return url('resources/assets/front/plugins/'.$string);
    }

    public static function fontsFilesPath(string $string){
        return url('resources/assets/front/fonts/'.$string);
    }

    public static function jsFilesPath(string $string){
        return url('resources/assets/front/js/'.$string);
    }

    public static function imageFilesPath(string $string){
        return url('resources/assets/front/images/'.$string);
    }

    public static function uploadedImagesPath($model,$image){
        return url('uploads/'.$model.'/source/'.$image);
    }


    public static function uploadedSliderImagesPath($model,$image){
        return url('uploads/sliders/'.$model.'/source/'.$image);
    }

    public static function print150CharFromTextEditor($text){
        $textWithoutTags = html_entity_decode(strip_tags($text));
        $truncatedText = mb_substr($textWithoutTags, 0, 150);
        return $truncatedText;
    }

    public static function removeTags($text,int $cutText = 0){
        $textWithoutTags = html_entity_decode(strip_tags($text));
        return $cutText && $cutText > 0? mb_substr($textWithoutTags, 0, 150):$textWithoutTags;

    }

    public static function imageIsExists(string $image , string $folder ):bool{
       if( $image && file_exists( "uploads/$folder/$image")){
        return true;
       }
       return false;
    }


}
