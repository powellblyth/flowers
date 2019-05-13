<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\MembershipPurchase;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Input;
use Illuminate\Support\Facades\Auth;

class EntrantController extends Controller {

    protected $templateDir = 'entrants';
    protected $baseClass = 'App\Entrant';
    protected $paymentTypes = array('cash' => 'cash'
    , 'cheque' => 'cheque'
    , 'online' => 'online'
    , 'debit' => 'debit'
    , 'refund_cash' => 'refund_cash'
    , 'refund_online' => 'refund_online'
    , 'refund_cheque' => 'refund_cheque');
    protected $membershipTypes = array('single' => 'single'
    , 'family' => 'family');

    public function index($extraData = []) {
        $things = Auth::User()->entrants;
        return view($this->templateDir . '.index', array_merge($extraData, array('things' => $things, 'all' => false,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin())));
    }

    public function all($extraData = []) {
        $things = $this->baseClass::orderBy('familyname', 'asc')->get();
        return view($this->templateDir . '.index', array_merge($extraData, array('things' => $things, 'all' => true,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin())));
    }

    public function search(Request $request) {
        $searchterm = $request->input('searchterm');
        $things = Auth::User()->entrants()
            ->whereRaw("(entrants.firstname LIKE '%$searchterm%' OR entrants.familyname LIKE '%$searchterm%' OR entrants.id =  '%$searchterm%') ")
            ->get();
        return view($this->templateDir . '.index', array('things' => $things, 'searchterm' => $searchterm, 'all' => false,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()));
    }

    public function searchAll(Request $request) {
        $searchterm = $request->input('searchterm');
        $things = $this->baseClass::where('entrants.firstname', 'LIKE', "%$searchterm%")
            ->orWhere('entrants.familyname', 'LIKE', "%$searchterm%")
            ->orWhere('entrants.id', '=', "%$searchterm%")
            ->get();
        return view($this->templateDir . '.index', array('things' => $things, 'searchterm' => $searchterm, 'all' => true,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()));
    }


    public function store(Request $request) {
        // Validate the request...

        $thing = new $this->baseClass();

        $thing->firstname = $request->firstname;
        $thing->familyname = $request->familyname;
        $thing->membernumber = $request->membernumber;
        $thing->email = $request->email;
        $thing->telephone = $request->telephone;
        $thing->address = $request->address;
        $thing->address2 = $request->address2;
        $thing->addresstown = $request->addresstown;
        $thing->postcode = $request->postcode;
        $thing->age = $request->age;

        $thing->use_user_address = (bool)$request->use_user_address;
        if ((int)$request->can_retain_data) {
            $thing->retain_data_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_retain_data = (int)$request->can_retain_data;
        if ((int)$request->can_email) {
            $thing->email_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_email = (int)$request->can_email;
        if ($request->can_sms) {
            $thing->sms_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_sms = (int)$request->can_sms;

        if ($thing->save()) {
            if (!Auth::User()->isAdmin()) {
                Auth::User()->entrants()->save($thing);
            }
        }
        return view($this->templateDir . '.saved', array('thing' => $thing));
    }

    public function update(Request $request) {
        // Validate the request...
        $thing = $this->baseClass::find($request->id);

        $thing->firstname = $request->firstname;
        $thing->familyname = $request->familyname;
        $thing->membernumber = $request->membernumber;
        $thing->email = $request->email;
        $thing->telephone = $request->telephone;
        $thing->address = $request->address;
        $thing->address2 = $request->address2;
        $thing->addresstown = $request->addresstown;
        $thing->postcode = $request->postcode;
        $thing->age = $request->age;
        if (!$thing->can_retain_data && (int)$request->can_retain_data) {
            $thing->retain_data_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_retain_data = (int)$request->can_retain_data;
        if (!$thing->can_email && (int)$request->can_email) {
            $thing->email_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_email = (int)$request->can_email;
        if (!$thing->can_sms && $request->can_sms) {
            $thing->sms_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_sms = (int)$request->can_sms;
        $thing->save();
        return view($this->templateDir . '.saved', array('thing' => $thing));
    }

    public function optins(Request $request) {
        // Validate the request...
        $thing = $this->baseClass::find($request->id);

        if (!$thing->can_retain_data && (int)$request->can_retain_data) {
            $thing->retain_data_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_retain_data = (int)$request->can_retain_data;
        if (!$thing->can_email && (int)$request->can_email) {
            $thing->email_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_email = (int)$request->can_email;
        if (!$thing->can_sms && $request->can_sms) {
            $thing->sms_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_sms = (int)$request->can_sms;
        $thing->save();
        return back();
    }

    public function changeCategories(Request $request, int $id) {
        if ($request->isMethod('POST')) {
            return redirect()->route('entrants.index');
        } else {
            $entrant = Entrant::where('id', $id)->first();
            if ($entrant instanceof Entrant) {
                var_dump($entrant->getName());
            } else {
                die('bust' . $id);
            }
            die();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id, $showData = []) {
        $totalPrizes = 0;
        $membershipFee = 0;
        $entryFee = 0;

        $thing = $this->baseClass::find($id);
//        $showData = array_merge($extraData,  array('thing' => $thing));

        $categoriesAry = [0 => 'Select...'];
        $categories = Category::orderBy('sortorder')->where('year', env('CURRENT_YEAR', 2018))->get();
        foreach ($categories as $category) {
            $categoriesAry[$category->id] = $category->getNumberedLabel();
        }
        $payments = $thing->payments()->where('year', env('CURRENT_YEAR', 2018))->get();
        $totalPaid = 0;
        foreach ($payments as $payment) {
            $totalPaid += $payment->amount;
        }

        $membershipPayments = $thing->membershipPurchases()->where('year', env('CURRENT_YEAR', 2018))->get();
        $membershipPaymentData = [];
        foreach ($membershipPayments as $payment) {
            $amount = (($payment->type == 'single' ? 300 : 500));
            $membershipFee += $amount;
            $membershipPaymentData[] = ['type' => $payment->type, 'amount' => $amount];
        }

        $entries = $thing->entries()->where('year', env('CURRENT_YEAR', 2018))->get();
        $entryData = [];
        $dbug = 0;
        foreach ($entries as $entry) {
            if ($entry->category_id) {
                // Hydrate
                $category = $entry->category()->where('year', env('CURRENT_YEAR', 2018))->first();

                $price = $category->getPrice($entry->getPriceType());
                $entryFee += $price;

                if ('' !== trim($entry->winningplace)) {
                    $totalPrizes += $category->getWinningAmount($entry->winningplace);
                }
                $entryData[$entry->id] = [
                    'name' => $category->getNumberedLabel(),
                    'has_won' => $entry->hasWon(),
                    'winning_place' => $entry->winningplace,
                    'winning_amount' => $category->getWinningAmount($entry->winningplace),
                    'category_id' => $entry->category,
                    'placement_name' => $entry->getPlacementName(),
                    'price' => $price,
                    'is_late' => ($entry->getPriceType() == Category::PRICE_LATE_PRICE)
                ];
            }
        }
        return view($this->templateDir.'.show', array_merge($showData, array(
            'entry_data' => $entryData,
            'entries' => $entries,
            'categories' => $categoriesAry,
            'membership_purchases' => $membershipPaymentData,
            'payments' => $payments,
            'entry_fee' => $entryFee,
            'total_price' => $entryFee + $membershipFee,
            'paid' => $totalPaid,
            'payment_types' => $this->paymentTypes,
            'total_prizes' => $totalPrizes,
            'membership_fee' => $membershipFee,
            'membership_types' => $this->membershipTypes,
                'can_email' => $thing->can_email,
                'can_sms' => $thing->can_sms,
                'can_phone' => $thing->can_phone,
                'can_retain_data' => $thing->can_retain_data,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin(),
            'thing' => $thing))
            );
//        return parent::show($id, );
    }

    function printcards($id) {
        $categoryData = [];
        $entrant = $this->baseClass::find($id);
        $entries = Entry::where('entrant', (int)$id)->where('year', env('CURRENT_YEAR', 2018))->get();
        $cardFronts = [];
        $cardBacks = [];

        foreach ($entries as $entry) {
            if ($entry->category) {
                $categoryData[$entry->category] = Category::where('id', $entry->category)->where('year', env('CURRENT_YEAR', 2018))->first();
                $cardFronts[] = [
                    'class_number' => $categoryData[$entry->category]->number,
                    'entrant_number' => (int)$id,
                    'entrant_age' => (($entrant->age && 18 > (int)$entrant->age) ? $entrant->age : '')
                ];
                $cardBacks[] = ['class_number' => $categoryData[$entry->category]->number,
                    'class_name' => $categoryData[$entry->category]->name,
                    'entrant_name' => $entrant->getName(),
                    'entrant_number' => $entrant->id
                ];
            }
        }

        return view($this->templateDir . '.printcards', ['entrant' => $entrant,
            'card_fronts' => $cardFronts,
            'card_backs' => $cardBacks,
            'category_data' => $categoryData,
            'entries' => $entries]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $thing = $this->baseClass::find($id);
//      $showData = array_merge($extraData,  array('thing' => $thing));
//      return view($this->templateDir.'.show', $showData);

        return view($this->templateDir . '.edit', array('thing' => $thing,
            'isAdmin' => Auth::check() && Auth::User()->isAdmin()));
    }
}
