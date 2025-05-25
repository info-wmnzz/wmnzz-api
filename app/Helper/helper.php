<?php

if (! function_exists('generateId')) {
    function generateId($name, $length = 6)
    {
        $prefix     = 'WMNZ';
        $shortName  = strtoupper(substr(preg_replace('/\s+/', '', $name), 0, 3));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random     = '';

        for ($i = 0; $i < $length; $i++) {
            $random .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix . $shortName . $random;
    }
}

if(! function_exists('createSlug')){
    function createSlug($string)
    {
        return \Str::slug($string, '-');
    }
}
