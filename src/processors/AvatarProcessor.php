<?php
namespace Bageur\Album\Processors;

class AvatarProcessor {

    public static function get( $name, $image = null, $folder = "album", $type = "initials") {
        if (empty($image)) {
            if (!empty($name)) {
                return 'https://avatars.dicebear.com/v2/'.$type.'/' . preg_replace('/[^a-z0-9 _.-]+/i', '', $name) . '.svg';
            }
            return null;
        }
        return url('album/'.$image);
    }
}
