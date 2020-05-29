<?php
namespace Bageur\Album\Processors;

class UploadProcessor {

    public static function go($data,$loc) {
       $namaBerkas = date('YmdHis').'.'.$data->getClientOriginalExtension();
       $path = $data->storeAs('public/'.$loc.'/', $namaBerkas);
       return basename($path);
    }
}
