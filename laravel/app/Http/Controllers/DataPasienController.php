<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataPasien;
use App\Pasien;

class DataPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datapasiens = DataPasien::all();
        foreach($datapasiens as $datapasien){
            $datapasien->dataview_pasien = [
                'href' => 'api/v1/datapasien/' . $datapasien->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'message' => 'List of all datapasiens',
            'datapasiens' => $datapasiens
        ];

        return response()->json($response, 200);
    }

    
    public function store(Request $request)
    {
        $this->validate($request,[
            'norekammedik' => 'required',
            'nama' => 'required',
            'tanggallahir' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'kodediagnosa' => 'required',
            'kodedx' => 'required',
            'terapi' => 'required',
            'dosis' => 'required',
            'pmo' => 'required'
         ]);
 
         $norekammedik = $request->input('norekammedik');
         $nama = $request->input('nama');
         $tanggallahir = $request->input('tanggallahir');
         $umur = $request->input('umur');
         $alamat = $request->input('alamat');
         $kodediagnosa = $request->input('kodediagnosa');
         $kodedx = $request->input('kodedx');
         $terapi = $request->input('terapi');
         $dosis = $request->input('dosis');
         $pmo = $request->input('pmo');
 
         $datapasien = new DataPasien([
             'norekammedik' => $norekammedik,
             'nama' => $nama,
             'tanggallahir' => $tanggallahir,
             'umur' => $umur,
             'alamat' => $alamat,
             'kodediagnosa' => $kodediagnosa,
             'kodedx' => $kodedx,
             'terapi' => $terapi,
             'dosis' => $dosis,
             'pmo' => $pmo
         ]);

     
         if ($datapasien->save()) {

             $pasien = new Pasien([
                 'name' => $norekammedik,
                 'password' => bcrypt($norekammedik)
             ]);

            $pasien->save();

             $datapasien->view_datapasien = [
                 'href' => 'api/v1/datapasien/' . $datapasien->id,
                 'method' => 'GET'
             ];
             $message = [
                 'message' => 'datapasien created',
                 'datapasien' => $datapasien
             ];
             return response()->json($message, 201);
         }
 
         $response = [
             'message' => 'Error during creationg'
         ];
 
         return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($norekammedik)
    {
        $datapasien = DataPasien::with('jadwal_minums')->with('jadwal_obats')->where('norekammedik', $norekammedik)->firstOrFail();
        $datapasien->view_datapasiens = [
            'href' => 'api/v1/datapasien',
            'method' => 'GET'
        ];

        $response = [
            'message' => 'datapasien information',
            'datapasien' => $datapasien
        ];
        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'norekammedik' => 'required',
            'nama' => 'required',
            'tanggallahir' => 'required',
            'umur' => 'required',
            'alamat' => 'required',
            'kodediagnosa' => 'required',
            'kodedx' => 'required',
            'terapi' => 'required',
            'dosis' => 'required',
            'pmo' => 'required'
         ]);
 
         $norekammedik = $request->input('norekammedik');
         $nama = $request->input('nama');
         $tanggallahir = $request->input('tanggallahir');
         $umur = $request->input('umur');
         $alamat = $request->input('alamat');
         $kodediagnosa = $request->input('kodediagnosa');
         $kodedx = $request->input('kodedx');
         $terapi = $request->input('terapi');
         $dosis = $request->input('dosis');
         $pmo = $request->input('pmo');

        $datapasien = DataPasien::findOrFail($id);

        $datapasien->norekammedik = $norekammedik;
        $datapasien->nama = $nama;
        $datapasien->tanggallahir = $tanggallahir;
        $datapasien->umur = $umur;
        $datapasien->alamat = $alamat;
        $datapasien->kodediagnosa = $kodediagnosa;
        $datapasien->kodedx = $kodedx;
        $datapasien->terapi = $terapi;
        $datapasien->dosis = $dosis;
        $datapasien->pmo = $pmo;

        if(!$datapasien->update()){
            return response()->json([
                'message' => 'Error during update'
            ], 404);
        }

        $datapasien->view_datapasien = [
            'href' => 'api/v1/datapasien/' . $datapasien->id,
            'method' => 'GET'
        ];

        $response = [
            'message' => 'datapasien Updated',
            'datapasien' => $datapasien
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $datapasien = DataPasien::findOrFail($id);

        if(!$datapasien->delete()){
            return response()->json([
                'message' => 'Deletion Failed'
            ], 404);
        }

        $response = [
            'message' => 'datapasien deleted',
            'create' => [
                'href' => 'api/v1/datapasien',
                'method' => 'POST',
                'params' => 'title, description, time'
            ]
        ];

        return response()->json($response, 200);
    }

    public function getall()
    {
        $datapasiens = DataPasien::with('jadwal_minums')->with('jadwal_obats')->get();

        foreach($datapasiens as $datapasien){
            $datapasien->dataview_pasien = [
                'href' => 'api/v1/datapasien/' . $datapasien->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'message' => 'List of all datapasiens',
            'datapasiens' => $datapasiens
        ];

        return response()->json($response, 200);
    }
}
