<?php

namespace App\Helpers;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Helper
{

    
    public static $lang;

    // Static initializer
    public static function init()
    {
        self::$lang = LaravelLocalization::getCurrentLocale();
    }


    public static function noImage()
    {
        return url('uploads/noimage.png');
    }

    public static function videoImage()
    {
        return url('uploads/videoimage.png');
    }
    public static function getLang(): string
    {
        if (self::$lang === null) {
            self::$lang = LaravelLocalization::getCurrentLocale();
        }
        return self::$lang;
    }

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

    public static function uploadedImages200Path($model,$image){
        return url('uploads/'.$model.'/resize200/'.$image);
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

    public static function imageIsExists(string|null $image , string $folder ):bool{
        $path = base_path("uploads/$folder/source/$image");
        return $image && file_exists( $path );
    }


}
