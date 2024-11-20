<?php

namespace App\Http\Controllers;

use App\Models\GroupMotorik;
use App\Models\KategoriMotorik;
use App\Models\Motorik;
use App\Models\Residen;
use App\Models\Semester;
use App\Models\TahunAjaran;
use App\Models\Tingkat;
use Illuminate\Http\Request;

class DatabaseResidenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataresiden = Residen::when($request->angkatanfk != null, function ($q) use ($request) {
            return $q->where('thnajaranfk', $request->angkatanfk);
        })->when($request->statuskuliah != null, function ($q) use ($request) {
            if ($request->statuskuliah == 'semua') {
                return $q;
            }
            return $q->where('statuskuliah', $request->statuskuliah);
        })->when($request->semesterfk != null, function ($q) use ($request) {
            return $q->where('semester', $request->semesterfk);
        })->when($request->tingkatfk != null, function ($q) use ($request) {
            return $q->where('tingkatfk', $request->tingkatfk);
        })->get();
        return view('page.database-residen.index', [
            'type_menu' => 'master-data',
            'motorik' => Motorik::all(),
            'angkatan' => TahunAjaran::where('aktif', 1)->get(),
            'semester' => Semester::all(),
            'tingkat' => Tingkat::all(),
            'dataresiden' => $dataresiden,
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
    public function show($id)
    {
        return view('page.database-residen.show', [
            'type_menu' => 'master-data',
            'residen' => Residen::findOrFail($id),
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
        return view('page.database-residen.edit', [
            'type_menu' => 'master-data',
            'residen' => Residen::findOrFail($id),
        ]);
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
        return dd($request->all());
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
