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

if( !function_exists('generate_batch_id')){
    /**
     * Generate  batch id
     */
    function generate_batch_id($farm_name)
    {
        $date = date_create();
     return $date->format('Y')."_".$date->format('m')."_".$date->format('d')."_".uniqid($farm_name);
    }
}

if( !function_exists('generate_pen_id')){
    /**
     * Generate  batch id
     */
    function generate_pen_id()
    {
        $date = date_create();
     return "Pen House_".$date->format('Y')."_".$date->format('m')."_".$date->format('d')."_".uniqid();
    }
}
