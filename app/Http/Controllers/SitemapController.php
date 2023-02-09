<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [['lastmod' => date('Y-m-d'), 'loc' => route('home')]];
        // Content Pages
//        $urls[] = ['lastmod' => '2022-09-01', 'loc' => route('about')];
        $urls[] = ['lastmod' => date('Y-m-d'), 'loc' => route('categories.index')];
        $urls[] = ['lastmod' => date('Y-m-d'), 'loc' => route('cups.index')];
        $urls[] = ['lastmod' => date('Y-m-d'), 'loc' => route('raffle.index')];


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
