<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aktivitas;


class AktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = Aktivitas::all();

        $response = [
            'message' => 'List of all aktivitas',
            'aktivitas' => $aktivitas
        ];

        return response()->json($response, 200);
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[

            'villa_id' => 'required',
            'imageUrl' => 'required',
            'name' => 'required',
            'type' => 'required',
            'startTimes' => 'required',
            'rating' => 'required',
            'price' => 'required',

         ]);

        $villa_id = $request->input('villa_id');
        $imageUrl = $request->input('imageUrl');
        $name = $request->input('name');
        $type = $request->input('type');
        $startTimes = $request->input('startTimes');
        $rating = $request->input('rating');
        $price = $request->input('price');

            
        
         $aktivitas = new Aktivitas([

            'villa_id' => $villa_id,
            'imageUrl' => $imageUrl,
            'name' => $name,
            'type' => $type,
            'startTimes' => $startTimes,
            'rating' => $rating,
            'price' => $price

         ]);

     
         if ($aktivitas->save()) {


             $message = [
                 'message' => 'aktivitas created',
                 'aktivitas' => $aktivitas
             ];
             return response()->json($message, 201);
         }
 
         $response = [
             'message' => 'Error during creationg'
         ];
 
         return response()->json($response, 404);
    }

    
    public function show($id)
    {
        $aktivitas = Aktivitas::where('id', $id)->firstOrFail();

        $response = [
            'message' => 'aktivitas information',
            'aktivitas' => $aktivitas
        ];
        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[

            'villa_id' => 'required',
            'imageUrl' => 'required',
            'name' => 'required',
            'type' => 'required',
            'startTimes' => 'required',
            'rating' => 'required',
            'price' => 'required',

         ]);

        $villa_id = $request->input('villa_id');
        $imageUrl = $request->input('imageUrl');
        $name = $request->input('name');
        $type = $request->input('type');
        $startTimes = $request->input('startTimes');
        $rating = $request->input('rating');
        $price = $request->input('price');

        $aktivitas = Aktivitas::findOrFail($id);

        $aktivitas->villa_id = $villa_id;
        $aktivitas->imageUrl = $imageUrl;
        $aktivitas->name = $name;
        $aktivitas->type = $type;
        $aktivitas->startTimes = $startTimes;
        $aktivitas->rating = $rating;
        $aktivitas->price = $price;


        if(!$aktivitas->update()){
            return response()->json([
                'message' => 'Error during update'
            ], 404);
        }

        $response = [
            'message' => 'aktivitas Updated',
            'aktivitas' => $aktivitas
        ];

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $aktivitas = Aktivitas::findOrFail($id);

        if(!$aktivitas->delete()){
            return response()->json([
                'message' => 'Deletion Failed'
            ], 404);
        }

        $response = [
            'message' => 'aktivitas deleted',
        ];

        return response()->json($response, 200);
    }
}
