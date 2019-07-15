<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhevenda extends Model
{

protected $fillable = ['ce_venda', 'ce_produto', 'nu_quantidade', 'st_desconto'];
    
    public $timestamps = false;

    protected $table = 'detalhevendas';
}
