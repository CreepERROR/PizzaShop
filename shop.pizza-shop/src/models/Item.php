<?php

namespace pizzashop\shop\models;;

use pizzashop\shop\domain\dto\item\ItemDTO;

class Item extends \Illuminate\Database\Eloquent\Model
{
    protected $connection = 'commande';
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [ 'numero', 'libelle', 'taille','libelle_taille','commande_id', 'tarif', 'quantite'];

    public function commande()
    {
        return $this->belongsTo(Command::class, 'commande_id');
    }


}