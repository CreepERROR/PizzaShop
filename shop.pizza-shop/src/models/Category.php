<?php

namespace models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{

    protected $table = 'categorie';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle'];
    public $timestamps = false;
}