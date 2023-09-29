<?php

namespace pizzashop\shop\models;;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{

    protected $connection = 'catalog';
    protected $table = 'produit';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['numero', 'libelle', 'description','image'];

    public function categorie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function tailles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Size::class, 'tarif', 'produit_id', 'taille_id')
            ->withPivot('tarif');
    }
}
