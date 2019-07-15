<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhescaixa extends Model
{

protected $fillable = ['ce_caixa', 'st_valor', 'st_tipomovimentacao', 'ce_venda', 'st_descricao', 'st_forma_pagamento'];
    
    public $timestamps = false;

    protected $table = 'detalhescaixas';
}
