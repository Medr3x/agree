<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64 implements Rule
{
    public function __construct(){
        
    }

    public function passes($attributes, $value){
        $base = str_replace('data:image/png;base64,', '', $value);
        $regx = '~^([A-Za-z0-9+/]{4})*([A-Za-z0-9+/]{4}|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{2}==)$~';
        
        $substr = substr($value, 0, 22);
        if ($substr !== 'data:image/png;base64,')
        {
          return false;
        }
        
        if ((base64_encode(base64_decode($base64, true))) !== $base64)
        {
          return false;
        }
        
        if ((preg_match($regx, $base64)) !== 1) 
        {
          return false;
        }
        
        return true;
    }

    public function message(){
        return "Base64 no es valido!";
    }
}