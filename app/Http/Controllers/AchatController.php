<?php

namespace App\Http\Controllers;

use App\Models\achat;
use App\Models\article;
use App\Models\articleEnAchat;
use App\Models\fournisseur;
use Illuminate\Http\Request;

class AchatController extends Controller
{

    public function index(Request $request)
    {
        $achats = achat::withCount('items')
            ->with(['fournisseur:id,name'])
            ->paginate(10);
        return response()->json(['achats' => $achats]);
    }


    public function create()
    {
        $articles = article::select('id', 'name')
            ->get();
        $fournisseurs = fournisseur::select('id', 'name')
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
            'ndbc' => 'required|max:255',
            'fournisseur' => 'required|numeric',
            'payment_mode' => 'required',
            'deadline' => 'required|date',
            'amount' => 'required|numeric',
            'items' => 'required',
            'items.*.article_id' => 'required',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|numeric'
        ]);

        $achat = new achat();
        $achat->ndbc = $request->ndbc;
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
            ->with(['items', 'fournisseur:id,name', 'items.article:id,name', 'livraisons'])
            ->first();
        if ($achat) {
            return response()->json(['achat' => $achat]);
        }
    }
}
