<?php

namespace App\Http\Controllers;

use App\Category;
use App\Entrant;
use App\Entry;
use App\MembershipPurchase;
use App\User;
use Illuminate\Http\Request;
use \Illuminate\View\View;

class ReportsController extends Controller
{

    protected $templateDir = 'reports';

    protected function getYearFromRequest(Request $request): int
    {
        if ($request->has = ('year')
                            && is_numeric($request->year)
                            && (int) $request->year > 2015
                            && (int) $request->year < (int) date('Y')) {
            return (int) $request->year;
        } else {
            return config('app.year');
        }
    }

    public function membershipReport(Request $request): View
    {
        $year                  = $this->getYearFromRequest($request);
        $singlemembershipsSold = MembershipPurchase::where('year', $year)->where('type', 'single')->get();
        $familymembershipsSold = MembershipPurchase::where('year', $year)->where('type', 'family')->get();
        $singlepurchases       = [];
        $familypurchases       = [];
        $amountFamily          = 0;
        $amountSingle          = 0;
        $countFamily           = 0;
        $countSingle           = 0;

        foreach ($singlemembershipsSold as $membership) {
            $user                             = $membership->user;// Entrant::find($membership->entrant_id);
            $entrant                          = $membership->entrant;
            $singlepurchases[$membership->id] = ['created'        => $membership->created_at,
                                                 'amount'         => number_format($membership->amount / 100, 2),
                                                 'user_id'        => (($user) ? $user->id : null),
                                                 'entrant_id'     => (($entrant) ? $entrant->id : ''),
                                                 'entrant_name'   => (($entrant) ? $entrant->getName() : ''),
                                                 'user_name'      => (($user) ? $user->getName() : ''),
                                                 'number'         => $membership->getNumber(),
                                                 'user_address'   => (($user) ? $user->getAddress() : ''),
                                                 'user_telephone' => (($user) ? $user->telephone : ''),
                                                 'user_email'     => (($user) ? $user->email : ''),
                                                 'user_can_email' => (($user) ? $user->can_email : ''),
            ];

            $amountSingle += $membership->amount;
            $countSingle++;

        }
        foreach ($familymembershipsSold as $membership) {
            $user                             = $membership->user;// Entrant::find($membership->entrant_id);
            $familypurchases[$membership->id] = ['created'        => $membership->created_at,
                                                 'amount'         => number_format($membership->amount / 100, 2),
                                                 'user_id'        => (($user) ? $user->id : ''),
                                                 'user_name'      => (($user) ? $user->getName() : ''),
                                                 'number'         => $membership->getNumber(),
                                                 'user_address'   => (($user) ? $user->getAddress() : ''),
                                                 'user_telephone' => (($user) ? $user->telephone : ''),
                                                 'user_email'     => (($user) ? $user->email : ''),
                                                 'user_can_email' => (($user) ? $user->can_email : ''),
            ];
            $amountFamily                     += $membership->amount;
            $countFamily++;

        }
        $totals = ['amount'        => $amountFamily + $amountSingle,
                   'count'         => $countFamily + $countSingle,
                   'amount_family' => $amountFamily,
                   'amount_single' => $amountSingle,
                   'count_family'  => $countFamily,
                   'count_single'  => $countSingle];
        return view($this->templateDir . '.membershipReport',
            [
                'totals'          => $totals,
                'year'            => $year,
                'singlepurchases' => $singlepurchases,
                'familypurchases' => $familypurchases,
            ]);
    }

    public function entriesReport(Request $request): View
    {
        $year        = $this->getYearFromRequest($request);
        $entriesSold = Entry::where('year', $year)->get();
        $purchases   = [];
        $amountChild = 0;
        $amountAdult = 0;
        $countChild  = 0;
        $countAdult  = 0;
        $entrants    = [];
        $users       = [];
//        $entrants = DB::('SELECT count(DISTINCT entrants.')

        foreach ($entriesSold as $entry) {
            $entrant      = $entry->entrant;
            $entrant_id   = null;
            $entrant_name = null;
            if ($entrant instanceof Entrant) {
                $entrant_id               = $entrant->id;
                $entrant_name             = $entrant->getName();
                $entrants[$entrant_id]    = 'yo ho ho and a bottle of rum';
                $users[$entrant->user_id] = 'Vittals for johnnie';
            }
            $category              = $entry->category;
            $price                 = $category->getPrice($entry->getPriceType());
            $purchases[$entry->id] = [
                'created'         => $entry->created_at,
                'type'            => $category->getType(),
                'is_late'         => $entry->isLate(),
                'category_number' => $entry->category->number,
                'amount'          => $price,
                'entrant_id'      => $entrant_id,
                'entrant_name'    => $entrant_name];

            if (Category::TYPE_ADULT == $category->getType()) {
                $amountAdult += $price;
                $countAdult++;
            } else {
                $amountChild += $price;
                $countChild++;
            }
        }
        $totals = ['amount'        => $amountAdult + $amountChild,
                   'count'         => $countAdult + $countChild,
                   'amount_adult'  => $amountAdult,
                   'amount_child'  => $amountChild,
                   'count_entrant' => count($entrants),
                   'count_user'    => count($users),
                   'count_adult'   => $countAdult,
                   'count_child'   => $countChild];
//var_dump($totals);die()
        return view($this->templateDir . '.entriesReport',
            [
                'totals'    => $totals,
                'purchases' => $purchases,
                'year'      => $year,
            ]);
    }

    public function unplacedCategoriesReport(Request $request): View
    {
        $year               = $this->getYearFromRequest($request);
        $unplacedCategories = [];
        $categories         = Category::where('year', $year)->orderby('sortorder')->get();
        foreach ($categories as $category) {
            $cups = $category->cups()->count();
            if (0 == $cups) {
                $unplacedCategories[$category->id] = $category->getNumberedLabel();
            }
        }
        return view($this->templateDir . '.unplacedCategoriesReport',
            [
                'unplaced_categories' => $unplacedCategories,
                'year'                => $year,
            ]);
    }

    public function index(array $extraData = []): View
    {
        return view($this->templateDir . '.index', $extraData = []);
    }
}
