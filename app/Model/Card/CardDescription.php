<?php

namespace App\Model\Card;

use Illuminate\Database\Eloquent\Model;

class CardDescription extends Model
{
    protected $table = 'pm_description';
    public $timestamps = false;

    public function energyName()
    {
        return $this->hasOne('App\Model\Card\CardEnergy', 'id', 'energy');
    }
}
