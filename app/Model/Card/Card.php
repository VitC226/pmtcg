<?php

namespace App\Model\Card;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'pm_card';
    public $timestamps = false;

    public function title()
    {
        return $this->hasOne('App\Model\Card\CardTitle', 'id', 'titleId');
    }

    public function cate()
    {
        return $this->hasOne('App\Model\Card\CardSubcategory', 'id', 'subcategory');
    }

    public function typeName()
    {
        return $this->hasOne('App\Model\Card\CardTypeClass', 'id', 'typeClass');
    }

    public function description()
    {
        return $this->hasOne('App\Model\Card\CardDescription', 'cardId', 'cardId');
    }
}
