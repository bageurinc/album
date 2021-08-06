<?php
namespace Bageur\Album\Processors;

class UploadProcessor {

    public static function go($data,$loc) {
       $namaBerkas = rand(000000000000,date('YmdHis')).'.'.$data->getClientOriginalExtension();
       $path = $loc;
       $path = $data->storeAs($path.'/', $namaBerkas);
    //    \Storage::put($path, $data);
       return basename($namaBerkas);
    }
}
