<?php
namespace Bageur\Album;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Bageur\Album\model\albumdetail;
use Bageur\Album\processors\UploadProcessor;
use Illuminate\Support\Facades\Http;
use Validator;
class AlbumdetailController extends Controller
{

    public function index(Request $request)
    {
       $query = albumdetail::datatable($request);
       return $query;
    }

    public function store(Request $request)
    {
        $rules    	= [
                        'gambar.*'		     		=> 'required|mimes:jpg,jpeg,png|max:2000',
                    ];

        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{

           $gambar = $request->file('gambar');
           for ($i=0; $i < count($gambar); $i++) {
                $upload                     = UploadProcessor::go($gambar[$i],'album');

                $albumdetail                    = new albumdetail;
                $albumdetail->album_id          = $request->album;
                $albumdetail->gambar            = $upload;
                $albumdetail->save();
           }
           try {
               $response = Http::post('https://api.miccapro.com/api/company/repairGallery');
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
        return albumdetail::findOrFail($id);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $delete = albumdetail::findOrFail($id);
          $delete->delete();
          try {
              $response = Http::post('https://api.miccapro.com/api/training/repairGallery');
          } catch (\Throwable $th) {
              // dd($th);
              //throw $th;
          }
          return response(['status' => true ,'text'    => 'has deleted'], 200);
    }

    public function urutan(Request $request)
    {
        $up         = albumdetail::find($request->id);
        $up->urutan = $request->urutan_baru;
        $up->update();

        $up2        = albumdetail::find($request->id_old);
        $up2->urutan = $request->urutan_sekarang;
        $up2->update();
        try {
            $response = Http::post('https://api.miccapro.com/api/training/repairGallery');
        } catch (\Throwable $th) {
            // dd($th);
            //throw $th;
        }
    }
}
