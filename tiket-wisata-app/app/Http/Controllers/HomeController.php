<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use App\Models\Pemesan;

class HomeController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Wisata::paginate(5);
        return view('index', compact('data'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'nama' => 'required|string|max:255',
            'identitas' => 'required|string|max:50',
            'no_hp' => 'required|string|max:20',
            'tempat' => 'required|integer|min:0',
            'tanggal' => 'required|date',
            'dewasa' => 'required|integer|min:0',
            'anak' => 'required|integer|min:0',
            'total-bayar' => 'required|string|min:0'
        ]);

        // Create a new Wisata entry (you may need to adjust depending on your form structure)
        $pemesanan = new Pemesan();
        $pemesanan->nama = $request->input('nama');
        $pemesanan->no_identitas = $request->input('identitas');
        $pemesanan->no_hp = $request->input('no_hp');
        $pemesanan->id_wisata = $request->input('tempat'); // Assuming you have a foreign key relationship
        $pemesanan->tanggal_kunjungan = $request->input('tanggal');
        $pemesanan->dewasa = $request->input('dewasa');
        $pemesanan->anak = $request->input('anak');
        $pemesanan->total_bayar = $request->input('total-bayar');
        
        // Save the data
        $cek = $pemesanan->save();

        if($cek){
            return redirect()->back()->with('success', 'Berhasil melakukan pesan tiket'); 
        }else{
            return redirect()->back()->with('error','Gagal melakukan pemesanan tiket');
        }
    }
}
