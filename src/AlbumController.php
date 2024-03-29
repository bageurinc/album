<?php
namespace Bageur\Album;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\Album\model\album;
use Illuminate\Support\Facades\Http;
use Validator;
class AlbumController extends Controller
{

    public function index(Request $request)
    {
       $query = album::datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'nama'		     		=> 'required|unique:bgr_album|min:3',
                        // 'group'                 => 'nullable|unique:bgr_album|min:3'
                    ];

        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $album              			= new album;
            $album->nama	                = $request->nama;
            $album->nama_seo	       		= Str::slug($request->nama);
            $album->group                   = $request->group;
            $album->group_seo               = Str::slug($request->group);
            $album->urutan                   = $request->urutan;
            $album->cover                   = $request->cover;
            $album->save();
            try {
                $response = Http::post('https://api.miccapro.com/api/training/getGallerynyaGroup', [
                    'training_jenis' => $album->group 
                ]);
            } catch (\Throwable $th) {
                // dd($th);
                //throw $th;
            }
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return album::findOrFail($id);
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
        $rules      = [
                        'nama'                  => 'required|unique:bgr_album,nama,'.$id.',id|min:2',
                      ];

        $messages   = [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            $album                          = album::findOrFail($id);
            $album->nama                    = $request->nama;
            $album->nama_seo                = Str::slug($request->nama);
            $album->group                   = $request->group;
            $album->group_seo               = Str::slug($request->group);
            $album->urutan                   = $request->urutan;
            $album->cover                   = $request->cover;
            $album->save();
            try {
                $response = Http::post('https://api.miccapro.com/api/training/getGallerynyaGroup', [
                    'training_jenis' => $album->group 
                ]);
            } catch (\Throwable $th) {
                // dd($th);
                //throw $th;
            }
            return response(['status' => true ,'text'    => 'has input'], 200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $delete = album::findOrFail($id);
          $nama = $delete->group;
          $delete->delete();
          try {
              $response = Http::post('https://api.miccapro.com/api/training/getGallerynyaGroup', [
                'training_jenis' => $nama
            ]);
          } catch (\Throwable $th) {
              // dd($th);
              //throw $th;
          }
          return response(['status' => true ,'text'    => 'has deleted'], 200); 
    }

}