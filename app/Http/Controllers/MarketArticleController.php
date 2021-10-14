<?php

namespace App\Http\Controllers;

use App\Models\marketArticle;
use Illuminate\Http\Request;

class MarketArticleController extends Controller
{
    public function store(Request $request)
    {
        // validation
        $request->validate([
            "market_id" => "required|numeric",
            "market_category_id" => "required|numeric",
            "name" => "required|min:3|max:255|unique:market_articles,name,NULL,id,market_id," . $request->market_id,
            "display_name" => "required|min:3|max:255|unique:market_articles,display_name,NULL,id,market_id," . $request->market_id,
            "unit" => "required|max:50",
            "quantity" => "required|numeric",
            "unit_price" => "required|numeric",
        ]);

        // create 
        $article = new marketArticle();
        $article->market_id = $request->market_id;
        $article->market_category_id = $request->market_category_id;
        $article->name = $request->name;
        $article->display_name = $request->display_name;
        $article->unit = $request->unit;
        $article->quantity = $request->quantity;
        $article->unit_price = $request->unit_price;
        // store 
        $article->save();
        return response()->json(['message' => 'type de branchement créé avec succès']);
    }
}
