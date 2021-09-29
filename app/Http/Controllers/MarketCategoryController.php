<?php

namespace App\Http\Controllers;

use App\Models\marketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketCategoryController extends Controller
{

    private $market_id;

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (Auth::user()->hasRole('admin')) {
                $this->market_id = $request->market_id;
            } else {
                $this->market_id = Auth::user()->market->id;
            }

            return $next($request);
        });
    }




    public function store(Request $request)
    {
        $request->validate([
            'market_id' => 'required|numeric',
            'name' => 'required|unique:market_categories|min:3|max:255',
        ]);

        $category = new marketCategory();
        $category->market_id = $this->market_id;
        $category->name = $request->name;

        $category->save();
        return response()->json(['message' => 'la catégorie de branchement a été créée avec succès']);
    }

    public function getData(Request $request)
    {
        $categories  = marketCategory::where('market_id', '=', $this->market_id)
            ->with('articles')
            ->get();
        return response()->json(['articles' => $categories]);
    }
}
