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

    public static function frontFilesPath(string $string){
        return url('public/assets/front/'.$string);
    }
    public static function cssFilesPath(string $string){
        return url('public/assets/front/css/'.$string);
    }
    public static function pluginsFilesPath(string $string){
        return url('public/assets/front/plugins/'.$string);
    }

    public static function fontsFilesPath(string $string){
        return url('public/assets/front/fonts/'.$string);
    }

    public static function jsFilesPath(string $string){
        return url('public/assets/front/js/'.$string);
    }

    public static function imageFilesPath(string $string){
        return url('public/assets/front/images/'.$string);
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



    public static function removeTags(string $text): string
    {
        return html_entity_decode(strip_tags($text));
    }


    public static function cutText(string $text, int $length, string $after = ' '): string
    {
        if ($length <= 0 || $length >= mb_strlen($text)) {
            return $text;
        }

        $specialCharPos = mb_strpos($text, $after, $length);

        if ($specialCharPos !== false) {
            return mb_substr($text, 0, $specialCharPos + 1);
        }

        return mb_substr($text, 0, $length);
    }


    public static function removeTagsAndCutText(string $text, int $length , string $after = ' '): string
    {
        $cleanText = self::removeTags($text);

        // If $number is specified, cut after the first space or special character
        if ($length > 0) {
            return self::cutText($cleanText, $length, $after);
        }

        return $cleanText;
    }

    public static function imageIsExists(string|null $image , string $folder ):bool{
        $path = base_path("uploads/$folder/source/$image");
        return $image && file_exists( $path );
    }


}
