<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Villa;

class VillaController extends Controller
{
    public function index()
    {
        $villas = Villa::all();

        $response = [
            'message' => 'List of all villas',
            'villas' => $villas
        ];

        return response()->json($response, 200);
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'imageUrl' => 'required',
            'description' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'kapasitas' => 'required',
            'fasilitas' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
                    
         ]);

        $imageUrl = $request->input('imageUrl');
        $description = $request->input('description');
        $nama = $request->input('nama');
        $harga = $request->input('harga');
        $kapasitas = $request->input('kapasitas');
        $fasilitas = $request->input('fasilitas');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
         $villa = new Villa([

            'imageUrl' => $imageUrl,
            'description' => $description,
            'nama' => $nama,
            'harga' => $harga,
            'kapasitas' => $kapasitas,
            'fasilitas' => $fasilitas,
            'latitude' => $latitude,
            'longitude' => $longitude

         ]);

     
         if ($villa->save()) {


             $message = [
                 'message' => 'villa created',
                 'villa' => $villa
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
        $villa = Villa::with('aktivitas')->where('id', $id)->firstOrFail();

        $response = [
            'message' => 'villa information',
            'villa' => $villa
        ];
        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'imageUrl' => 'required',
            'description' => 'required',
            'nama' => 'required',
            'harga' => 'required',
            'kapasitas' => 'required',
            'fasilitas' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
                    
         ]);

        $imageUrl = $request->input('imageUrl');
        $description = $request->input('description');
        $nama = $request->input('nama');
        $harga = $request->input('harga');
        $kapasitas = $request->input('kapasitas');
        $fasilitas = $request->input('fasilitas');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        $villa = Villa::findOrFail($id);

        $villa->imageUrl = $imageUrl;
        $villa->description = $description;
        $villa->nama = $nama;
        $villa->harga = $harga;
        $villa->kapasitas = $kapasitas;
        $villa->fasilitas = $fasilitas;
        $villa->latitude = $latitude;
        $villa->longitude = $longitude;


        if(!$villa->update()){
            return response()->json([
                'message' => 'Error during update'
            ], 404);
        }

        $response = [
            'message' => 'villa Updated',
            'villa' => $villa
        ];

        return response()->json($response, 200);
    }

    public function destroy($id)
    {
        $villa = Villa::findOrFail($id);

        if(!$villa->delete()){
            return response()->json([
                'message' => 'Deletion Failed'
            ], 404);
        }

        $response = [
            'message' => 'villa deleted',
        ];

        return response()->json($response, 200);
    }

    
}
