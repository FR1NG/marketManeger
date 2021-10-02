<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
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

    public function index(Request $request)
    {
        $warehouse = article::with(['itemsInWarehouse' => function ($q) {
            $q->where('market_id', '=', $this->market_id);
        }])->get()
            ->map(function ($article) {
                return [
                    'id'             => $article->id,
                    'name'           => $article->name,
                    'quantity'          => $article->itemsInWarehouse->sum('quantity'),
                    'notification_quantity'           => $article->notification_quantity,
                ];
            });;

        return response()->json(['items' => $warehouse]);
    }
}
