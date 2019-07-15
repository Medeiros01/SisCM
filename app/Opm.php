<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opm extends Model
{

protected $fillable = ['st_nome', 'ce_pai', 'st_descricao'];
    
    public $timestamps = false;

    protected $table = 'opms';

    public function filhos()
    {
       return $filhos = $this->hasMany(Opm::class, 'ce_pai', 'id');
        
       
    }
}
