<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Entry;
use App\Models\Membership;
use App\Models\Show;
use App\Traits\Controllers\HasShowSwitcher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsController extends Controller
{
    use HasShowSwitcher;

    protected function getMembershipFromRequest(Request $request): Membership
    {
        if ($request->filled('membership_id')) {
            return Membership::findOrFail((int) $request->membership_id);
        } else {
            return Membership::orderBy('valid_to', 'DESC')->first();
        }
    }

    public function membershipReport(Request $request): View
    {
        $membership = $this->getMembershipFromRequest($request);
        $membershipsSold = $membership->membershipsSold()->with('entrant')->with('user');
//dd( $membership->membershipsSold()->count());
//        foreach ($membershipsSold as $membershipPurchase) {
//            $user                                     = $membershipPurchase->user;// Entran::find($membership->entrant_id);
//            $entrant                                  = $membershipPurchase->entrant;
//            $singlepurchases[$membershipPurchase->id] = ['created'        => $membershipPurchase->created_at,
//                                                         'amount'         => number_format($membershipPurchase->amount / 100, 2),
//                                                         'user_id'        => (($user) ? $user->id : null),
//                                                         'entrant_id'     => (($entrant) ? $entrant->id : ''),
//                                                         'entrant_name'   => (($entrant) ? $entrant->full_name : ''),
//                                                         'user_name'      => (($user) ? $user->full_name : ''),
//                                                         'number'         => $membershipPurchase->getNumber(),
//                                                         'user_address'   => (($user) ? $user->address : ''),
//                                                         'user_telephone' => (($user) ? $user->telephone : ''),
//                                                         'user_email'     => (($user) ? $user->email : ''),
//                                                         'user_can_email' => (($user) ? $user->can_email : ''),
//            ];
//
//            $amountSingle += $membershipPurchase->amount;
//            $countSingle++;
//
//        }
//        foreach ($familymembershipsSold as $membershipPurchase) {
//            $user                                     = $membershipPurchase->user;// Entrant::find($membership->entrant_id);
//            $familypurchases[$membershipPurchase->id] = ['created'        => $membershipPurchase->created_at,
//                                                         'amount'         => number_format($membershipPurchase->amount / 100, 2),
//                                                         'user_id'        => (($user) ? $user->id : ''),
//                                                         'user_name'      => (($user) ? $user->full_name : ''),
//                                                         'number'         => $membershipPurchase->getNumber(),
//                                                         'user_address'   => (($user) ? $user->address : ''),
//                                                         'user_telephone' => (($user) ? $user->telephone : ''),
//                                                         'user_email'     => (($user) ? $user->email : ''),
//                                                         'user_can_email' => (($user) ? $user->can_email : ''),
//            ];
//            $amountFamily                             += $membershipPurchase->amount;
//            $countFamily++;
//
//        }
//        $totals = ['amount'        => $amountFamily + $amountSingle,
//                   'count'         => $countFamily + $countSingle,
//                   'amount_family' => $amountFamily,
//                   'amount_single' => $amountSingle,
//                   'count_family'  => $countFamily,
//                   'count_single'  => $countSingle];
//        $membershipsSold->sum('amount');
        $totals = [
            'amount' => $membershipsSold->sum('amount'),
            'count' => $membershipsSold->count(),
        ];
        return view(
            'reports.membershipReport',
            [
                'totals' => $totals,
                'membership' => $membership,
                'memberships' => Membership::orderBy('valid_to', 'DESC')->get(),
                'purchases' => $membershipsSold->get(),
                //                'familypurchases' => $familypurchases,
            ]
        );
    }

    /**
     * @throws \Exception
     */
    public function entriesReport(Request $request): View
    {
        $show = $this->getShowFromRequest($request);
        $entriesSold = $show->entries;
        $purchases = [];
        $amountChild = 0;
        $amountAdult = 0;
        $countChild = 0;
        $countAdult = 0;
        $entrants = [];
        $users = [];
        foreach ($entriesSold as $entry) {
            /** @var Entry $entry */
            $entrant = $entry->entrant;
            $entrant_id = $entrant->id;
            $entrant_name = $entrant->full_name;
            $entrants[$entrant_id] = 'yo ho ho and a bottle of rum';
            $users[$entrant->user_id] = 'Vittals for johnnie';

            $category = $entry->category;
            $price = $category->getPrice($entry->getPriceType());

            $purchases[$entry->id] = [
                'created' => $entry->created_at,
                'type' => $category->isAdult() ? Category::TYPE_ADULT : Category::TYPE_JUNIOR,
                'is_late' => $entry->isLate(),
                'category_number' => $entry->category->number,
                'amount' => $price,
                'entrant_id' => $entrant_id,
                'entrant_name' => $entrant_name];

            if ($category->isAdult()) {
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
                   'count_entrant' => count($entrants),
                   'count_user' => count($users),
                   'count_adult' => $countAdult,
                   'count_child' => $countChild];
        return view(
            'reports.entriesReport',
            [
                'totals' => $totals,
                'purchases' => $purchases,
                'show' => $show,
                'shows' => Show::orderBy('start_date')->get(),
            ]
        );
    }

    public function unplacedCategoriesReport(Request $request): View
    {
        $show = $this->getShowFromRequest($request);
        $unplacedCategories = [];
        $categories = $show->categories()->inOrder()->get();

        foreach ($categories as $category) {
            /** @var Category $category */
            $cups = $category->cups()->count();
            if (0 == $cups) {
                $unplacedCategories[$category->id] = $category->numbered_name;
            }
        }

        return view(
            'reports.unplacedCategoriesReport',
            [
                'unplaced_categories' => $unplacedCategories,
                'show' => $show,
                'shows' => Show::orderBy('start_date')->get(),
            ]
        );
    }

    public function index(array $extraData = []): View
    {
        return view('reports.index', $extraData = []);
    }
}
