<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    private $market_id;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->hasRole('admin')) {
                $this->market_id = $request->market_id;
            } else {
                $this->market_id = Auth::user()->market->id;
            }

            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('spa');
    }

    public function admin()
    {
        return view('admin');
    }

    public function manager()
    {
        return view('manager');
    }

    public function market(Request $request)
    {
        $market_id = $request->market_id;
        return view('market', compact('market_id'));
    }
}
