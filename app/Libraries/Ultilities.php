<?php
//namespace App\Libraries;
namespace App\Libraries;

use Illuminate\Support\Facades\File;


class Ultilities
{
    // public static function uploadFile($file,$path='uploads')
    // {
    //     $publicPath = public_path($path);
    //     if (!File::exists($publicPath)) {
    //         File::makeDirectory($publicPath, 0775, true, true);
    //     }
    //     $name = time() . '.'.$file->getClientOriginalExtension();
    //     $name = preg_replace('/\s+/', '', $name);
    //     $file->move(public_path($path), $name);
    //     return "/$path/".$name;
    // }

    public static function uploadFile($file,$path='uploads')
    {
        $publicPath = public_path($path);
        if (!File::exists($publicPath)) {
            File::makeDirectory($publicPath, 0775, true, true);
        }
        $name = time().$file->getClientOriginalName();
        $name = preg_replace('/\s+/', '', $name);
        $file->move(public_path($path), $name);
//        return "/$path/" . $name;
        return $name;
    }

    public static function clearXSS($string)
    {
        $string = nl2br($string);
        $string = trim(strip_tags($string));
        $string = self::removeScripts($string);

        return $string;
    }

    public static function removeScripts($str)
    {
        $regex =
            '/(<link[^>]+rel="[^"]*stylesheet"[^>]*>)|' .
            '<script[^>]*>.*?<\/script>|' .
            '<style[^>]*>.*?<\/style>|' .
            '<!--.*?-->/is';

        return preg_replace($regex, '', $str);
    }

    public static function createSlug($str, $delimiter = '-')
    {

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        return $slug;

    }

}
