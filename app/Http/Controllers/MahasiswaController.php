<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PDF;

class MahasiswaController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|alpha_dash|min:4|max:20|unique:App\Models\Mahasiswa',
            'nama' => 'required|string|max:50',
            'email' => 'required|string|email:rfc,dns|unique:App\Models\Mahasiswa',
            'password' => 'required|min:8',
            'berkas' => 'required|mimes:jpg,png|max:100'
        ];

        $validator =  Validator::make($request->all(), $rules);

        if($validator->fails()){
            return view('index')->with('error', $validator->errors());
        }

        $file = $request->file('berkas');

        $name = $request->file('berkas')->getClientOriginalName();

        if($file){
            $file->move(public_path('images'),$name);
        }

        Mahasiswa::create([
            'username' => $request->input('username'),
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'avatar' => $name
        ]);

        return view('index')->with('success', 'Artikel berhasil disimpan');
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
        $data =  Mahasiswa::find($id);

        return (!$data)? view('no_data') :
                    view('edit')
                    ->with('id', $id)
                    ->with('data', $data);
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
        $rules = [
            'username' => 'required|alpha_dash|min:4|max:20|unique:App\Models\Mahasiswa,user_id,'.$id,
            'nama' => 'required|string|max:50',
            'email' => 'required|string|email:rfc,dns',
            'password' => 'required|min:8',
            'berkas' => 'required|mimes:jpg,png|max:100'
        ];

        $validator =  Validator::make($request->all(), $rules);

        $data =  Mahasiswa::find($id);

        if($validator->fails()){
            return view('edit')
                    ->with('error', $validator->errors())
                    ->with('id', $id)
                    ->with('data', $data);
        }

        $file = $request->file('berkas');
        $name = $request->file('berkas')->getClientOriginalName();
        if($file){
            $file->move(public_path('images'), $name);

            // if(Storage::exists('public/images/' . $data->avatar)){
            //     Storage::delete('public/images/' . $data->avatar);
            // }
        }

        Mahasiswa::where('user_id', $id)
                ->update([
                    'username' => $request->input('username'),
                    'nama' => $request->input('nama'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password'),
                    'avatar' => $name
                ]);


        return  view('edit')
            ->with('id', $id)
            ->with('data', $data)
            ->with('success','data berhasil disimpan');
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

    public function cetak_pdf()
    {
        $data = Mahasiswa::all();
        
        //return view('cetak_pdf', ['data' => $data]);

        $pdf =  PDF::loadView('cetak_pdf', ['data' => $data]);
        return $pdf->stream();
    }
}
