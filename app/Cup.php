<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cup extends Model
{
    public function getUrl()
    {
        return '/cups/'.$this->id;
    }
}
