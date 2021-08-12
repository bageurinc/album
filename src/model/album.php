<?php

namespace Bageur\Album\Model;

use App\training;
use Illuminate\Database\Eloquent\Model;
use Bageur\Album\processors\AvatarProcessor;
use Bageur\Album\model\albumdetail;
use Bageur\Artikel\Model\komentar;

class album extends Model
{
    protected $table = 'bgr_album';
    protected $appends = ['avatar','avatar_group', 'batch'];


    public function getBatchAttribute()
    {
        // $split = explode("|", $this->nama);
        // $training_batch = training::where('kelompok', $split[0])->first();
        // if ($training_batch) {
        //     return (int)$training_batch->batch;
        // }
        // else {
        //     return 0;
        // }
        $split = explode(" | ",$this->nama);
        $split_batch = explode(" ",$split[0]);
        return (int) end($split_batch);
    }

    public function getAvatarAttribute()
    {
         $last = albumdetail::orderBy('created_at','desc')
                                ->where('album_id', $this->id)
                                ->first();

            return AvatarProcessor::get($this->nama,@$last->gambar);
    }
    public function getAvatarGroupAttribute()
    {
            $last = albumdetail::orderBy('created_at','desc')
                                ->where('album_id', $this->id)
                                ->first();

            return AvatarProcessor::get($this->group,@$last->gambar);
    }
    public function komentar()
    {
        return $this->hasMany(komentar::class, 'album_id', 'id');
    }
    public function scopeDatatable($query,$request,$page=12)
    {
        $search       = ["nama",'`group`'];
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
