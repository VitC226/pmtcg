<?php

namespace App\Model\Card;

use Illuminate\Database\Eloquent\Model;

class CardSubcategory extends Model
{
    protected $table = 'pm_subcategory';
    public $timestamps = false;

    public function cards()
    {
        return $this->belongsToMany('App\Model\Card\Card', 'id', 'subcategory');
    }
}
