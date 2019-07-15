<?php
namespace App\utis;
use Auth;
use App\Log;
use App\Historico;
use App\Regional;
use App\Instituto;
use App\Setor;
use App\Estado;
use DB;
use Illuminate\Support\Facades\Redirect;



/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Log
 *
 * @author medeiros
 */
class Funcoes {
    
   
    public static function transformaValorArray($data) {
        $valor = strip_tags($data);
      $array = explode(';',$valor);
    print_r($array);
      return $array;

    }
    
}

?>