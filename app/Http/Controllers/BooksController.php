<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

use Laravel\Lumen\Routing\Controller as BaseController;

class BooksController extends BaseController
{
    public function index()
    {
    return Book::all();
    }  

    public function show($id)
    {
    $buku = Book::find($id);
    if($buku){
        return $buku;
    }else {
        return response()->json(['message' => 'Book not found'], 404);
    }
}
    public function store (Request $request)
    {
        $this->validate($request, [
            'title' => 'required', 
            'description' => 'required',
            'author' => 'required'
        ]);

    $book = Book::create(
        $request->only(['title', 'description', 'author'])
        );

        return response()->json([
            'created' => true,
            'data' => $book
        ], 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $book = Book::findOrFail($id);
        } catch (ModelNotFoundException $e){
            return response()->json([
                'message' => 'book not found'
            ], 404);
        }

        $book->fill(
            $request->only(['title', 'description', 'author'])
        );
        $book->save();

        return response()->json([
            'update' => true,
            'data'  => $book
        ], 200);

    }

    public function destroy($id)
    {
        try{
            $book = Book::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => [
                    'message' => 'book not found'
                ]
                ], 404);
        }

        $book->delete();

        return response()->json([
            'deleted' => true
        ], 200);
    }
}

