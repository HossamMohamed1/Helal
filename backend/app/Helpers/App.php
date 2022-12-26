<?php

if (!function_exists('uploadImage')) {
    function uploadImage($storage, $image, $modal)
    {
        $image->store('/' . $modal, $storage);
        return $image->hashName();
    }
}

if (!function_exists('primaryID')) {
    function primaryID()
    {
        return auth()->user()->primary_id ?? auth()->id();
    }
}