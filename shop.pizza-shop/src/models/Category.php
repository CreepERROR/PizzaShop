<?php

namespace pizzashop\shop\models;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{

    protected $connection = 'catalog';
    protected $table = 'categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'libelle'];

    public function produits()
    {
        return $this->hasMany(Product::class, 'categorie_id');
    }
}