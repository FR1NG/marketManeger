<?php

namespace App\Http\Controllers;

use App\Models\market;
use App\Models\User;
use App\Notifications\MarketCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            "user.name" => 'required|max:60|min:3|unique:users,name',
            "user.email" => 'required|email|unique:users,email',
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

        // send CREDENTUALS BY EMAIL
        // $user->notify(new MarketCreated($generatedPassword, $market, $user));

        return response()->json(['message' => 'market created', 'market_id' => $market->id]);
    }

    public function info(Request $request)
    {
        $market = market::where('id', '=', $request->id)->with('manager:id,name,email')->first();
        return response()->json(['market' => $market]);
    }

    public function update(Request $request)
    {
        // validate
        $request->validate([
            "id" => 'required',
            "user_id" => 'required',
            "name" => 'required|max:60|min:3',
            "market_number" => 'required|max:255',
            "amount" => 'required|numeric',
            "service_order_date" => 'required|date',
            "deadline_date" => 'required|date',
            "manager.name" => 'required|max:60|min:3',
            "manager.email" => 'required|email|unique:users,email,' . $request->user_id,
        ]);
        $market = market::findOrFail($request->id);
        $market->name = $request->name;
        $market->market_number = $request->market_number;
        $market->amount = $request->amount;
        $market->service_order_date = $request->service_order_date;
        $market->deadline_date = $request->deadline_date;
        $market->update();

        $user = User::findOrFail($request->user_id);
        $user->name = $request->manager["name"];
        $user->email = $request->manager["email"];
        $user->update();
        return response()->json(['message' => 'Les informations du marché ont été mises à jour']);
    }

    public function delete(Request $request)
    {
        if (Hash::check($request->password, Auth::user()->password) && Auth::user()->hasRole('admin')) {
            $market =  market::findOrFail($request->id);
            $market->delete();
            return response()->json(['message' => 'Le marché a été supprimé']);
        } else {
            return response()->json(['message' => 'Mot de passe incorrect'], 403);
        }
    }
}
