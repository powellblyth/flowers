<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    public function hasWon()
    {
        return !empty(trim($this->winningplace));
    }
    public function getPlacementName()
    {
        $result = 0;
        if ('1' == $this->winningplace)
        {
            $result = 'First Place';
        }elseif( '2' == $this->winningplace)
        {
            $result = 'Second Place';
        }elseif( '3' == $this->winningplace)
        {
            $result = 'Third Place';
        }
        else
        {
            $result = ucwords($this->winningplace);
        }
        return $result;
    }
}
