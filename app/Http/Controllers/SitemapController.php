<?php

namespace App\Http\Controllers;

use App\Models\Product;

class SitemapController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('updated_at')->take(50)->get();

        $pages = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/product'), 'priority' => '0.90'],
            ['loc' => url('/seo/fruit-seo-guide'), 'priority' => '0.85'],
        ];

        return response()
            ->view('sitemap', compact('pages', 'products'))
            ->header('Content-Type', 'application/xml');
    }
}
