<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\branchement;
use App\Models\marketArticle;
use App\Models\marketCity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
        $branchements = marketArticle::where('market_id', '=', $this->market_id)
            ->withCount(['branchements' => function ($q) {
                $q->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }])
            ->get();
        $incom = 0;
        $count = 0;
        foreach ($branchements as $item) {
            $incom += ($item->unit_price * $item->branchements_count);
            $count += $item->branchements_count;
        }

        $articles = marketArticle::where('market_id', '=', $this->market_id)
            ->select(['id', 'display_name'])
            ->get();

        $citiesQuery = marketCity::query();
        $citiesQuery->where('market_id', '=', $this->market_id)
            ->select(['id', 'name']);
        if ($request->type) {
            $citiesQuery->withCount(['branchements' => function ($q) use ($request) {
                $q->where('market_article_id', '=', $request->type);
            }]);
        } else {
            $citiesQuery->withCount('branchements');
        }
        $cities = $citiesQuery->get();

        // Build an array of the dates we want to show, oldest first
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates->put($date, 0);
        }

        // Get the post counts
        $query = branchement::query();
        if ($request->type) {
            $query->where('market_article_id', '=', $request->type);
        }
        $weekBranchements = $query->where('created_at', '>=', $dates->keys()->first())
            ->where('market_id', '=', $this->market_id)
            ->groupBy('date')
            ->orderBy('date')
            ->get([
                DB::raw('DATE( created_at ) as date'),
                DB::raw('COUNT( * ) as "count"')
            ])
            ->pluck('count', 'date');

        // accomplishement
        $articlesQuery = marketArticle::query();
        if ($request->type) {
            $articlesQuery->where('id', '=', $request->type);
        }
        $marketArticles = $articlesQuery->where('market_id', '=', $this->market_id)
            ->withCount('branchements')
            ->get();
        $branchements_count = 0;
        $quantity = 0;
        foreach ($marketArticles as $item) {
            $branchements_count += $item->branchements_count;
            $quantity += $item->quantity;
        }
        $accomplishement = [$branchements_count, ($quantity - $branchements_count)];

        return response()->json([
            'branchements' => $branchements,
            'incom' => $incom,
            'branchements_count' => $count,
            'articles' => $articles,
            'cities' => $cities,
            'weekBranchements' => $weekBranchements,
            'accomplishement' => $accomplishement,
        ]);
    }


    public function getAccomlishment(Request $request)
    {
        $article = marketArticle::where('market_id', '=', $this->market_id)
            ->where('id', '=', $request->id)
            ->withCount('branchements')
            ->first();
        $data = [$article->branchements_count, ($article->quantity - $article->branchements_count)];
        return response()->json($data);
    }
}
