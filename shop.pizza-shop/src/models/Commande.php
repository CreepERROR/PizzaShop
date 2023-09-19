<?php

namespace models;
use Illuminate\Database\Eloquent\Model;
class Commande extends Model
{
    //delai	tinyint(4) NULL [0]
    //id	varchar(64)
    //date_commande	datetime
    //type_livraison	int(11) [1]
    //etat	int(11) [1]
    //montant_total	decimal(10,2) [0.00]
    //mail_client	varchar(128)
    protected $table = 'commande';
    protected $primaryKey = 'id';
    protected $fillable = ['delai', 'date_commande', 'type_livraison', 'etat', 'montant_total', 'mail_client'];
    public $timestamps = false;
    public function commande(): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Commande::class, 'id');
    }
}