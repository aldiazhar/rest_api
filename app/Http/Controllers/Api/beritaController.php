<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
// model
use App\berita;


class beritaController extends Controller
{
    public function index()
    {
    	$allBerita = berita::with('user')->get();

    	$message = 'Menamplikan semua berita!';

    	if (count($allBerita)<1) {
    		$message = 'Tidak ada berita!';
    	}

        return response([
            'success' => true,
            'message' => $message,
            'data' => $allBerita
        ], 200);
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string','min:3', 'max:255','regex:/(^[A-Za-z0-9 ]+$)+/' ,'unique:beritas'],
            'konten' => ['required'],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Ada Kesalahan!',
                'data'    => $validator->errors()
            ],400);

        } else {

            $simpanBerita = new berita;

	    	$simpanBerita->name = $request->name;
			$simpanBerita->konten = $request->konten;
			$simpanBerita->url = e($this->url($request->input('name')));

			$simpanBerita->save();

			$simpanBerita->categories()->sync($request->category);
			$simpanBerita->user()->sync($request->userid);

            if ($simpanBerita) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been saved!'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data has not been saved!'
                ], 400);
            }
        }
    }

    public function show($url)
    {
    	$showBerita = berita::where('url', $url)->firstOrFail();
    	
        if (!empty($showBerita)) {
            return response()->json([
                'success' => true,
                'message' => 'Details Berita!',
                'data'    => $showBerita
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Berita Tidak Ditemukan!',
                'data'    => $url
            ], 404);
        }
    }

    public function update(Request $request, $url)
    {
    	$updateBerita = berita::where('url', $url)->firstOrFail();

    	$validator = Validator::make($request->all(), [
            'name' => ['required', 'string','min:3', 'max:255','regex:/(^[A-Za-z0-9 ]+$)+/'],
            'konten' => ['required'],
        ]);

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Ada Kesalahan!',
                'data'    => $validator->errors()
            ],400);

        } else {

	    	$updateBerita->name = $request->name;
			$updateBerita->konten = $request->konten;
			$updateBerita->url = e($this->url($request->input('name')));

			$updateBerita->save();

			$updateBerita->categories()->sync($request->category);
			$updateBerita->user()->sync($request->userid);

            if ($updateBerita) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been update!'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data has not been update!'
                ], 400);
            }
        }
    }

    public function delete($id)
    {
    	$deleteBerita = berita::find($id);
    	if ($deleteBerita->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Berita Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Berita Gagal Dihapus!',
            ], 500);
        }
    }

    private function url($string) {
        $string = strtolower(trim($string));
        $string = preg_replace('/\s+/','-',$string);
        $string = preg_replace('/[^a-z0-9-]/','-',$string);
        $string = preg_replace('/-+/','-',$string);
        return rtrim($string,'-');
    }
}
