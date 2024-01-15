<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::search(
            trim($request->get('search')) ?? ''
        )
            ->query(function ($query) {
                $query->join('categories', 'products.category_id', 'categories.id')
                    ->select(['products.id', 'products.name', 'categories.name as category'])
                    ->orderBy('products.id', 'DESC');
            })
            ->paginate(5);

        return view('products.index', compact('products', 'request'));
    }
}
