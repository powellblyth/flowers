<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\MembershipPurchase;
use App\Payment;
use App\Team;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Input;
use Illuminate\Support\Facades\Auth;
use \Illuminate\View\View;

class EntrantController extends Controller
{

    protected $templateDir  = 'entrants';
    protected $baseClass    = 'App\Entrant';
    protected $paymentTypes = array('cash'          => 'cash',
                                    'cheque'        => 'cheque',
                                    'online'        => 'online',
                                    'debit'         => 'debit',
                                    'refund_cash'   => 'refund_cash',
                                    'refund_online' => 'refund_online',
                                    'refund_cheque' => 'refund_cheque');

    protected $membershipTypes = array(
        'single' => 'single',
        'family' => 'family');

    public function isAdmin(): bool
    {
        return Auth::check() && Auth::User()->isAdmin();
    }

    public function index(Request $request): View
    {
        $entrants = Entrant::where('is_anonymised', false)
            ->orderBy('familyname', 'asc')
            ->orderBy('firstname', 'asc')
            ->get();
        // OVerride parent method - this prevents the same query running twice
        // and producing too much data
        return view(
            'entrants.index',
            [
                'things'   => $entrants,
                'all'      => false,
                'isLocked' => config('app.state') == 'locked',
            ]
        );
    }

    public function search(Request $request): View
    {
        $searchTerm      = $request->input('searchterm');
        $entrantsBuilder = Auth::User()->entrants();
        if ($request->has('searchterm')) {
            $entrantsBuilder = $entrantsBuilder
                ->whereRaw("(entrants.firstname LIKE '%$searchTerm%' OR entrants.familyname LIKE '%$searchTerm%' OR entrants.id = '%$searchTerm%') ");
        }

        $entrants = $entrantsBuilder->orderBy('familyname', 'asc')
            ->orderBy('firstname', 'asc')
            ->get();

        return view(
            'entrants.index',
            [
                'things'     => $entrants,
                'searchterm' => $searchTerm,
                'all'        => false,
            ]
        );
    }

    public function searchAll(Request $request): View
    {
        $searchterm = null;
        if ($request->has('searchterm')) {
            $searchterm = $request->input('searchterm');
            $entrants   = Entrant::where('entrants.firstname', 'LIKE', "%$searchterm%")
                ->orWhere('entrants.familyname', 'LIKE', "%$searchterm%")
                ->orWhere('entrants.id', '=', "%$searchterm%")
                ->get();
        } else {
            $entrants = Entrant::where('is_anonymised', false)
                ->orderBy('familyname', 'asc')
                ->orderBy('firstname', 'asc')
                ->get();
        }
        return view($this->templateDir . '.index',
            ['things'     => $entrants,
             'searchterm' => $searchterm,
             'all'        => true,
             'isAdmin'    => $this->isAdmin(),
             'isLocked'   => config('app.state') == 'locked',
            ]);
    }

    public function create(Request $request, ?int $family = null): View
    {
        if ($family) {
            $family = User::findOrFail($family);
        } else {
            $family = Auth::user();
        }
        $this->authorize('addEntrant', $family);
        $indicatedAdmin = null;

        $allUsers = collect($family);

        if (Auth::user()->can('viewAny', User::class)) {
            $allUsers = User::Select(DB::raw('id, concat(lastname, \', \', firstname) as the_name'))
                ->where('is_anonymised', false)
                ->orderBy('lastname', 'asc')
                ->orderBy('firstname')
                ->pluck('the_name', 'id');
        }

        $allTeams = Team::where('status', 'active')
            ->orderBy('min_age')
            ->orderBy('max_age')
            ->orderBy('name')
            ->get()
            ->pluck('name', 'id')->toArray();

        return view('entrants.create', [
            'privacyContent' => config('static_content.privacy_content'),
            'allUsers'       => $allUsers,
            'teams'          => $allTeams,
            'indicatedAdmin' => $family->id,
            'defaultFamilyName' => $family->lastname,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request...

        $entrant = new Entrant();

        $entrant->firstname    = $request->firstname;
        $entrant->familyname   = $request->familyname;
        $entrant->membernumber = $request->membernumber;
        $entrant->team_id      = $request->team_id;
        $entrant->age          = $request->age;

        $entrant->can_retain_data = (int) $request->can_retain_data;

        if ($entrant->save()) {
            $request->session()->flash('success', 'Family Member Saved');
            if (!$this->isAdmin()) {
                Auth::User()->entrants()->save($entrant);
                return redirect()->route('user.family');
            } elseif ($request->has('user_id')) {
                $user = User::find((int) $request->user_id);
                $user->entrants()->save($entrant);
                return redirect()->route('entrants.index');
            }
        } else {
            $request->session()->flash('error', 'Something went wrong saving the Family Member');
            return back();
        }
    }

    public function update(Request $request)
    {
        $entrant = Entrant::where('id', $request->id)->firstOrFail();
        $this->authorize('update', $entrant);

        $entrant->firstname    = $request->firstname;
        $entrant->familyname   = $request->familyname;
        $entrant->membernumber = $request->membernumber;
        $entrant->team_id      = $request->team_id;
        $entrant->age          = $request->age;

        $entrant->can_retain_data = (int) $request->can_retain_data;
        $entrant->can_email       = (int) $request->can_email;
        $entrant->can_sms         = (int) $request->can_sms;
        $entrant->can_post        = (int) $request->can_post;

        if ($entrant->save()) {
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


    public function changeCategories(Request $request, int $id)
    {
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
    public function show(int $id, array $showData = [])
    {
        $totalPrizes   = 0;
        $membershipFee = 0;
        $entryFee      = 0;

        $currentYear = config('app.year');

        $entrant = Entrant::where('id', $id)->firstOrFail();
        $this->authorize('seeDetailedInfo', $entrant);

        $categoriesAry = [0 => 'Select...'];
        $categories    = Category::orderBy('sortorder')
            ->where('year', $currentYear)
            ->where('status', 'active')
            ->get();

        foreach ($categories as $category) {
            $categoriesAry[$category->id] = $category->getNumberedLabel();
        }

        $membershipPurchases   = $entrant->membershipPurchases()->where('year', $currentYear)->get();
        $membershipPaymentData = [];
        foreach ($membershipPurchases as $membershipPurchase) {
            $amount                  = (($membershipPurchase->type == 'single' ? 300 : 500));
            $membershipFee           += $amount;
            $membershipPaymentData[] = ['type' => $membershipPurchase->type, 'amount' => $amount];
        }

        $entries   = $entrant->entries()->where('year', $currentYear)->get();
        $entryData = [];

        foreach ($entries as $entry) {
            if ($entry->category instanceof Category) {
                // Hydrate
                $category = $entry->category;

                $price = $category->getPrice($entry->getPriceType());

                $entryFee += $price;

                if ('' !== trim($entry->winningplace)) {
                    $totalPrizes += $category->getWinningAmount($entry->winningplace);
                }
                $entryData[$entry->id] = [
                    'name'           => $category->getNumberedLabel(),
                    'has_won'        => $entry->hasWon(),
                    'winning_place'  => $entry->winningplace,
                    'winning_amount' => $category->getWinningAmount($entry->winningplace),
                    'category_id'    => $entry->category,
                    'placement_name' => $entry->getPlacementName(),
                    'price'          => $price,
                    'is_late'        => ($entry->getPriceType() == Category::PRICE_LATE_PRICE),
                ];
            }

        }
        $memberNumber = $entrant->getMemberNumber() ?? 'Not currently a member';

        //@todo centralise this
        $tooLateForEntries = time() > strToTime($currentYear . "-07-09 00:00:00");

        return response()->view('entrants.show', array_merge($showData, array(
                'entry_data'           => $entryData,
                'entries'              => $entries,
                'categories'           => $categoriesAry,
                'membership_purchases' => $membershipPaymentData,
                'entry_fee'            => $entryFee,
                'total_price'          => $entryFee + $membershipFee,
                'payment_types'        => $this->paymentTypes,
                'total_prizes'         => $totalPrizes,
                'membership_types'     => ['single' => 'Single'],
                'thing'                => $entrant,
                'member_number'        => $memberNumber,
                'isLocked'             => config('app.state') == 'locked',
                'too_late_for_entries' => $tooLateForEntries,
            ))
        );

//        return parent::show($id, );
    }

    function printcards($id)
    {
        $categoryData = [];
        $entrant      = Entrant::find($id);
        $entries      = $entrant->entries()->where('year', config('app.year'))->get();
        $cardFronts   = [];
        $cardBacks    = [];

        foreach ($entries as $entry) {
            if ($entry->category) {
                $categoryData[$entry->category->id] = $entry->category;
                $cardFronts[]                       = $entry->getCardFrontData();
                $cardBacks[]                        = $entry->getCardBackData();
            }
        }

        return view('cards.printcards', [
            'card_fronts' => $cardFronts,
            'card_backs'  => $cardBacks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        if (Auth::User()->isAdmin()) {
            $entrant = Entrant::where('id', $id)->firstOrFail();
        } else {
            $entrant = Auth::User()->entrants()->where('id', $id)->firstOrFail();
        }

        return view('entrants.edit', array(
            'thing'          => $entrant,
            'privacyContent' => config('static_content.privacy_content'),
            'isAdmin'        => $this->isAdmin()));
    }
}
