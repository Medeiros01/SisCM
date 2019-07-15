<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{

protected $fillable = ['st_notafiscal', 'dt_compra', 'ce_fornecedor', 'dt_cadastro', 'ce_usuario','bo_ativo', 'bo_atualizouestoque','st_valor_compra'];
    
    public $timestamps = false;

    protected $table = 'compras';
}
