<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Entry extends Model {

    public function hasWon() {
        return !empty(trim($this->winningplace));
    }

    public function getPlacementName() {
        $result = 0;
        if ('1' === $this->winningplace) {
            $result = 'First Place';
        } elseif ('2' === $this->winningplace) {
            $result = 'Second Place';
        } elseif ('3' === $this->winningplace) {
            $result = 'Third Place';
        } else {
            $result = ucwords($this->winningplace);
        }
        return $result;
    }

    public function getPriceType() {

        if ($this->isLate()) {
            return Category::PRICE_LATE_PRICE;
        } else {
            return Category::PRICE_EARLY_PRICE;
        }
    }
    
    public function isLate()
    {
        $created = new \DateTime($this->created_at);

        $cutoffDate = new \DateTime($this->getCutoffDate($this->year));
        
        return $created > $cutoffDate;

    }

    public function getCutoffDate(int $year): string {
        $date = '';
        switch ($year)
        {
            case 2019:
                $date = '3 July 2019 23:59:59';
                break;
            case 2018:
                $date = '4 July 2018 23:59:59';
                break;
            default:
                $date = '6 July 2017 12:00:59';
        }
        return $date;
    }
    public function entrant(): \Illuminate\Database\Eloquent\Relations\belongsTo {
        return $this->belongsTo('App\Entrant');
    }
    public function category(): \Illuminate\Database\Eloquent\Relations\belongsTo {
        return $this->belongsTo('App\Category');
    }
}
