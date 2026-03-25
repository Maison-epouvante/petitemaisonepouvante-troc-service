<?php

namespace App\Http\Controllers;

use App\Models\Troc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrocController extends Controller
{
    /**
     * Display a listing of the trocs.
     */
    public function index()
    {
        $trocs = Troc::all();
        return response()->json($trocs);
    }

    /**
     * Store a newly created troc in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:troc,echange,don',
            'status' => 'sometimes|string|max:255',
            'product_id' => 'nullable|integer',
            'product_id_offered' => 'nullable|integer',
            'product_id_wanted' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $trocData = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'status' => $request->status ?? 'available',
        ];

        // Ajouter les champs product selon le type
        if ($request->has('product_id')) {
            $trocData['product_id'] = $request->product_id;
        }
        if ($request->has('product_id_offered')) {
            $trocData['product_id_offered'] = $request->product_id_offered;
        }
        if ($request->has('product_id_wanted')) {
            $trocData['product_id_wanted'] = $request->product_id_wanted;
        }

        $troc = Troc::create($trocData);

        return response()->json($troc, 201);
    }

    /**
     * Display the specified troc.
     */
    public function show($id)
    {
        $troc = Troc::find($id);

        if (!$troc) {
            return response()->json(['message' => 'Troc not found'], 404);
        }

        return response()->json($troc);
    }

    /**
     * Update the specified troc in storage.
     */
    public function update(Request $request, $id)
    {
        $troc = Troc::find($id);

        if (!$troc) {
            return response()->json(['message' => 'Troc not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|required|integer',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|required|string|in:troc,echange,don',
            'status' => 'sometimes|string|max:255',
            'product_id' => 'nullable|integer',
            'product_id_offered' => 'nullable|integer',
            'product_id_wanted' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $troc->update($request->all());

        return response()->json($troc);
    }

    /**
     * Remove the specified troc from storage.
     */
    public function destroy($id)
    {
        $troc = Troc::find($id);

        if (!$troc) {
            return response()->json(['message' => 'Troc not found'], 404);
        }

        $troc->delete();

        return response()->json(['message' => 'Troc deleted successfully']);
    }
}
