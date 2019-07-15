<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $fillable = ['st_nome', 'st_descricao'];
    
    public $timestamps = false;

    protected $table = 'categorias';
}
