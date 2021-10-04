<?php

namespace App\Http\Controllers;

use App\Models\branchementImage;
use Illuminate\Http\Request;

class BranchementImageController extends Controller
{
    public function index(Request $request)
    {
        $images = branchementImage::where('branchement_id', '=', $request->branchement_id)
            ->paginate(10);
        return response()->json(['images' => $images]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
        ]);

        $fileUpload = new branchementImage();

        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            // $file_path = 
            $request->file('file')->storeAs('uploads', $file_name, 'public');

            $fileUpload->name = time() . '_' . $request->file->getClientOriginalName();
            $fileUpload->branchement_id = $request->branchement_id;
            // $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->save();

            return response()->json(['success' => 'File uploaded successfully.']);
        }
    }
}
