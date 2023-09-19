<?php

namespace models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{

    protected $table = 'produit';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle'];
    public $timestamps = false;
}