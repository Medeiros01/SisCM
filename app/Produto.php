<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

    protected $fillable = ['st_codigo', 'st_nome', 'st_descricao', 'ce_categoria', 'ce_fornecedor', 'nu_disponivel', 'st_preco_custo', 'st_preco_venda', 'bo_ativo'];
    
    public $timestamps = false;

    protected $table = 'produtos';
}
