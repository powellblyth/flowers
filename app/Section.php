<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany('App\Category');
    }
    //
}
