<?php

namespace App\Http\Controllers;

use App\Models\achat;
use App\Models\article;
use App\Models\articleEnAchat;
use App\Models\fournisseur;
use App\Models\market;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchatController extends Controller
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
        $achats = achat::withCount('items')
            ->where('market_id', '=', $this->market_id)
            ->with(['fournisseur:id,name'])
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return response()->json(['achats' => $achats]);
    }


    public function create()
    {
        $articles = article::select('id', 'name')
            ->get();
        $fournisseurs = fournisseur::select('id', 'name')
            ->where('market_id', '=', $this->market_id)
            ->get();
        $response = [
            'articles' => $articles,
            'fournisseurs' => $fournisseurs
        ];
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ndbc' => 'required|max:255|unique:achats,ndbc,NULL,id,market_id,' . $this->market_id,
            'fournisseur' => 'required|numeric',
            'payment_mode' => 'required',
            'deadline' => 'required|date|after:yesterday',
            'amount' => 'required|numeric|min:0',
            'items' => 'required',
            'items.*.article_id' => 'required',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.quantity' => 'required|numeric|min:0'
        ]);

        $achat = new achat();
        $achat->ndbc = $request->ndbc;
        $achat->market_id = $this->market_id;
        $achat->fournisseur_id = $request->fournisseur;
        $achat->payment_mode = $request->payment_mode;
        $request->check_number ?  $achat->check_number = $request->check_number : null;
        $achat->deadline = $request->deadline;
        $achat->amount = $request->amount;
        $process = $achat->save();
        if ($process) {
            $achat_id = $achat->id;
            $items = $request->items;
            if (count($items) > 0) {
                foreach ($items as $item) {
                    articleEnAchat::create([
                        'achat_id' => $achat_id,
                        'article_id' => $item['article_id'],
                        'price' => $item['price'],
                        'quantity' => $item['quantity'],
                    ]);
                }
            }
            return response()->json(['message' => 'L\'achat a été créé avec succès'], 200);
        } else {
            return response()->json(['message' => 'L\'achat n\'a pas été créé'], 500);
        }
    }

    public function details(Request $request)
    {
        $achat = achat::where('id', '=', $request->id)
            ->where('market_id', '=', $this->market_id)
            ->with(['items', 'fournisseur:id,name', 'items.article:id,name', 'livraisons'])
            ->first();
        if ($achat) {
            return response()->json(['achat' => $achat]);
        }
    }
}
