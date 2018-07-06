<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrant extends Model {

    public function getUrl() {
        return '/entrants/' . $this->id;
    }

    public function getName() {
        return trim($this->firstname . ' ' . $this->familyname);
    }

    public function getPrintableName() {
        return trim(substr($this->firstname, 0, 1) . ' ' . $this->familyname);
    }

    public function getAddress() {
        $concatted =trim($this->address) . ', '
                . trim($this->address2) . ', ' . trim($this->addresstown);
        $deduped = str_replace(', , ', ', ', 
            str_replace(', , ', ', ', 
                $concatted));
        return trim(trim($deduped, ', ')  . ' ' . trim($this->postcode), ', ');
    }
}
