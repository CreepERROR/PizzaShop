<?php

namespace models;
use Illuminate\Database\Eloquent\Model;
class Size extends Model
{

    protected $table = 'taille';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle'];
    public $timestamps = false;
}