<?php

/*
 * @author Harris Marfel <hrace009@gmail.com>
 * @link https://youtube.com/c/hrace009
 * @copyright Copyright (c) 2022.
 */

namespace App\Http\Helper;

use Mews\Captcha\Captcha;

class CaptchaGenerator
{
    /**
     * Custom captcha generation with wave distortion
     */
    public static function generate($config = 'default')
    {
        $captcha = new Captcha();

        // Get configuration from mews/captcha config
        $params = config('captcha.' . $config, config('captcha.default'));

        // Generate random string
        $str = self::generateRandomString($params['length'] ?? 5);

        // Store in session for validation
        session(['captcha.' . $config => $str]);

        // Generate image
        $imageData = self::renderCaptcha($str, $params);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Validate captcha
     */
    public static function validate($input, $config = 'default')
    {
        $sessionKey = 'captcha.' . $config;
        $sessionValue = session($sessionKey);

        // Clear session after validation attempt
        session()->forget($sessionKey);

        return $sessionValue && strtolower($input) === strtolower($sessionValue);
    }

    /**
     * Generate random string for captcha
     */
    private static function generateRandomString($length)
    {
        $chars = 'QSFHTRPAJKLMZXCVBNabdefhxktyzj23456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $str;
    }

    /**
     * Render captcha with wave distortion (your custom logic)
     */
    private static function renderCaptcha($str, $params)
    {
        // Set default parameters if not provided
        $params = array_merge([
            'width' => 180,
            'height' => 50,
            'background' => ['f2f2f2'],
            'colors' => ['2980b9'],
            'fontSize' => 26,
            'letterSpacing' => 2,
            'scratches' => [1, 6],
            'font' => base_path('resources/fonts/arial.ttf') // You'll need to add a font file
        ], $params);

        // Ensure arrays
        if (!is_array($params['background'])) {
            $params['background'] = [$params['background']];
        }
        if (!is_array($params['colors'])) {
            $params['colors'] = [$params['colors']];
        }
        if (!is_array($params['scratches'])) {
            $params['scratches'] = [1, 6];
        }

        $hexBgColor = $params['background'][mt_rand(0, count($params['background']) - 1)];
        $bgColor = self::hexToRgb($hexBgColor);

        $hexColors = $params['colors'][mt_rand(0, count($params['colors']) - 1)];
        $textColor = self::hexToRgb($hexColors);

        //Prototype
        $img1 = imagecreatetruecolor($params['width'], $params['height']);
        imagefill($img1, 0, 0, imagecolorallocate($img1, $bgColor['r'], $bgColor['g'], $bgColor['b']));

        //Distorted picture (multi-wave)
        $img2 = imagecreatetruecolor($params['width'], $params['height']);

        //Print text
        $strlen = strlen($str);
        $x = ($params['width'] - $strlen * ($params['letterSpacing'] + $params['fontSize'] * 0.66)) / 2;

        // Check if font file exists, use default if not
        $fontPath = $params['font'];
        if (!file_exists($fontPath)) {
            // Use imagestring instead of imagettftext if no font file
            for ($i = 0; $i < $strlen; $i++) {
                imagestring(
                    $img1,
                    5,
                    $x + ($i * 20),
                    15,
                    $str[$i],
                    imagecolorallocate($img1, rand(20, 200), rand(10, 200), rand(0, 200))
                );
            }
        } else {
            for ($i = 0; $i < $strlen; $i++) {
                ImageTTFtext(
                    $img1,
                    $params['fontSize'],
                    rand(-10, 10),
                    $x,
                    ceil(($params['height'] + $params['fontSize']) / 2),
                    imagecolorallocate($img1, rand(20, 200), rand(10, 200), rand(0, 200)),
                    $fontPath,
                    $str[$i]
                );
                $x += ceil($params['fontSize'] * 0.66) + $params['letterSpacing'];
            }
        }

        //Scratch (text color)
        for ($i = 0; $i < $params['scratches'][0]; $i++) {
            self::drawScratch($img1, $params['width'], $params['height'], $hexColors);
        }

        //Scratches (background color)
        for ($i = 0; $i < $params['scratches'][1]; $i++) {
            self::drawScratch($img1, $params['width'], $params['height'], $hexBgColor);
        }

        $sxR1 = mt_rand(7, 10) / 120;
        $syR1 = mt_rand(7, 10) / 120;
        $sxR2 = mt_rand(7, 10) / 120;
        $syR2 = mt_rand(7, 10) / 120;

        $sxF1 = mt_rand(0, 314) / 100;
        $sxF2 = mt_rand(0, 314) / 100;
        $syF1 = mt_rand(0, 314) / 100;
        $syF2 = mt_rand(0, 314) / 100;

        $sxA = mt_rand(4, 6);
        $syA = mt_rand(4, 6);

        for ($x = 0; $x < $params['width']; $x++) {
            for ($y = 0; $y < $params['height']; $y++) {
                $sx = $x + (sin($x * $sxR1 + $sxF1) + sin($y * $sxR2 + $sxF2)) * $sxA;
                $sy = $y + (sin($x * $syR1 + $syF1) + sin($y * $syR2 + $syF2)) * $syA;

                if ($sx < 0 || $sy < 0 || $sx >= $params['width'] - 1 || $sy >= $params['height'] - 1) {
                    $r = $rX = $rY = $rXY = $bgColor['r'];
                    $g = $gX = $gY = $gXY = $bgColor['g'];
                    $b = $bX = $bY = $bXY = $bgColor['b'];
                } else {
                    $rgb = imagecolorat($img1, $sx, $sy);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;

                    $rgb = imagecolorat($img1, $sx + 1, $sy);
                    $rX = ($rgb >> 16) & 0xFF;
                    $gX = ($rgb >> 8) & 0xFF;
                    $bX = $rgb & 0xFF;

                    $rgb = imagecolorat($img1, $sx, $sy + 1);
                    $rY = ($rgb >> 16) & 0xFF;
                    $gY = ($rgb >> 8) & 0xFF;
                    $bY = $rgb & 0xFF;

                    $rgb = imagecolorat($img1, $sx + 1, $sy + 1);
                    $rXY = ($rgb >> 16) & 0xFF;
                    $gXY = ($rgb >> 8) & 0xFF;
                    $bXY = $rgb & 0xFF;
                }

                if (
                    $r == $rX &&
                    $r == $rY &&
                    $r == $rXY &&
                    $g == $gX &&
                    $g == $gY &&
                    $g == $gXY &&
                    $b == $bX &&
                    $b == $bY &&
                    $b == $bXY
                ) {
                    if ($r == $bgColor['r'] && $g == $bgColor['g'] && $b == $bgColor['b']) {
                        $newR = $bgColor['r'];
                        $newG = $bgColor['g'];
                        $newB = $bgColor['b'];
                    } else {
                        $newR = $textColor['r'];
                        $newG = $textColor['g'];
                        $newB = $textColor['b'];
                    }
                } else {
                    $frsx = $sx - floor($sx);
                    $frsy = $sy - floor($sy);
                    $frsx1 = 1 - $frsx;
                    $frsy1 = 1 - $frsy;

                    $newR = floor($r * $frsx1 * $frsy1 +
                        $rX * $frsx * $frsy1 +
                        $rY * $frsx1 * $frsy +
                        $rXY * $frsx * $frsy);
                    $newG = floor($g * $frsx1 * $frsy1 +
                        $gX * $frsx * $frsy1 +
                        $gY * $frsx1 * $frsy +
                        $gXY * $frsx * $frsy);
                    $newB = floor($b * $frsx1 * $frsy1 +
                        $bX * $frsx * $frsy1 +
                        $bY * $frsx1 * $frsy +
                        $bXY * $frsx * $frsy);
                }
                imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newR, $newG, $newB));
            }
        }

        ob_start();
        imagepng($img1);
        $content = ob_get_contents();
        ob_end_clean();

        imagedestroy($img1);
        imagedestroy($img2);

        return $content;
    }

    /**
     * Convert hex color to RGB
     */
    private static function hexToRgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Draw scratch lines
     */
    private static function drawScratch($img, $width, $height, $color)
    {
        $rgb = self::hexToRgb($color);
        $scratchColor = imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b']);

        imageline(
            $img,
            mt_rand(0, $width),
            mt_rand(0, $height),
            mt_rand(0, $width),
            mt_rand(0, $height),
            $scratchColor
        );
    }
}
