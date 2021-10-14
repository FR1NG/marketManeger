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
            "name" => "required|min:3|max:255|unique:market_categories,name,NULL,id,market_id," . $this->market_id,
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
            ->with(['articles' => function ($q) {
                $q->withCount('branchements');
            }])
            ->get();
        return response()->json(['articles' => $categories]);
    }

    public function delete(Request $request)
    {
        $category = marketCategory::where('id', '=', $request->id)->withCount('articles')->first();
        if ($category) {
            if ($category->articles_count > 0) {
                return response()->json(['message' => 'Vous pouvez pas supprimer cette catégorie'], 500);
            }
            $category->delete();
            return response()->json(['message' => 'La catégorie a été supprimée']);
        }
        return response()->json(['message' => 'Catégorie introuvable'], 404);
    }
}
