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
//        $urls[] = ['lastmod' => '2022-09-01', 'loc' => route('about')];
        foreach (Show::public()->newestFirst()->get() as $show) {
            /** @var Show $show */
            $publishDate = ($show->ends_date->isBefore(Carbon::now()) ? $show->ends_date : Carbon::now());
            $urls[] = [
                'lastmod' => $publishDate->format('Y-m-d'),
                'loc' => route('categories.index') . '?show_id=' . $show->id,
            ];
            $urls[] = [
                'lastmod' => $publishDate->format('Y-m-d'),
                'loc' => route('cups.index') . '?show_id=' . $show->id,
            ];
            $urls[] = [
                'lastmod' => $publishDate->format('Y-m-d'),
                'loc' => route('raffle.index') . '?show_id=' . $show->id,
            ];
        }

        foreach (Cup::inOrder()->get() as $cup) {
            $urls[] = [
                'lastmod' => date('Y-m-d'),
                'loc' => route('cups.show', ['cup' => $cup])
            ];
        }

//        $urls[] = ['lastmod' => date('Y-m-d'), 'loc' => route('categories.index')];
//        $urls[] = ['lastmod' => date('Y-m-d'), 'loc' => route('cups.index')];
//        $urls[] = ['lastmod' => date('Y-m-d'), 'loc' => route('raffle.index')];


        $urls[] = ['lastmod' => '2022-09-01', 'loc' => route('login')];
        $urls[] = ['lastmod' => '2022-09-01', 'loc' => route('register')];


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
