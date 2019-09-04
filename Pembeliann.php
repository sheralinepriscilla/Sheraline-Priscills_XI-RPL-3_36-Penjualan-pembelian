<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelPembeliann;
use App\ModelBarangg;
use Validator;


class Pembeliann extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ModelPembeliann::all();

        return view('pembeliann', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pembeliann_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kd_barang' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required',
        ]);

        //menambahkan data pembelian
        $data = new ModelPembeliann();
        $data->kd_barang = $request->kd_barang;
        $data->jumlah = $request->jumlah;
        $data->total_harga = $request->total_harga;
        $data->save();

        //ini merubah data dari controller barang
        $dataBeli = ModelBarangg::where('kd_barang', $request->kd_barang)->first();
        //x = x - 1;
        $dataBeli->stok = $dataBeli->stok + $request->jumlah;
        $dataBeli->save();


        //ini merubah stok ditambah
       
        return redirect()->route('pembeliann.index')->with('alert_message', 'Berhasil menambah data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ModelPembeliann::where('id', $id)->get();
        return view('pembeliann_edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kd_barang' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required',
            
        ]);

        $data = ModelPembeliann::where('id', $id)->first();
        $data = new modelpembeliann();
        $data->kd_barang = $request->kd_barang;
        $data->jumlah = $request->jumlah;
        $data->total_harga = $request->total_harga;
        $data-> save();

        return redirect()->route('pembeliann.index')->with('alert_message', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ModelPembeliann::where('id', $id)->first();
        $data->delete();
        return redirect()->route('pembeliann.index')->with('alert_message', 'Berhasil menghapus data!');
    }
}
