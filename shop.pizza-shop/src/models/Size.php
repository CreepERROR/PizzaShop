<?php

namespace pizzashop\shop\models;;
use Illuminate\Database\Eloquent\Model;
class Size extends Model
{

    protected $connection = 'catalog';
    protected $table = 'taille';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'libelle'];

    public function produits()
    {
        return $this->belongsToMany(Product::class, 'tarif', 'taille_id', 'produit_id');
    }
}