<?php

namespace App\Http\Controllers;

use App\Models\branchementChargers;
use Illuminate\Http\Request;

class BranchementChargersController extends Controller
{
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'branchement_id' => 'required|numeric',
            'nature' => 'required|max:100',
            'amount' => 'required|numeric',
        ]);
        // store data
        $charge = new branchementChargers();
        $charge->branchement_id = $request->branchement_id;
        $charge->nature = $request->nature;
        $charge->amount = $request->amount;
        $charge->save();
        return response()->json(['message' => 'Charge a été ajoutée avec succès']);
    }
}
