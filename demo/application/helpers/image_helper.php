<?php
function get_image_thumb($image_url,$width,$height)
{
    //Get image infor
    preg_match('/[^\/]*$/',$image_url,$match);
    $image_name = $match[0];
    $thumb_name = $width . 'x' . $height . '_' . $image_name;
    
    //Get destination
    $_path_url = parse_url(dirname($image_url));
    $image_dir = $_path_url['path'];
    $image_path = __DIR__ . '/../..' . $image_dir . '/' . $image_name;
    $thumb_path = __DIR__ . '/../..' . $image_dir . '/' . $thumb_name;
    $thumb_link = dirname($image_url) . '/' . $thumb_name;
    
    //if thumbnail not exist then resize image
    if(! file_exist($thumb_path))
    {
        //Load CI super object
        $CI =& get_instance();
        
        //load image library
        $CI->load->library('image_lib');
        
        //config
        $config['image_library'] = 'gd2';
        $config['maintain_ratio']= TRUE;
        $config['source_image']  = $image_path;
        $config['new_image']     = $thumb_path;
        $config['new_height']    = $height;
        $config['new_width']     = $width;
        
        //resize image
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }
    return $thumb_link;
}