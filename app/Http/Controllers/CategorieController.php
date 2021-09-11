<?php

namespace App\Http\Controllers;

use App\Models\categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:50|unique:categories'
            ],
            [
                'name.unique' => 'Le nom a déjà été pris.'
            ]
        );
        $category = new categorie();
        $category->name = $request->name;
        $process = $category->save();
        if ($process) {
            return response()->json(['message' => 'La catégorie a été créée avec succès'], 200);
        } else {
            return response()->json(['message' => 'La catégorie n\'a pas été créée'], 500);
        }
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate(
            [
                'name' => 'required|max:50|unique:categories,name,' . $id
            ],
            [
                'name.unique' => 'Le nom a déjà été pris.'
            ]
        );
        $category = categorie::find($id);
        if ($category) {
            $category->name = $request->name;
            $process = $category->update();
            if ($process) {
                return response()->json(['message' => 'La catégorie a été mise à jour avec succès'], 200);
            } else {
                return response()->json(['message' => 'La catégorie n\'a pas été mise à jour'], 500);
            }
        }
    }

    public function delete(Request $request)
    {
        $category = categorie::find($request->id);
        if ($category) {
            $process = $category->delete();
            if ($process) {
                return response()->json(['message' => 'La catégorie a été supprimée avec succès'], 200);
            } else {
                return response()->json(['message' => 'La catégorie n\'a pas été supprimée'], 500);
            }
        }
    }
}
