<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class AuthorsController extends BaseController
{
    public function index()
    {
    return Author::all();
    }  

    public function show($id)
    {
    $penulis = Author::find($id);
    if($penulis){
        return $penulis;
    }else {
        return response()->json(['message' => 'Author not found'], 404);
    }
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'biography' => 'required'
        ]);

    $penulis = Author::create(
        $request->only(['id', 'name', 'gender', 'biography'])
        );

        return response()->json([
            'created' => true,
            'data' => $penulis
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $penulis = Author::findOrFail($id);
        } catch (ModelNotFoundException $e){
            return response()->json([
                'message' => 'author not found'
            ], 404);
        }

        $penulis->fill(
            $request->only(['id', 'name', 'gender', 'biography'])
        );
        $penulis->save();

        return response()->json([
            'update' => true,
            'data'  => $penulis
        ], 200);

    }

    public function destroy($id)
    {
        try{
            $penulis = Author::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'author not found'
                ]
                ], 404);
        }

        $penulis->delete();

        return response()->json([
            'deleted' => true
        ], 200);
    }

}


