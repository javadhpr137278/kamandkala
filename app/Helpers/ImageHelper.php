<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageHelper
{
    protected static function manager()
    {
        return new ImageManager(new Driver());
    }

    public static function upload($file, $path = 'uploads', $convertToWebp = true)
    {
        if (!$file) {
            return null;
        }

        $extension = $convertToWebp ? 'webp' : $file->getClientOriginalExtension();
        $name = Str::uuid() . '.' . $extension;
        $fullPath = $path . '/' . $name;

        if ($convertToWebp) {
            $manager = self::manager();
            $image = $manager->read($file)->toWebp(90);

            Storage::disk('public')->put($fullPath, $image);
        } else {
            $file->storeAs($path, $name, 'public');
        }

        return $fullPath;
    }

    public static function uploadMultiple($files, $path = 'uploads', $convertToWebp = true)
    {
        $images = [];

        foreach ($files as $file) {
            $images[] = self::upload($file, $path, $convertToWebp);
        }

        return $images;
    }

    public static function delete($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            return true;
        }

        return false;
    }

    public static function resize($file, $path, $width = 300, $height = null)
    {
        $manager = self::manager();

        $name = Str::uuid() . '.webp';
        $fullPath = $path . '/' . $name;

        $image = $manager->read($file)
            ->resize($width, $height)
            ->toWebp(90);

        Storage::disk('public')->put($fullPath, $image);

        return $fullPath;
    }

    public static function thumbnail($file, $path = 'uploads/thumbs', $size = 300)
    {
        $manager = self::manager();

        $name = Str::uuid() . '.webp';
        $fullPath = $path . '/' . $name;

        $image = $manager->read($file)
            ->cover($size, $size)
            ->toWebp(85);

        Storage::disk('public')->put($fullPath, $image);

        return $fullPath;
    }
}
