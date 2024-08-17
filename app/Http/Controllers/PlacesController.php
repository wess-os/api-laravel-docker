<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PlacesController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    // method to list all places
    public function index()
    {
        return response()->json([
            "message" => "List of all places", 
            "data" => Place::orderBy('name')->get()
        ], 200);
    }

    // method to create a new place
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255|unique:places,name',
            'slug' => 'required|max:255',
            'city' => 'required|max:255',
            'state' => 'required|max:255',
        ]);

        $place = $request->user()->places()->create($fields);

        return response()->json([
            "message"=>"The place was created", 
            "data" => $place
        ], 201);
    }

    // method to show a place
    public function show(Place $place)
    {
        return response()->json([
            "message"=>"The place was shown", 
            "data" => $place
        ], 200);
    }

    // method to update a place
    public function update(Request $request, Place $place)
    {
        $fields = $request->validate([
            'name' => 'max:255|unique:places,name,' . $place->id,
            'slug' => 'max:255',
            'city' => 'max:255',
            'state' => 'max:255',
        ]);

        $place->update($fields);

        return response()->json([
            "message"=>"The place was updated", 
            "data" => $place
        ], 200);
    }

    // method to delete a place
    public function destroy(Place $place)
    {
        $place->delete();

        return response()->json([], 204);
    }
}
