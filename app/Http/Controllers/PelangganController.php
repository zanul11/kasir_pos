<?php

namespace App\Http\Controllers;

use App\Http\Requests\PelangganRequest;
use App\Models\Pelanggan;
use  Yajra\Datatables\DataTables;

class PelangganController extends Controller
{
    protected   $data = [
        'category_name' => 'data_master',
        'page_name' => 'pelanggan',
    ];

    public function data()
    {
        $data =  Pelanggan::query()
            ->select(['*']);

        return DataTables::of($data)
            ->addColumn('user_detail', function ($data) {
                return '<small> ' . $data->user . '</br>' . $data->updated_at . '</small>';
            })
            ->addColumn('action', function ($data) {
                $edit = '<a href="' . route('pelanggan.edit', $data->id) . '" class="text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </a>';

                $delete = "<a href='#' onclick='fn_deleteData(" . '"' . route('pelanggan.destroy', $data->id) . '"' . ")' class='text-danger' title='Hapus Data'>
                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'><polyline points='3 6 5 6 21 6'></polyline><path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path><line x1='10' y1='11' x2='10' y2='17'></line><line x1='14' y1='11' x2='14' y2='17'></line></svg></a>";

                return $edit . '  ' . $delete;
            })
            ->rawColumns(['action', 'user_detail'])
            ->make(true);
    }

    public function index()
    {
        return view('pages.datamaster.pelanggan.index')->with($this->data);
    }

    public function create()
    {
        return view('pages.datamaster.pelanggan.create')->with($this->data);
    }

    public function store(PelangganRequest $request)
    {
        try {
            Pelanggan::create($request->validated());
            alert()->success('Success !!', 'Data berhasil disimpan');
            return redirect()->route('pelanggan.index');
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return back()->withInput();
        }
    }


    public function show(Pelanggan $pelanggan)
    {
        //
    }


    public function edit(Pelanggan $pelanggan)
    {
        return view('pages.datamaster.pelanggan.create', compact('pelanggan'))->with($this->data);
    }


    public function update(PelangganRequest $request, Pelanggan $pelanggan)
    {
        try {
            $pelanggan->update($request->validated());
            alert()->success('Success !!', 'Data berhasil diupdate');
            return redirect()->route('pelanggan.index');
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return back()->withInput();
        }
    }

    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $pelanggan->delete();
            alert()->success('Deleted !!', 'Data berhasil dihapus !');
            return response()->json(["success" => "Data berhasil dihapus !"], 200);
        } catch (\Throwable $th) {
            alert()->error('Oppss !!', $th->getMessage());
            return response()->json(["error" => $th->getMessage()], 501);
        }
    }
}
