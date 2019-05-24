<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    const TYPE_JUNIOR = 'Junior';
    const TYPE_ADULT = 'Adult';
    const PRICE_LATE_PRICE = 'lateprice';
    const PRICE_EARLY_PRICE = 'earlyprice';

    public function getUrl() {
        return '/categories/' . $this->id;
    }

    public function getWinningAmount($placement) {
        $result = 0;
        if ('1' == $placement) {
            $result = $this->first_prize;
        } elseif ('2' == $placement) {
            $result = $this->second_prize;
        } elseif ('3' == $placement) {
            $result = $this->third_prize;
        }
        return $result;
    }

    public function getNumberedLabel() {
        return $this->number . '. ' . $this->name;
    }

    public function getType() {
        if (in_array($this->section->number, ['8', '9'])){
            $type =  self::TYPE_JUNIOR;
        }
        else
        {
            $type = self::TYPE_ADULT;
        }
        return $type;
    }
    public function getPrice(string $type) {
        if ($type == self::PRICE_EARLY_PRICE) {
            return $this->price;
        } else {
            return $this->late_price;
        }
    }
    public function entries(): \Illuminate\Database\Eloquent\Relations\hasMany {
        return $this->hasMany('App\Entry');
    }
    public function section(): \Illuminate\Database\Eloquent\Relations\belongsTo {
        return $this->belongsTo('App\Section');
    }

}
