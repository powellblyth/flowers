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
    
    public function getPrintableName()
    {
        return substr($this->firstname,0,1) . ' ' . $this->familyname;
    }
    
    public function getAddress()
    {
        return str_replace(', , ', ', ', str_replace(', , ', ', ', $this->address .', ' .$this->address2 .', ' . $this->addresstown .' ' . $this->postcode));
    }
}
