<?php

use Illuminate\Support\Str;

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

if (!function_exists('errorMessage')) {
    function errorMessage($message = null)
    {
        $message = trans('dashboard.something_error') . '' . (env('APP_DEBUG') ? " : $message" : '');

        return request()->expectsJson()
        ? response()->json(['message' => $message], 400)
        : redirect()->back()->with(['status' => 'error', 'message' => $message]);
    }
}

if (!function_exists('successMessage')) {
    function successMessage($message = 'success')
    {
        return request()->expectsJson()
        ? response()->json(['message' => $message])
        : redirect()->back()->with(['status' => 'success', 'message' => $message]);
    }
}

if (!function_exists('successData')) {
    function successData($data = [], $message = '')
    {
        return request()->expectsJson()
        ? response()->json(['message' => $message, 'data' => $data])
        : redirect()->back()->with(['status' => 'success', 'message' => $message]);
    }
}

if (!function_exists('handleTrans')) {
    function handleTrans($trans = '', $return = null)
    {
        if (empty($trans)) {
            return '---';
        }
        $key = Str::snake($trans);

        if ($return == null) {
            $return = $trans;
        }

        return Str::startsWith(__("dashboard.$key"), 'dashboard.') ? $return : __("dashboard.$key");
    }
}

function camelCase($string, $capitalizeFirstCharacter = false)
{
    $str = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));

    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }

    return $str;
}


if(!function_exists('find_in_array_with_min_max'))
{
function    find_in_array_with_min_max($arr , $single) {
foreach ($arr as $item) {
    // dd($item,$single);
    if($item->min >= $single && $item->max <= $single) {
        dd($item);
    }
    // if($item->min >= $single && $item->max <= $single) {
    //     dd($item);
    //     return $item;
    // }}
}


}
}