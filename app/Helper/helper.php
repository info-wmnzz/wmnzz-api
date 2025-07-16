<?php
use Laravolt\Avatar\Facade as Avatar;


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

if (! function_exists('createSlug')) {
    function createSlug($string)
    {
        return \Str::slug($string, '-');
    }
}

if (! function_exists('avatarCreation')) {
    function avatarCreation($name, $surName)
    {
        // Create avatar
            $name = strtoupper(trim($name . ' ' . $surName));
            $avatar = Avatar::create($name)->getImageObject();
            
            // Save avatar to temporary path
            $filename = 'avatar_' . Str::slug($name) . '.png';
            $tempPath = storage_path('app/public/' . $filename);
            $avatar->save($tempPath, 'png');

            // Add avatar to media library
            $user->addMedia($tempPath)->toMediaCollection('userprofile');

            // Optionally delete the temp file
            unlink($tempPath);
    }
}
