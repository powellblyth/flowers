<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MembershipPurchase;
use App\Entrant;
use App\Entry;
use App\Category;

class ReportsController extends Controller {

    protected $templateDir = 'reports';

    public function membershipReport(Request $request) {
        $membershipsSold = MembershipPurchase::where('year', env('CURRENT_YEAR'))->get();
        $purchases = [];
        $amountFamily = 0; $amountSingle = 0;
        $countFamily = 0; $countSingle = 0;
        
        foreach ($membershipsSold as $membership) {
            $entrant = Entrant::find($membership->entrant);
            $purchases[$membership->id] = ['created' => $membership->created_at, 
                'type' => $membership->type, 
                'amount' => $membership->amount,
                'entrant_id' => $entrant->id,
                'entrant_name' => $entrant->getName(),
                'entrant_address' => $entrant->getAddress(),
                'entrant_telephone' => $entrant->telephone,
                'entrant_email' => $entrant->email,
                'entrant_can_email' => $entrant->can_email];
            
            if ('family' == $membership->type){
                $amountFamily +=$membership->amount;
                $countFamily++;
            } else {
                $amountSingle +=$membership->amount;
                $countSingle++;
            }
        }
        $totals = ['amount'=>$amountFamily+$amountSingle,
            'count'=>$countFamily+$countSingle, 
            'amount_family'=>$amountFamily,
            'amount_single'=>$amountSingle,
            'count_family'=>$countFamily,
            'count_single'=>$countSingle];
//var_dump($totals);die()
        return view($this->templateDir . '.membershipReport', array('totals' => $totals, 'purchases'=>$purchases));
    }
    
    public function entryReport(Request $request) {
        $entriesSold = Entry::where('year', env('CURRENT_YEAR'))->get();
        $purchases = [];
        $amountChild = 0; $amountAdult = 0;
        $countChild = 0; $countAdult = 0;
        
        foreach ($entriesSold as $entry) {
            $entrant = Entrant::find($entry->entrant);
            $category = Category::find($entry->category);
            $purchases[$entry->id] = ['created' => $entry->created_at, 
                'type' => $category->getType(), 
                'amount' => $entry->paid,
                'entrant_id' => $entrant->id,
                'entrant_name' => $entrant->getName()];
            
            if (Category::TYPE_ADULT == $membership->type){
                $amountAdult +=$membership->amount;
                $countAdult++;
            } else {
                $amountChild +=$membership->amount;
                $countChild++;
            }
        }
        $totals = ['amount'=>$amountAdult+$amountChild,
            'count'=>$countAdult+$countChild, 
            'amount_adult'=>$amountAdult,
            'amount_child'=>$amountChild,
            'count_adult'=>$countAdult,
            'count_child'=>$countchild];
//var_dump($totals);die()
        return view($this->templateDir . '.membershipReport', array('totals' => $totals, 'purchases'=>$purchases));
    }    

    public function index($extraData = []) {
        return view($this->templateDir . '.index', $extraData = []);
    }
}
