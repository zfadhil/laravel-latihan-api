<?php

namespace App\Http\Controllers;

use App\Models\Notes;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function index(){
        $notes = Notes::all();
        return response()->json([
            'message' => 'success',
            'data' => $notes
        ], 200);
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_pin' => 'required'
        ]);

        $note = Notes::create($request->all());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $note->$image = $image_name;
            $note->save();
        }

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 201);
    }

    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_pin' => 'required'
        ]);

        $note = Notes::find($id);
        $note->update($request->all());

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move('images', $image_name);
            $note->$image = $image_name;
            $note->save();
        }

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 201);
    }

    public function destroy($id){
        $note = Notes::find($id);
        $note->delete();

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 201);
    }

    public function show($id){
        $note = Notes::find($id);

        return response()->json([
            'message' => 'success',
            'data' => $note
        ], 201);
    }
}
