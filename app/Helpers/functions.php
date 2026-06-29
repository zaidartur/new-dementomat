<?php

/**
 * Standardize JSON responses
 */

use App\Services\PdfSanitizer;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

if (!function_exists('send_200')) {
    function send_200($message, $result = null)
    {
        $response = [
            'status'    => 'success',
            'message'   => $message,
            'data'      => $result,
        ];

        return response()->json($response, 200);
    }
}

if (!function_exists('send_201')) {
    function send_201($message, $result = null)
    {
        $response = [
            'status'    => 'success',
            'message'   => $message,
            'data'      => $result,
        ];

        return response()->json($response, 201);
    }
}

if (!function_exists('send_400')) {
    function send_400($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 400);
    }
}

if (!function_exists('send_401')) {
    function send_401($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 401);
    }
}

if (!function_exists('send_404')) {
    function send_404($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 404);
    }
}

if (!function_exists('send_500')) {
    function send_500($error)
    {
        $response = [
            'status'    => 'failed',
            'message'   => $error,
        ];

        return response()->json($response, 500);
    }
}

if (!function_exists('hslToHex')) {
    function hslToHex($h, $s, $l) {
        // Convert 0-360 degrees to 0-1 fraction
        $h /= 360;
        // Convert 0-100% to 0-1 fraction
        $s /= 100;
        $l /= 100;

        $r = $l;
        $g = $l;
        $b = $l;

        $v = ($l <= 0.5) ? ($l * (1 + $s)) : ($l + $s - $l * $s);
        
        if ($v > 0) {
            $m = $l + $l - $v;
            $sv = ($v - $m) / $v;
            $h *= 6;
            $sextant = floor($h);
            $fract = $h - $sextant;
            $vsf = $v * $sv * $fract;
            $mid1 = $m + $vsf;
            $mid2 = $v - $vsf;

            switch ($sextant % 6) {
                case 0: $r = $v; $g = $mid1; $b = $m; break;
                case 1: $r = $mid2; $g = $v; $b = $m; break;
                case 2: $r = $m; $g = $v; $b = $mid1; break;
                case 3: $r = $m; $g = $mid2; $b = $v; break;
                case 4: $r = $mid1; $g = $m; $b = $v; break;
                case 5: $r = $v; $g = $m; $b = $mid2; break;
            }
        }

        $res = sprintf("#%02x%02x%02x", round($r * 255), round($g * 255), round($b * 255));

        return $res;
    }
}

if (!function_exists('upload_tcm_image')) {
    // sanitize image
    function upload_tcm_image($file, $uid) {
        try {
            // v3 below
            // $manager = new ImageManager(new GdDriver());
            // $image = $manager->read($file)
            //         ->orient()
            //         ->toJpeg(quality: 9);

            $image = Image::decode($file)->orient();
            $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 90);

            // 3. Save to temporary path
            $extension = $file->getClientOriginalExtension();
            $tempPath = storage_path('app/tmp/sanitized_' .$uid. '_' . date('YmdHis') .'.jpg');
            File::ensureDirectoryExists(dirname($tempPath));
            file_put_contents($tempPath, $encoded->toString());

            // 4. Move to public folder
            $fileName = $uid . '_' .date('YmdHis'). '.jpg';
            $folder = public_path('storage/dokumen_tcm');
            if (!is_dir($folder)) {
                mkdir(public_path('storage/dokumen_tcm', 755));
            }

            $path = $folder . '/' . $fileName;
            $move = File::move($tempPath, $path);

            if (!$tempPath || !$move) {
                return false;
            }

            return $fileName;
        } catch(Exception $e) {
            return false;
        }
    }
}

if (!function_exists('upload_tcm_pdf')) {
    function upload_tcm_pdf($file, $uid) {
        try {
            $sanitizer = new PdfSanitizer();

            // Store original temporarily
            if (! File::exists(storage_path('app/tmp'))) {
                File::makeDirectory(storage_path('app/tmp'), 0755, true);
            }
            // if (! File::exists(storage_path('app/private/tmp'))) {
            //     File::makeDirectory(storage_path('app/private/tmp'), 0755, true);
            // }
            $tempInput = storage_path('app/tmp/original_' . $uid . '_' .date('YmdHis'). '.pdf');
            $tempOutput = storage_path('app/tmp/sanitized_' . $uid . '_' .date('YmdHis'). '.pdf');

            $tempInput = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $tempInput);
            $tempOutput = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $tempOutput);

            $file->move(dirname($tempInput), basename($tempInput));

            // Sanitize
            $sanitizer->sanitize($tempInput, $tempOutput);

            // Store sanitized PDF (never store original)
            $folder = public_path('storage/dokumen_tcm');
            if (! File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }
            
            $fileName = $uid . '_' .date('YmdHis'). '.pdf';
            $path = $folder . '/' . $fileName;
            $move = File::move($tempOutput, $path);

            // Cleanup
            @unlink($tempInput);
            @unlink($tempOutput);

            if ($move) {
                return $fileName;
            } else {
                return false;
            }
        } catch (Exception $e) {
            //throw $th;
            return false;
        }
    }
}

if (!function_exists('upload_slider')) {
    // sanitize image
    function upload_slider($file, $uid) {
        try {
            // v3 below
            // $manager = new ImageManager(new GdDriver());
            // $image = $manager->read($file)
            //         ->orient()
            //         ->toJpeg(quality: 9);

            $image = Image::decode($file)->orient();
            $encoded = $image->encodeUsingFormat(Format::JPEG, quality: 90);

            // 3. Save to temporary path
            $extension = $file->getClientOriginalExtension();
            $tempPath = storage_path('app/tmp/sanitized_' .$uid. '_' . date('YmdHis') .'.jpg');
            File::ensureDirectoryExists(dirname($tempPath));
            file_put_contents($tempPath, $encoded->toString());

            // 4. Move to public folder
            $fileName = $uid . '_' .date('YmdHis'). '.jpg';
            $folder = public_path('storage/slider');
            if (!is_dir($folder)) {
                mkdir(public_path('storage/slider', 755));
            }

            $path = $folder . '/' . $fileName;
            $move = File::move($tempPath, $path);

            if (!$tempPath || !$move) {
                return false;
            }

            return $fileName;
        } catch(Exception $e) {
            return false;
        }
    }
}

if (!function_exists('upload_logo')) {
    // sanitize image
    function upload_logo($file) {
        try {
            $image = Image::decode($file)->orient();
            $encoded = $image->encodeUsingFormat(Format::PNG, quality: 90);

            // 3. Save to temporary path
            $extension = $file->getClientOriginalExtension();
            $tempPath = storage_path('app/tmp/sanitized_' . date('YmdHis') .'.png');
            File::ensureDirectoryExists(dirname($tempPath));
            file_put_contents($tempPath, $encoded->toString());

            // 4. Move to public folder
            $fileName = date('YmdHis'). '.png';
            $folder = public_path('storage/logo');
            if (!is_dir($folder)) {
                mkdir(public_path('storage/logo', 755));
            }

            $path = $folder . '/' . $fileName;
            $move = File::move($tempPath, $path);

            if (!$tempPath || !$move) {
                return false;
            }

            return $fileName;
        } catch(Exception $e) {
            return false;
        }
    }
}

if (!function_exists('hasil_akhir_pengobatan')) {
    function hasil_akhir_pengobatan() {
        return ['Sembuh', 'Pengobatan Lengkap', 'Putus Berobat', 'Gagal', 'Meninggal'];
    }
};

if (!function_exists('upload_profile')) {
    // sanitize image
    function upload_profile($file, $name) {
        try {
            $image = Image::decode($file)->orient();
            $encoded = $image->encodeUsingFormat(Format::PNG, quality: 90);

            // 3. Save to temporary path
            $extension = $file->getClientOriginalExtension();
            $tempPath = storage_path('app/tmp/sanitized_' . date('YmdHis') .'.png');
            File::ensureDirectoryExists(dirname($tempPath));
            file_put_contents($tempPath, $encoded->toString());

            // 4. Move to public folder
            $fileName = $name . '.png';
            $folder = public_path('storage/profile');
            if (!is_dir($folder)) {
                mkdir(public_path('storage/profile', 755));
            }

            $path = $folder . '/' . $fileName;
            if (file_exists($path)) unlink($path);
            
            $move = File::move($tempPath, $path);

            if (!$tempPath || !$move) {
                return false;
            }

            return $fileName;
        } catch(Exception $e) {
            return false;
        }
    }
}