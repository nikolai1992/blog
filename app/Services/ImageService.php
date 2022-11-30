<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.11.2022
 * Time: 01:52
 */

namespace App\Services;


class ImageService
{
    public static function uploadImage($request)
    {
        $storage_path = "";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $storage_path = "/storage/images/" . $filename;
            $file->move(public_path('/storage/images/'), $filename);
        }

        return $storage_path;
    }
}