<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getUrl()
    {
        return '/categories/'.$this->id;
    }
    
    public function getWinningAmount($placement)
    {
        $result = 0;
        if ('1' == $placement)
        {
            $result = $this->first_prize;
        }elseif( '2' == $placement)
        {
            $result = $this->second_prize;
        }elseif( '3' == $placement)
        {
            $result = $this->third_prize;
        }
        return $result;
    }
    
    public function getNumberedLabel()
    {
        return $this->number .'. ' . $this->name;
    }
}
