<?php

namespace Bageur\Album\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Artikel\Processors\AvatarProcessor;

class komentar_album extends Model
{
    protected $table = 'bgr_komen_album';

    public function submenu()
    {
    	 return $this->hasMany(komentar::class,'komen_id');
    }
    public function parent()
    {
       return $this->hasOne(komentar::class,'id','komen_id');
    }
    public function album()
    {
       return $this->hasOne(album::class,'id','album_id');
    }
    public function scopeDatatable($query,$request,$page=12)
    {
          $search       = ["nama","nama_album"];
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
        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }
}
