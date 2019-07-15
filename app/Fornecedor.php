<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{

    protected $fillable = ['st_nome', 'st_descricao', 'st_cnpj_cpf', 'bo_ativo',
                            'st_contato', 'st_email', 'st_endereco', 'st_estado',
                            'st_municipio'];
    
    public $timestamps = false;

    protected $table = 'fornecedores';
}
