<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{

protected $fillable = ['ce_cliente', 'dt_vanda', 'st_valor', 'ce_vendedor', 'st_tipo','st_status', 'nu_codigo', 'st_forma_pagamento'];
    
    public $timestamps = false;

    protected $table = 'vendas';
}
