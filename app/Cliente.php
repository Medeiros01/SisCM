<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = ['st_nome', 'st_cpf', 'st_rg', 'dt_nascimento', 'st_endereco', 'st_municipio', 'st_estado', 'st_celular', 'st_tel_fixo', 'st_email'];
    
    public $timestamps = false;

    protected $table = 'clientes';
}
