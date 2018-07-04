<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Input;
use App\Entrant;
use App\Entry;
use App\Payment;
use App\MembershipPurchase;
use App\Category;

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
        $things = $this->baseClass::orderBy('familyname', 'asc')->get();
        return view($this->templateDir . '.index', array_merge($extraData, array('things' => $things)));
    }

    public function search(Request $request) {
        $searchterm = $request->input('searchterm');
        $things = $this->baseClass::where('entrants.firstname', 'LIKE', "%$searchterm%")
            ->orWhere('entrants.familyname', 'LIKE', "%$searchterm%")
            ->get();
        return view($this->templateDir . '.index', array('things' => $things, 'searchterm' => $searchterm));
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
        if ((int) $request->can_retain_data) {
            $thing->retain_data_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_retain_data = (int) $request->can_retain_data;
        if ((int) $request->can_email) {
            $thing->email_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_email = (int) $request->can_email;
        if ($request->can_sms) {
            $thing->sms_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_sms = (int) $request->can_sms;
        $thing->save();
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
        if (!$thing->can_retain_data && (int) $request->can_retain_data) {
            $thing->retain_data_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_retain_data = (int) $request->can_retain_data;
        if (!$thing->can_email && (int) $request->can_email) {
            $thing->email_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_email = (int) $request->can_email;
        if (!$thing->can_sms && $request->can_sms) {
            $thing->sms_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_sms = (int) $request->can_sms;
        $thing->save();
        return view($this->templateDir . '.saved', array('thing' => $thing));
    }

    public function optins(Request $request) {
        // Validate the request...
        $thing = $this->baseClass::find($request->id);

        if (!$thing->can_retain_data && (int) $request->can_retain_data) {
            $thing->retain_data_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_retain_data = (int) $request->can_retain_data;
        if (!$thing->can_email && (int) $request->can_email) {
            $thing->email_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_email = (int) $request->can_email;
        if (!$thing->can_sms && $request->can_sms) {
            $thing->sms_opt_in = date('Y-m-d H:i:s');
        }
        $thing->can_sms = (int) $request->can_sms;
        $thing->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, $showData = []) {
        $totalPrizes = 0;
        $membershipFee = 0;
        $entryFee = 0;

        $categoriesAry = [0 => 'Select...'];
        $categories = Category::orderBy('sortorder')->where('year', env('CURRENT_YEAR', 2018))->get();
        foreach ($categories as $category) {
            $categoriesAry[$category->id] = $category->getNumberedLabel();
        }
        $payments = Payment::where('entrant', (int) $id)->where('year', env('CURRENT_YEAR', 2018))->get();
        $totalPaid = 0;
        foreach ($payments as $payment) {
            $totalPaid += $payment->amount;
        }

        $membershipPayments = MembershipPurchase::where('entrant', (int) $id)->where('year', env('CURRENT_YEAR', 2018))->get();
        $membershipPaymentData = [];
        foreach ($membershipPayments as $payment) {
            $amount = (($payment->type == 'single' ? 300 : 500));
            $membershipFee += $amount;
            $membershipPaymentData[] = ['type' => $payment->type, 'amount' => $amount];
        }

        $entries = Entry::where('entrant', (int) $id)->where('year', env('CURRENT_YEAR', 2018))->get();
        $categoryData = [];
        foreach ($entries as $entry) {
            if ($entry->category) {
                $categoryData[$entry->category] = Category::where('id', $entry->category)->where('year', env('CURRENT_YEAR', 2018))->first();
//                var_dump($entry->created_at);
                $created = new \DateTime($entry->created_at);
                // Hack because of late processing
                $cutoffDate = new \DateTime('6 July 2018 12:00:59');

                if ($created < $cutoffDate) {
//                    var_dump('normal');
                    $price = $categoryData[$entry->category]->price;
                } else {
//                    var_dump('late');
                    $price = $categoryData[$entry->category]->late_price;
                }
                $entryFee += $price;

                if ('' !== trim($entry->winningplace)) {
                    $totalPrizes += $categoryData[$entry->category]->getWinningAmount($entry->winningplace);
                }
            }
        }
        return parent::show($id, array_merge($showData, array('entries' => $entries,
                'category_data' => $categoryData,
                'categories' => $categoriesAry,
                'membership_purchases' => $membershipPaymentData,
                'payments' => $payments,
                'entry_fee' => $entryFee,
                'total_price' => $entryFee + $membershipFee,
                'paid' => $totalPaid,
                'payment_types' => $this->paymentTypes,
                'total_prizes' => $totalPrizes,
                'membership_fee' => $membershipFee,
                'membership_types' => $this->membershipTypes)));
    }

    function printcards($id) {
        $categoryData = [];
        $entrant = $this->baseClass::find($id);
        $entries = Entry::where('entrant', (int) $id)->where('year', env('CURRENT_YEAR', 2018))->get();
        $cardFronts = [];
        $cardBacks = [];

        foreach ($entries as $entry) {
            if ($entry->category) {
                $categoryData[$entry->category] = Category::where('id', $entry->category)->where('year', env('CURRENT_YEAR', 2018))->first();
                $cardFronts[] = [
                    'class_number' => $categoryData[$entry->category]->number,
                    'entrant_number' => (int) $id,
                    'entrant_age' => (($entrant->age && 18 > (int) $entrant->age) ? $entrant->age : '')
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
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $thing = $this->baseClass::find($id);
//      $showData = array_merge($extraData,  array('thing' => $thing));
//      return view($this->templateDir.'.show', $showData);

        return view($this->templateDir . '.edit', array('thing' => $thing));
    }
}
