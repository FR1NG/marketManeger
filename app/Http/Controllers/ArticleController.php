<?php

namespace App\Http\Controllers;

use App\Models\article;
use App\Models\categorie;
use App\Models\unit;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categories = categorie::withCount('articles')
            ->get();

        $units = unit::all();
        $query = article::query();
        $columnsToSearch  = [
            'name',
            'category',
            'unit',
            'notification_quantity',
        ];
        $search = '%' . $request->search . '%';
        $query->with(['category:id,name', 'unit:id,name']);
        // $query->with(['itemsInWarehouse:article_id,quantity']);
        $query->withSum('itemsInWarehouse', 'quantity');
        foreach ($columnsToSearch as $column) {
            if ($column == "category" || $column ==  "unit") {
                $query->orWhereHas($column, function ($q) use ($search) {
                    $q->orWhere('name', 'LIKE', $search);
                });
            } else {
                $query->orWhere($column, 'LIKE', $search);
            }
        }
        $articles = $query->paginate(10);
        $response = [
            'categories' => $categories,
            'units' => $units,
            'articles' => $articles,
        ];
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $article = new article();
        $request->validate([
            'name' => 'required|max:50|unique:articles',
            'category_id' => 'required|numeric',
            'unit_id' => 'required|numeric',
            'notification_quantity' => 'required|numeric',
        ]);
        $article->name = $request->name;
        $article->category_id = $request->category_id;
        $article->unit_id = $request->unit_id;
        $article->notification_quantity = $request->notification_quantity;
        $process = $article->save();
        if ($process) {
            return response()->json(['message' => 'L\'article a été créé avec succès'], 200);
        } else {
            return response()->json(['message' => 'L\'article n\'a pas été créé'], 500);
        }
    }

    public function update(Request $request)
    {
        $article = article::findOrFail($request->id);

        // validation
        $request->validate([
            'name' => 'required|max:50|unique:articles,name,' . $request->id,
            'category' => 'required|numeric',
            'unit' => 'required|numeric',
            'notificationQuantity' => 'required|numeric',
        ]);

        $article->name = $request->name;
        $article->category_id = $request->category;
        $article->unit_id = $request->unit;
        $article->notification_quantity = $request->notificationQuantity;
        $article->update();

        return response()->json(['message' => 'L\'article a été mise à jour avec succès'], 200);
    }

    public function delete(Request $request)
    {
        $article = article::where('id', '=', $request->id)->withCount(['achats', 'branchements'])->first();
        if ($article) {
            if ($article->branchements_count > 0 || $article->achats_count > 0) {
                return response()->json(['message' => 'Vous pouvez pas supprimer ce article'], 500);
            }
            $article->delete();
            return response()->json(['message' => 'Article éte supprimé'], 200);
        }
        return response()->json(['message' => 'Article introuvable'], 400);
    }
}
