<?php

namespace App\Http\Controllers;

use App\Models\achat;
use App\Models\articleEnAchat;
use App\Models\articleEnLivraison;
use App\Models\livraison;
use App\Models\warehouse;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'achat_id' => 'required',
            'dilevery_note_number' => 'required|max:255',
            'date' => 'required|date',
            'delivery_man' => 'max:60',
            'delivery_cost' => 'numeric',
            'items.*.article_id' => 'required',
            'items.*.quantity' => 'required',
        ]);

        $livraison = new livraison();
        $livraison->achat_id = $request->achat_id;
        $livraison->dilevery_note_number = $request->dilevery_note_number;
        $livraison->date = $request->date;
        $livraison->delivery_man = $request->delivery_man;
        $livraison->delivery_cost = $request->delivery_cost;
        $process = $livraison->save();
        if ($process) {
            foreach ($request->items as $item) {
                $article = new articleEnLivraison();
                $article->achat_id = $request->achat_id;
                $article->article_id = $item['article_id'];
                $article->livraison_id = $livraison->id;
                $article->quantity = $item['quantity'];
                $articleProcess = $article->save();
                if ($articleProcess) {
                    $articleEnAchat = articleEnAchat::where('article_id', '=', $item['article_id'])
                        ->where('achat_id', '=', $request->achat_id)
                        ->first();
                    // add warehouse entry
                    $warehouse = new warehouse();
                    $warehouse->article_id = $item['article_id'];
                    $warehouse->quantity = $item['quantity'];
                    $warehouse->price = $articleEnAchat->price;
                    $warehouse->save();

                    // update livered quantity
                    $articleEnAchat->livred_quantity += $item['quantity'];
                    $articleEnAchat->update();
                }
            }
        }
        return response()->json(['message' => 'La livraison a été créée avec succès']);
    }

    public function details(Request $request)
    {
        $livraison = livraison::where('id', '=', $request->id)
            ->with(['itemsInDelivery.article:id,name', 'achat:id,ndbc'])
            ->first();
        if ($livraison) {
            return response()->json(['livraison' => $livraison], 200);
        } else {
            return response()->json(['message' => 'Livraison introuvable'], 404);
        }
    }
}
