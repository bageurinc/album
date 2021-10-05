<?php

namespace Bageur\Album\Model;

use Illuminate\Database\Eloquent\Model;

class albumdetail extends Model
{
    protected $table   = 'bgr_albumdetail';
     protected $appends = ['img'];

    public function getImgAttribute()
    {
    //    return \Storage::url('album/'.$this->gambar);
       return \Bageur::avatar('', $this->gambar ,'album');
    }
    public function scopeDatatable($query,$request,$page=12)
    {
          $search       = ["id"];
          $searchqry    = '';

        $searchqry = "(";
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        }
        $searchqry .= ")";
        if(@$request->sort_by){
            if(@$request->sort_by != null){
            	$explode = explode('.', $request->sort_by);
                 $query->orderBy($explode[0],$explode[1]);
            }else{
                  $query->orderBy('created_at','desc');
            }

             $query->whereRaw($searchqry);
        }else{
             $query->whereRaw($searchqry);
        }
        if($request->id_album){
          $query->where('album_id',$request->id_album);
        }
        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }

}
