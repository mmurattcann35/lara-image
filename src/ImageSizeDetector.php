<?php


namespace Murattcann\LaraImage;

use Intervention\Image\Facades\Image;

class ImageSizeDetector
{

    public static function getImageWidth($file = null)
    {
        return $width = Image::make($file)->width();
    }

    public static  function getImageHeight($file = null)
    {
        return $width = Image::make($file)->height();
    }
}
