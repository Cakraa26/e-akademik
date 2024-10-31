<?php

namespace App\Http\Controllers;

use App\Models\CalonResiden;
use App\Models\GroupMotorik;
use App\Models\Kategori;
use App\Models\Motorik;
use App\Models\Residen;
use App\Models\TMotorik;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_menu = "master-data";
        $residen = Residen::where('statuskuliah', '0')->where('aktif', '0')->get();
        return view('page.data-mahasiswa.index', [
            'type_menu' => $type_menu,
            'residen' => $residen,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $residen = Residen::findOrFail($id);
        $type_menu = "master-data";
        $m_group_motorik = GroupMotorik::all();
        $m_kategori_motorik = Kategori::all();
        return view('page.data-mahasiswa.show', [
            'residen' => $residen,
            'tmotorik' => $residen->tmotorik,
            'type_menu' => $type_menu,
            'm_group_motorik' => $m_group_motorik,
            'm_kategori_motorik' => $m_kategori_motorik,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
