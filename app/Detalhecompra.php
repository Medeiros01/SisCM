<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalhecompra extends Model
{

protected $fillable = ['ce_compra', 'ce_produto', 'nu_quantidade', 'st_preco_custo', 'st_preco_venda'];
    
    public $timestamps = false;

    protected $table = 'detalhecompras';
}
