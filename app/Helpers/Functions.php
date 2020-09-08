<?php

function getImage($folder ,$full_path = true, $default_image = "default.png") {
    return $full_path ? ($folder != '' ? url("uploads/$folder/$default_image")  : url("uploads/$default_image") ) : "$folder/".$default_image ;
}

function getMultiLangField($default_value = '') {
    $data = [];
    foreach (config('app.locales') as $locale) {
        $data[$locale] = $default_value;
    }
    return $data;
}