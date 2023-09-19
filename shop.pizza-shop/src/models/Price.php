<?php

namespace models;
use Illuminate\Database\Eloquent\Model;
class Price extends Model
{

    protected $table = 'tarif';
    protected $fillable = ['produit_id', 'taille_id', 'tarif'];
    public $timestamps = false;
}