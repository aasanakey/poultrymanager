<?php

if(!function_exists('generate_id')){
    /**
     * generate a unique id prefixed with farm name
     * @param string $farm_name
     * @return string id
     */
    function generate_id($farm_name='',$suffix=null){
        $sp_char = str_shuffle('@#$~`,.>%^&*()_+<?/\\\';:');
        return uniqid($farm_name,true).$sp_char[7].$suffix;
    }
}
