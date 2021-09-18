<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\branchement;
use App\Models\warehouse;
use Illuminate\Http\Request;

class BranchementController extends Controller
{

    public function store(Request $request)
    {
        $branchement = new branchement();
        $request->validate([
            'contract_number' => 'required|max:255',
            'client_name' => 'required|max:100',
            'address' => 'required|max:255',
            'intervention' => 'required|max:100',
            'estimate_number' => 'required|max:100',
            'phone' => 'required|numeric|digits:10',
            'diameter' => 'max:255',
            'caliber' => 'required|max:255',
            'nature' => 'required|max:255',
            'arrival_date' => 'required|date',
            'motive' => 'max:255',
        ]);

        $branchement->contract_number = $request->contract_number;
        $branchement->client_name = $request->client_name;
        $branchement->address = $request->address;
        $branchement->intervention = $request->intervention;
        $branchement->estimate_number = $request->estimate_number;
        $branchement->phone = $request->phone;
        $branchement->diameter = $request->diameter;
        $branchement->caliber = $request->caliber;
        $branchement->nature = $request->nature;
        $branchement->arrival_date = $request->arrival_date;
        $branchement->motive = $request->motive;

        $process = $branchement->save();

        if ($process) {
            return response()->json(['message' => "Branchement a été créé avec succès", "branchement_id" => $branchement->id], 200);
        } else {
            return response()->json(['message' => "Branchement n'a pas été créée"], 500);
        }
    }

    public function create()
    {
        $articles = article::select('id', 'name')->get();

        return response()->json(['articles' => $articles]);
    }

    public function getItemPrice(Request $request)
    {
        $item = warehouse::where('article_id', '=', $request->id)
            ->with(['article:id,name'])
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'ASC')
            ->first();
        if ($item) {
            return response()->json(['item' => $item], 200);
        } else {
            return response()->json(['message' => 'cet article n\'est pas disponible en entrepôt'], 400);
        }
    }
}
