<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImagesController extends Controller
{
    public function adaptiveResizeUploads($width, $height, $folder, $image)
    {
      
      $file = storage_path('app/public/').$folder.'/'.$image;
      $image = \Image::make($file);

      # Si ancho o alto viene en 0, le asigno null, y redimensiono conservando el aspecto
      if ( $width == 0 || $height == 0 ) {
        $width  = ($width>0) ? $width : null;
        $height = ($height>0) ? $height : null;

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

      } else {

        $image->fit($width, $height);

      }

      return $image->response();
    }

    public function ResizeUploadsCached($width, $height, $folder, $image, $lifeTime = 1440, $compresion = 90)
    {

      $file = storage_path('app/public/').$folder.'/'.$image;
      
      if ( !file_exists($file) || !is_file($file) ){
        $file = storage_path('app/public/').'generic/foto-no-disponible.jpg';
        $lifeTime = 1;
      }

      $cacheimage = null;
      $cacheimage = \Image::cache(function($image) use ($file, $width, $height, $compresion) {
                    $image->make($file);
                    if ( $width == 0 || $height == 0 ) {
                      $width  = ($width>0) ? $width : null;
                      $height = ($height>0) ? $height : null;

                      $image->resize($width, $height, function ($constraint) {
                          $constraint->aspectRatio();
                      });

                    } else {

                      $image->fit($width, $height);

                    }
                    
               }, $lifeTime);

      return Response::make($cacheimage, 200, ['Content-Type' => 'image'])
                        ->setMaxAge( ($lifeTime*60)) //seconds
                        ->setPublic();
    }

    public function showImgUploaded($folder, $image)
    {
      
      $file = storage_path('app/public/').$folder.'/'.$image;
      $image = \Image::make($file);
      return $image->response();
    }

    public function DownloadUploadFile(Request $request, $folder, $file){
        $download_file = storage_path('app/public/').$folder.'/'.$file;
        return Response::download($download_file);  
    }
    
}
