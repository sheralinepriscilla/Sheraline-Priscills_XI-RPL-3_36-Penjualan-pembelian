<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ModelPenjualann;
use App\ModelBarangg;
use Validator;

class Penjualann extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ModelPenjualann::all();

        return view('penjualann', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualann_create');
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

        $data = new ModelPenjualann();
        $data->kd_barang = $request->kd_barang;
        $data->jumlah = $request->jumlah;
        $data->total_harga = $request->total_harga;
        $data->save();

        //ini merubah data dari controller barang
        $dataJual = ModelBarangg::where('kd_barang', $request->kd_barang)->first();
        $dataJual->stok = $dataJual->stok -  $request->jumlah;
        $dataJual->save();


        return redirect()->route('penjualann.index')->with('alert_message', 'Berhasil menambah data!');
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
        $data = ModelPenjualann::where('id', $id)->get();
        return view('penjualann_edit', compact('data'));
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

        $data = ModelPenjualann::where('id', $id)->first();
        $data-> kd_barang = $request->kd_barang;
        $data-> jumlah = $request->jumlah;
        $data-> total_harga = $request->total_harga;
        $data-> save();

        return redirect()->route('penjualann.index')->with('alert_message', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ModelPenjualann::where('id', $id)->first();
        $data->delete();
        return redirect()->route('penjualann.index')->with('alert_message', 'Berhasil menghapus data!');
    }
}
