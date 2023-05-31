<?php

namespace App\Http\Controllers;

use App\Models\Cup;
use App\Models\Show;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [['lastmod' => date('Y-m-d'), 'loc' => route('home')]];
        // Content Pages
        foreach (Show::public()->newestFirst()->get() as $show) {
            /** @var Show $show */
            $publishDate = ($show->ends_date->isBefore(Carbon::now()) ? $show->ends_date : Carbon::now());
            $urls[] = [
                'lastmod' => $publishDate->format('Y-m-d'),
                'loc' => route('show.categories', ['show' => $show]),
            ];
            $urls[] = [
                'lastmod' => $publishDate->format('Y-m-d'),
                'loc' => route('show.cups', ['show' => $show]),
            ];
            // don't bother if there are no prizes
            if ($show->rafflePrizes()->count() > 0) {
                $urls[] = [
                    'lastmod' => $publishDate->format('Y-m-d'),
                    'loc' => route('show.raffle', ['show' => $show]),
                ];
            }
        }

        // we have to pass a show into this route.
        $newestShow = Show::public()->newestFirst()->first();
        foreach (Cup::inOrder()->get() as $cup) {
            $urls[] = [
                'lastmod' => date('Y-m-d'),
                'loc' => route('cups.show', ['cup' => $cup, 'show' => $newestShow])
            ];
        }

        $urls[] = ['lastmod' => '2023-05-01', 'loc' => route('login')];
        $urls[] = ['lastmod' => '2023-05-01', 'loc' => route('register')];

        $urls[] = ['lastmod' => '2023-05-01', 'loc' => route('marketing.membership')];
//        $urls[] = ['lastmod' => '2023-05-01', 'loc' => route('marketing.pricing')];

        return response()
            ->view(
                view: 'sitemap',
                data: [
                    'locs' => $urls,
                ],
                headers: ['content-type' => 'text/xml']
            );
    }
}
