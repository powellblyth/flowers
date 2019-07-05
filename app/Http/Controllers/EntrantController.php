<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\MembershipPurchase;
use App\Payment;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Input;
use Illuminate\Support\Facades\Auth;
use \Illuminate\View\View;

class EntrantController extends Controller {

    protected $templateDir = 'entrants';
    protected $baseClass = 'App\Entrant';
    protected $paymentTypes = array('cash' => 'cash',
        'cheque' => 'cheque',
        'online' => 'online',
        'debit' => 'debit',
        'refund_cash' => 'refund_cash',
        'refund_online' => 'refund_online',
        'refund_cheque' => 'refund_cheque');

    protected $membershipTypes = array(
        'single' => 'single',
        'family' => 'family');

    public function isAdmin(): bool {
        return Auth::check() && Auth::User()->isAdmin();
    }

    public function index(Request $request): View {
        $things = Entrant::where('is_anonymised', false)
            ->orderBy('familyname', 'asc')
            ->orderBy('firstname', 'asc')
            ->get();
        // OVerride parent method - this prevents the same query running twice
        // and producing too much data
        return view($this->templateDir . '.index',
            ['things' => $things,
                'all' => false,
                'isAdmin' => $this->isAdmin(),
            ]);
    }

    public function search(Request $request): View {
        $searchTerm = $request->input('searchterm');
        if ($request->has('searchterm')) {
            $things = Auth::User()->entrants()
                ->whereRaw("(entrants.firstname LIKE '%$searchTerm%' OR entrants.familyname LIKE '%$searchTerm%' OR entrants.id =  '%$searchTerm%') ")
                ->orderBy('familyname', 'asc')->orderBy('firstname', 'asc')
                ->get();
        } else {
            $things = Auth::User()->entrants()
                ->orderBy('familyname', 'asc')->orderBy('firstname', 'asc')
                ->get();

        }
        return view($this->templateDir . '.index',
            array('things' => $things,
                'searchterm' => $searchTerm,
                'all' => false,
                'isAdmin' => $this->isAdmin()));
    }

    public function searchAll(Request $request): View {
        $searchterm = null;
        if ($request->has('searchterm')) {
            $searchterm = $request->input('searchterm');
            $things = $this->baseClass::where('entrants.firstname', 'LIKE', "%$searchterm%")
                ->orWhere('entrants.familyname', 'LIKE', "%$searchterm%")
                ->orWhere('entrants.id', '=', "%$searchterm%")
                ->get();
        } else {
            $things = $this->baseClass::where('is_anonymised', false)
                ->orderBy('familyname', 'asc')
                ->orderBy('firstname', 'asc')
                ->get();
        }
        return view($this->templateDir . '.index',
            ['things' => $things,
                'searchterm' => $searchterm,
                'all' => true,
                'isAdmin' => $this->isAdmin(),
                'isLocked' => config('app.state') == 'locked',
            ]);
    }

    public function create(Request $request): View {
        $indicatedAdmin = Auth::User();

        if ($this->isAdmin()) {
            if ($request->has('user_id') && 0 < (int)$request->get('user_id')) {
                $indicatedAdmin = (int)$request->get('user_id');
            } else {
                $indicatedAdmin = Auth::User()->id;
            }

            $allUsers = User::Select(DB::raw('id, concat(lastname, \', \', firstname) as the_name'))->Where('is_anonymised', false)->orderBy('lastname', 'asc')->orderBy('firstname')->pluck('the_name', 'id');
        } else {
            $allUsers = null;
        }


//        var_dump($allUsers);
        return view($this->templateDir . '.create', [
            'isAdmin' => $this->isAdmin(),
            'privacyContent' => config('static_content.privacy_content'),
            'allUsers' => $allUsers,
            'indicatedAdmin' => $indicatedAdmin,
        ]);
    }

    public function store(Request $request) {
        // Validate the request...

        $thing = new $this->baseClass();

        $thing->firstname = $request->firstname;
        $thing->familyname = $request->familyname;
        $thing->membernumber = $request->membernumber;
        $thing->age = $request->age;
//        $thing->email = $request->email;
//        $thing->telephone = $request->telephone;
//        $thing->address = $request->address;
//        $thing->address2 = $request->address2;
//        $thing->addresstown = $request->addresstown;
//        $thing->postcode = $request->postcode;

//        $thing->use_user_address = (bool)$request->use_user_address;
        $thing->can_retain_data = (int)$request->can_retain_data;
//        if ((int)$request->can_email) {
//            $thing->email_opt_in = date('Y-m-d H:i:s');
//        }
//        $thing->can_email = (int)$request->can_email;
//        if ($request->can_sms) {
//            $thing->sms_opt_in = date('Y-m-d H:i:s');
//        }
//        $thing->can_sms = (int)$request->can_sms;

        if ($thing->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            if (!$this->isAdmin()) {
                Auth::User()->entrants()->save($thing);
                return redirect()->route('user.family');
            } elseif ($request->has('user_id')) {
                $user = User::find((int)$request->user_id);
                $user->entrants()->save($thing);
                return redirect()->route('entrants.index');
            }
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
        }
//        return view($this->templateDir . '.saved', array('thing' => $thing));
    }

    public function update(Request $request) {
        // Validate the request...
        if (Auth::User()->isAdmin()) {
            $thing = Entrant::where('id', $request->id)->first();
        } else {
            $thing = Auth::User()->entrants()->where('id', $request->id)->first();
        }

        $thing->firstname = $request->firstname;
        $thing->familyname = $request->familyname;
        $thing->membernumber = $request->membernumber;
        $thing->age = $request->age;

        $thing->can_retain_data = (int)$request->can_retain_data;
        $thing->can_email = (int)$request->can_email;
        $thing->can_sms = (int)$request->can_sms;
        $thing->can_post = (int)$request->can_post;

        if ($thing->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            if ($this->isAdmin()) {
                return redirect()->route('entrants.index');
            } else {
                return redirect()->route('user.family');
            }
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
        }
//        return view($this->templateDir . '.saved', array('thing' => $thing));
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
    public function show(int $id, array $showData = []) {

//        return redirect('billing');
        $totalPrizes = 0;
        $membershipFee = 0;
        $entryFee = 0;

        if (Auth::User()->isAdmin()) {
            $thing = Entrant::where('id', $id)->first();
        } else {
            $thing = Auth::User()->entrants()->where('id', $id)->first();
        }
        if (!$thing instanceof Entrant) {
            return view('404');
        } else {
            //        $showData = array_merge($extraData,  array('thing' => $thing));

            $categoriesAry = [0 => 'Select...'];
            $categories = Category::orderBy('sortorder')->where('year', config('app.year'))->get();
            foreach ($categories as $category) {
                $categoriesAry[$category->id] = $category->getNumberedLabel();
            }

            $membershipPurchases = $thing->membershipPurchases()->where('year', config('app.year'))->get();
            $membershipPaymentData = [];
            foreach ($membershipPurchases as $membershipPurchase) {
                $amount = (($membershipPurchase->type == 'single' ? 300 : 500));
                $membershipFee += $amount;
                $membershipPaymentData[] = ['type' => $membershipPurchase->type, 'amount' => $amount];
            }

            $entries = $thing->entries()->where('year', config('app.year'))->get();
            $entryData = [];

            foreach ($entries as $entry) {
                if ($entry->category_id) {
                    // Hydrate
                    $category = $entry->category;

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
            $memberNumber = null;
            $memberNumber = $thing->getMemberNumber();
            if (is_null($memberNumber)) {
                $memberNumber = 'Not currently a member';
            }
            return view($this->templateDir . '.show', array_merge($showData, array(
                    'entry_data' => $entryData,
                    'entries' => $entries,
                    'categories' => $categoriesAry,
                    'membership_purchases' => $membershipPaymentData,
                    'entry_fee' => $entryFee,
                    'total_price' => $entryFee + $membershipFee,
//                    'paid' => $totalPaid,
                    'payment_types' => $this->paymentTypes,
                    'total_prizes' => $totalPrizes,
//                    'membership_fee' => $membershipFee,
                    'membership_types' => ['single' => 'Single'],
                    //                'can_email' => $thing->can_email,
                    //                'can_sms' => $thing->can_sms,
                    //                'can_phone' => $thing->can_phone,
                    //                'can_retain_data' => $thing->can_retain_data,
                    'isAdmin' => $this->isAdmin(),
                    'thing' => $thing,
                    'member_number' => $memberNumber,
                    'isLocked' => config('app.state') == 'locked',
                ))
            );
        }
//        return parent::show($id, );
    }

    function printcards($id) {
        $categoryData = [];
        $entrant = Entrant::find($id);
        $entries = $entrant->entries()->where('year', config('app.year'))->get();
        $cardFronts = [];
        $cardBacks = [];

        foreach ($entries as $entry) {
            if ($entry->category) {
                $categoryData[$entry->category->id] = $entry->category;
                $cardFronts[] = $entry->getCardFrontData();
                $cardBacks[] = $entry->getCardBackData();
            }
        }

        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs' => $cardBacks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id) {
        if (Auth::User()->isAdmin()) {
            $thing = Entrant::where('id', $id)->first();
        } else {
            $thing = Auth::User()->entrants()->where('id', $id)->first();
        }
        if (!$thing instanceof Entrant) {
            return view('404');
        } else {

//      $showData = array_merge($extraData,  array('thing' => $thing));
//      return view($this->templateDir.'.show', $showData);

            return view($this->templateDir . '.edit', array(
                'thing' => $thing,
                'privacyContent' => config('static_content.privacy_content'),
                'isAdmin' => $this->isAdmin()));
        }
    }
}
