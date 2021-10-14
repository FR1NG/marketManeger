<?php

namespace App\Http\Controllers;

use App\Models\marketCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MarketCityController extends Controller
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
            "name" => "required|min:2|max:255|unique:market_cities,name,NULL,id,market_id," . $this->market_id,
        ]);

        $city = new marketCity();
        $city->name = $request->name;
        $city->market_id = $this->market_id;
        $city->save();

        return response()->json(['message' => 'La ville a été ajoutée']);
    }

    public function get(Request $request)
    {
        $cities = marketCity::where('market_id', '=', $this->market_id)
            ->withCount('branchements')
            ->get();
        return response()->json(['cities' => $cities]);
    }

    public function delete(Request $request)
    {
        $city = marketCity::where('id', '=', $request->id)->withCount('branchements')->first();
        if ($city) {
            if ($city->branchements_count > 0) {
                return response()->json(['message' => 'Vous pouvez pas supprimer cette ville'], 500);
            }
            $city->delete();
            return response()->json(['message' => 'La ville a été supprimée'], 200);
        }
        return response()->json(['message' => 'Ville intouvable'], 404);
    }
}
