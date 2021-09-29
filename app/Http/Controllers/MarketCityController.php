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
            'name' => 'required|min:2|max:100'
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
}
