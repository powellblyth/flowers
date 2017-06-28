<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrant extends Model
{

    public function getUrl()
    {
        return '/entrants/'.$this->id;
    }
    
    public function getName()
    {
        return $this->firstname . ' ' . $this->familyname;
    }
}
