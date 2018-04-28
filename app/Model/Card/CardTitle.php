<?php

namespace App\Model\Card;

use Illuminate\Database\Eloquent\Model;

class CardTitle extends Model
{
    protected $table = 'pm_card_title';
    public $timestamps = false;

    public function card(){
        return $this->belongsTo('App\Model\Card\Card', 'id', 'titleId');
    }
}
