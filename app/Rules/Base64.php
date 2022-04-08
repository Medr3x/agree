<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64 implements Rule
{
    public function __construct(){
        
    }

    public function passes($attributes, $value){

        $extension = explode(';',substr($value, 11, 23))[0]; 
        $base64 = str_replace('data:image/'.$extension.';base64,', '', $value);
        $regx = '~^([A-Za-z0-9+/]{4})*([A-Za-z0-9+/]{4}|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{2}==)$~';
        
        $substr2 = substr($value, 0, 23);//jpeg
        $substr = substr($value, 0, 22);//jpg o png
        $exten = false;
        if (
          ($substr == 'data:image/png;base64,') || 
          ($substr == 'data:image/jpg;base64,') || 
          ($substr2 == 'data:image/jpeg;base64,')
        ){
          $exten = true;
        }

        if(!$exten){
          return false;
        }

        
        if ((base64_encode(base64_decode($base64, true))) !== $base64)
        {
          return false;
        }
        
        if ((preg_match($regx, $base64)) !== 1) 
        {
          \Log::info(1);
          return false;
        }
        
        return true;
    }

    public function message(){
        return "Base64 no es valido!";
    }
}