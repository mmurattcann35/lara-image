<?php


namespace Mmurattcann\LaraImage;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class LaraImage
{
    private const _DISK = "public";
    private const _DEFAULT_IMAGE = "https://via.placeholder.com/500x500.png?text=Setted+As+Default+Image";

    private static function setPath($path){

        $disk = Storage::disk(self::_DISK);

        if (!$disk->exists($path)) return $disk->makeDirectory($path);

        return $path;
    }

    private static function validate($image){

        return Validator::make(request()->all(), [request()->file($image) => 'image|mimes:jpeg,jpg,png,gif'])->validate();
    }

    public static function upload($operationType= null, $path=null, $title=null, $image = null,  $width=null, $height=null){

        $slug = Str::slug($title);

        $disk = Storage::disk(self::_DISK);

        $currentDate = Carbon::now()->toDateString();


        if($width == null) $width   = ImageSizeDetector::getImageWidth($image);

        if($height == null) $height = ImageSizeDetector::getImageHeight($image);


        if($operationType == "store" || $operationType == "insert"){

            if(isset($image)){

                self::validate($image);
                if($image->isValid()){


                    $imageName   = $slug."-".$currentDate."-".uniqid().".".$image->getClientOriginalExtension();

                    $resizedImage = Image::make($image)->resize($width, $height)->save();

                    $disk->put(self::setPath($path)."/".$imageName, $resizedImage);
                }
            }
            else{

                $imageName = self::_DEFAULT_IMAGE ;

            }
        }

        if($operationType == "update" || $operationType == "put") {

            if (isset($image)) {

                self::validate($image);

                if ($image->isValid()) {

                    $imageName   = $slug."-".$currentDate."-".uniqid().".".$image->getClientOriginalExtension();

                    self::deleteUploadedFile($path,$imageName);

                    $resizedImage = Image::make($image)->resize($width, $height)->save();

                    $disk->put(self::setPath($path). "/" . $imageName, $resizedImage);
                }
            } else {

                $imageName = self::_DEFAULT_IMAGE;
            }
        }

        return $imageName;
    }

    public static function deleteUploadedFile($path, $imageName){

        $disk = Storage::disk(self::_DISK);

        if($disk->exists($path."/".$imageName)){
            $disk->delete($path."/".$imageName);
        }
    }


}
