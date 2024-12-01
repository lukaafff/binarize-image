<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function binarize(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = $request->file('image');

        $img = imagecreatefromjpeg($image);

        $width = imagesx($img);
        $height = imagesy($img);

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $gray = ($r * 0.3 + $g * 0.59 + $b * 0.11);

                if ($gray < 128) {
                    $color = imagecolorallocate($img, 0, 0, 0);
                } else {
                    $color = imagecolorallocate($img, 255, 255, 255);
                }

                imagesetpixel($img, $x, $y, $color);
            }
        }

        header('Content-Type: image/jpeg');

        imagejpeg($img);

        imagedestroy($img);

    }
}
