<?php

namespace App\Http\Controllers;

use App\Models\unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function store(Request $request)
    {
        $unit = new unit();
        $request->validate([
            'name' => 'required|max:50|unique:units',
            'abr' => 'required|max:50|unique:units',
            'description' => 'max:255'
        ]);
        $unit->name = $request->name;
        $unit->abr = $request->abr;
        $unit->description = $request->description;
        $process = $unit->save();
        if ($process) {
            return response()->json(['message' => 'L\'unité a été créée avec succès'], 200);
        } else {
            return response()->json(['message' => 'l\'unité n\'a pas été créée'], 500);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate(
            [
                'name' => 'required|max:50|unique:units,name,' . $id,
                'abr' => 'required|max:50|unique:units,abr,' . $id,
                'name' => 'max:255',
            ],
            [
                'name.unique' => 'Le nom a déjà été pris.',
                'abr.unique' => 'Le nom a déjà été pris.'
            ]
        );
        $unit = unit::find($id);
        if ($unit) {
            $unit->name = $request->name;
            $unit->abr = $request->abr;
            $unit->description = $request->description;
            $process = $unit->update();
            if ($process) {
                return response()->json(['message' => 'L\'unité a été mise à jour avec succès'], 200);
            } else {
                return response()->json(['message' => 'L\'unité n\'a pas été mise à jour'], 500);
            }
        }
    }

    public function delete(Request $request)
    {
        $unit = unit::where('id', '=', $request->id)->withCount('articles')->first();
        if ($unit) {
            if ($unit->articles_count > 0) {
                return response()->json(['message' => 'L\'unité n\'est pas vide'], 500);
            }
            $process = $unit->delete();
            if ($process) {
                return response()->json(['message' => 'L\'unité a été supprimée avec succès'], 200);
            } else {
                return response()->json(['message' => 'L\'unité n\'a pas été supprimée'], 500);
            }
        }
    }
}
