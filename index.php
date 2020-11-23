<?php

function isHexColor($h) {

    $hex = 'FFFFFF';

    if(substr( $h, 0, 1 ) === "#") {
        $h = substr( $h, 1);
        $hex = $h;
    }

    return $h;
}

function isValidHex($h) {

    $hex = 'FF';

    if(ctype_xdigit($h) && strlen($h)==2){
        $hex = $h;
    }

    return hexdec($h);
}

function isValidRgb($i) {

    if(is_int($i)) {

        if($i < 0) {
            $i = 0;
        } else if($i > 255) {
            $i = 255;
        }
    }

    return $i;
}

function getColors() {

    $color = array( "red" => 255, "green" => 255, "blue" => 255);

    if(isset($_GET['hex'])) {

        $hex = isHexColor($_GET['hex']);

        $r = substr( $hex, 0, 2);
        $g = substr( $hex, 2, 2);
        $b = substr( $hex, 4, 2);

        $r = isValidHex($r);
        $g = isValidHex($g);
        $b = isValidHex($b);

        if(is_int($r) && is_int($g) && is_int($b)) {

            $color['red'] = isValidRgb($r);
            $color['green'] = isValidRgb($g);
            $color['blue'] = isValidRgb($b);
        }

    } else if(isset($_GET['red']) && isset($_GET['green']) && isset($_GET['blue'])) {

        if(is_int($_GET['red']) && is_int($_GET['green']) && is_int($_GET['blue'])) {

            $color['red'] = isValidRgb($_GET['red']);
            $color['green'] = isValidRgb($_GET['green']);
            $color['blue'] = isValidRgb($_GET['blue']);
        }
    }

    return $color;
}

$colors = getColors();

header("Content-Type: image/png");

$im = @imagecreate(250, 250)
or die("Cannot Initialize new GD image stream");
$background_color = imagecolorallocate($im, $colors['red'], $colors['green'], $colors['blue']);

imagepng($im);
imagedestroy($im);