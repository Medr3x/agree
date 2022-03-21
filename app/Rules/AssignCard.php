<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Card;

class AssignCard implements Rule
{
    public function __construct(){
        
    }

    public function passes($attributes, $value){
      $asignada = Card::find($value);
      if(!empty($asignada) && !empty($asignada->user)){
        return false;
      }
      return true;
    }

    public function message(){
      return "La carta ya esta asignada!";
    }
}