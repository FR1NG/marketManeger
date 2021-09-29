<?php

namespace App\Http\Controllers;

use App\Models\market;
use App\Models\User;
use App\Notifications\MarketCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $markets = market::with('manager:id,name')
            ->paginate(10);
        return response()->json(['markets' => $markets]);
    }


    public function store(Request $request)
    {
        // validate
        $request->validate([
            "name" => 'required|max:60|min:3',
            "market_number" => 'required|max:255',
            "amount" => 'required|numeric',
            "service_order_date" => 'required|date',
            "deadline_date" => 'required|date',
            "user.name" => 'required|max:60|min:3',
            "user.email" => 'required|email',
        ]);
        // create user
        $user = new User();
        $generatedPassword = Str::random(10);
        $user->name = $request->user['name'];
        $user->email = $request->user['email'];
        $user->password = Hash::make($generatedPassword);
        $user->save();

        // attach role
        $user->attachRole('manager');
        // create market
        $market = new market();
        $market->name = $request->name;
        $market->market_number = $request->market_number;
        $market->amount = $request->amount;
        $market->service_order_date = $request->service_order_date;
        $market->deadline_date = $request->deadline_date;
        $market->user_id = $user->id;
        $market->save();

        $user->notify(new MarketCreated($generatedPassword, $market, $user));

        return response()->json(['message' => 'market created', 'market_id' => $market->id]);
    }

    public function info(Request $request)
    {
        $market = market::where('id', '=', $request->id)->with('manager:id,name,email')->first();
        return response()->json(['market' => $market]);
    }
}
