<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caixa extends Model
{

protected $fillable = ['ce_usuario', 'dt_abertura', 'dt_finalizado', 'st_status'];
    
    public $timestamps = false;

    protected $table = 'caixas';
}
