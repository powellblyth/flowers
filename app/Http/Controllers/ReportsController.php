<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\MembershipPurchase;
use Illuminate\Http\Request;
use \Illuminate\View\View;

class ReportsController extends Controller {

    protected $templateDir = 'reports';

    public function membershipReport(Request $request): View {
        $membershipsSold = MembershipPurchase::where('year', env('CURRENT_YEAR'))->get();
        $purchases = [];
        $amountFamily = 0;
        $amountSingle = 0;
        $countFamily = 0;
        $countSingle = 0;

        foreach ($membershipsSold as $membership) {
            $entrant = Entrant::find($membership->entrant_id);
            $purchases[$membership->id] = ['created' => $membership->created_at,
                'type' => $membership->type,
                'amount' => $membership->amount,
                'entrant_id' => $entrant->id,
                'entrant_name' => $entrant->getName(),
                'entrant_address' => $entrant->getAddress(),
                'entrant_telephone' => $entrant->telephone,
                'entrant_email' => $entrant->email,
                'entrant_can_email' => $entrant->can_email];

            if ('family' == $membership->type) {
                $amountFamily += $membership->amount;
                $countFamily++;
            } else {
                $amountSingle += $membership->amount;
                $countSingle++;
            }
        }
        $totals = ['amount' => $amountFamily + $amountSingle,
            'count' => $countFamily + $countSingle,
            'amount_family' => $amountFamily,
            'amount_single' => $amountSingle,
            'count_family' => $countFamily,
            'count_single' => $countSingle];
//var_dump($totals);die()
        return view($this->templateDir . '.membershipReport', array('totals' => $totals, 'purchases' => $purchases));
    }

    public function entriesReport(Request $request): View {
        $entriesSold = Entry::where('year', env('CURRENT_YEAR'))->get();
        $purchases = [];
        $amountChild = 0;
        $amountAdult = 0;
        $countChild = 0;
        $countAdult = 0;

        foreach ($entriesSold as $entry) {
            $entrant = $entry->entrant;
            $category = $entry->category;
            $price = $category->getPrice($entry->getPriceType());
            $purchases[$entry->id] = [
                'created' => $entry->created_at,
                'type' => $category->getType(),
                'is_late' => $entry->isLate(),
                'amount' => $price,
                'entrant_id' => $entrant->id,
                'entrant_name' => $entrant->getName()];

            if (Category::TYPE_ADULT == $category->getType()) {
                $amountAdult += $price;
                $countAdult++;
            } else {
                $amountChild += $price;
                $countChild++;
            }
        }
        $totals = ['amount' => $amountAdult + $amountChild,
            'count' => $countAdult + $countChild,
            'amount_adult' => $amountAdult,
            'amount_child' => $amountChild,
            'count_adult' => $countAdult,
            'count_child' => $countChild];
//var_dump($totals);die()
        return view($this->templateDir . '.entriesReport', array('totals' => $totals, 'purchases' => $purchases));
    }

    public function unplacedCategoriesReport(): View {
        $unplacedCategories = [];
        $categories = Category::where('year', env('CURRENT_YEAR'))->orderby('sortorder')->get();
        foreach ($categories as $category) {
            $cups = $category->cups()->count();
            if (0 == $cups) {
                $unplacedCategories[$category->id] = $category->getNumberedLabel();
            }
        }
        return view($this->templateDir . '.unplacedCategoriesReport', array('unplaced_categories' => $unplacedCategories));
    }

    public function index(array $extraData = []): View {
        return view($this->templateDir . '.index', $extraData = []);
    }
}
