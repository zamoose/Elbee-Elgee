<?php
/*
Facelift Image Replacement v1.2
Facelift was written and is maintained by Cory Mawhorter.  
It is available from http://facelift.mawhorter.net/

===

This file is part of Facelife Image Replacement ("FLIR").

FLIR is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

FLIR is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Facelift Image Replacement.  If not, see <http://www.gnu.org/licenses/>.
*/

define('DEBUG', false);
define('ENABLE_FONTSIZE_BUG', false);

define('FLIR_VERSION', '1.2');
define('IS_WINDOWS', (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'));

require('config-flir.php');
require('inc-flir.php');

if(version_compare(PHP_VERSION, '4.3.0', '<'))
    err('PHP_TOO_OLD');
if(version_compare(PHP_VERSION, '6.0.0', '>='))
    err('PHP_UNSUPPORTED');
    
if(false !== ALLOWED_DOMAIN && $_SERVER['HTTP_REFERER'] != '') {
    $refhost = get_hostname($_SERVER['HTTP_REFERER']);
    if(substr(ALLOWED_DOMAIN, 0, 1) == '.') {
        if(false === strpos($refhost, substr(ALLOWED_DOMAIN, 1)))
            err('DISALLOWED_DOMAIN');
    }else {
        if($refhost != ALLOWED_DOMAIN) 
            err('DISALLOWED_DOMAIN');
    }
}

$fonts_dir = str_replace('\\', '/', realpath(FONTS_DIR.'/'));

if(substr($fonts_dir, -1) != '/')
    $fonts_dir .= '/';

$FLIR = array();
$FStyle = preg_match('#^\{("[\w]+":"[^"]*",?)*\}$#i', $_GET['fstyle'])?json_decode($_GET['fstyle'], true):array();

$FLIR['mode']        = isset($FStyle['mode']) ? $FStyle['mode'] : '';
$FLIR['output']        = isset($FStyle['output']) ? ($FStyle['output']=='jpeg'?'jpg':$FStyle['output']) : 'auto';

$FLIR['bkg_transparent'] = is_transparent($FStyle['cBackground']);

if($FLIR['output'] == 'auto')
    $FLIR['output'] = $FLIR['bkg_transparent'] ? 'png' : 'gif';
    
// format not supported, fall back to png
if(($FLIR['output'] == 'gif' && !function_exists('imagegif')) || ($FLIR['output'] == 'jpg' && !function_exists('imagejpeg')))
    $FLIR['output'] = 'png';

$FLIR['dpi'] = preg_match('#^[0-9]+$#', $FStyle['dpi']) ? $FStyle['dpi'] : 96;
$FLIR['size']     = is_number($FStyle['cSize'], true) ? $FStyle['cSize'] : UNKNOWN_FONT_SIZE; // pixels
$FLIR['size_pts'] = ENABLE_FONTSIZE_BUG ? $FLIR['size'] : get_points($FLIR['dpi'], $FLIR['size']);
$FLIR['maxheight']= is_number($_GET['h']) ? $_GET['h'] : UNKNOWN_FONT_SIZE; // pixels
$FLIR['maxwidth']= is_number($_GET['w']) ? $_GET['w'] : 800; // pixels

$font_file = '';
$FStyle['cFont'] = strtolower($FStyle['cFont']);
$FONT_PARENT = false;
if(isset($fonts[$FStyle['cFont']])) {
    $font_file = $fonts[$FStyle['cFont']];
    
    if(is_array($font_file)) {
        $FONT_PARENT = reset($font_file);
        $font_file = match_font_style($font_file);
        $FONT_PARENT = $fonts_dir.(isset($FONT_PARENT['file']) ? $FONT_PARENT['file'] : $font_file);
    }
}elseif(FONT_DISCOVERY) {
    $font_file = discover_font($fonts['default'], $FStyle['cFont']);
}else {
    $font_file = $fonts['default'];
}
$FLIR['font']     = $fonts_dir.$font_file;

//die($FStyle['cFont']);

if(!is_file($FLIR['font']))
    err('FONT_DOESNT_EXIST');
    
if(in_array(strtolower(pathinfo($FLIR['font'], PATHINFO_EXTENSION)), array('pfb','pfm'))) { // pfm doesn't work
    // You can try uncommenting this line to see what kind of mileage you get.
    err('FONT_PS_UNSUPPORTED'); // PostScript will work as long as you don't set any kind of spacing... unless you are using Windows (PHP bug?).
    
    $FLIR['postscript'] = true;
    $FLIR['ps'] = array('kerning' => 0, 'space' => 0);
    if(false === (@$FLIR['ps']['font'] = imagepsloadfont($FLIR['font']))) 
        err('FONT_PS_COULDNT_LOAD');
}
    
$FLIR['color']         = convert_color($FStyle['cColor']);

if($FLIR['bkg_transparent']) {
    $FLIR['bkgcolor'] = array('red'         => abs($FLIR['color']['red']-100)
                                    , 'green'     => abs($FLIR['color']['green']-100)
                                    , 'blue'     => abs($FLIR['color']['blue']-100));
}else {
    $FLIR['bkgcolor'] = convert_color($FStyle['cBackground'], false, 'FFFFFF');
}

$FLIR['opacity'] = is_number($FStyle['cOpacity'], true) ? $FStyle['cOpacity']*100 : 100;
if($FLIR['opacity'] > 100 || $FLIR['opacity'] < 0) 
    $FLIR['opacity'] = 100;    

$FLIR['text']     = $_GET['text']!=''?str_replace(array('{amp}nbsp;', '{amp}', '{plus}'), array(' ','&','+'), trim($_GET['text'], "\t\n\r")):'null';

$FLIR['cache']     = get_cache_fn(md5(($FLIR['mode']=='wrap'?$FLIR['maxwidth']:'').$FLIR['font'].(print_r($FStyle,true).$FLIR['text'])), $FLIR['output']);

$FLIR['text_encoded'] = $FLIR['text'];
$FLIR['text'] = $FLIR['original_text'] = strip_tags(html_entity_decode_utf8($FLIR['text']));

$SPACE_BOUNDS = false;
if(is_number($FStyle['cSpacing'], true, false, true)) {
    $SPACE_BOUNDS = bounding_box(' ');
    $spaces = ceil(($FStyle['cSpacing']/$SPACE_BOUNDS['width']));
    if($spaces>0) {
        $FLIR['text'] = space_out($FLIR['text'], $spaces);
        define('SPACING_GAP', $spaces);
    }
    
    if($FLIR['postscript']) {
        $FLIR['ps']['kerning'] = ($FStyle['cSpacing']/$FLIR['size'])*1000;
    }
}

if($FLIR['postscript'] && isset($FStyle['space_width'])) {
    $FLIR['ps']['space'] = ($FStyle['space_width']/$FLIR['size'])*1000;
}

if(($SPACES_COUNT = substr_count($FLIR['text'], ' ')) == strlen($FLIR['text'])) {
    if(false === $SPACE_BOUNDS)
        $SPACE_BOUNDS = bounding_box(' '); 
        
    $FLIR['cache'] = get_cache_fn(md5($FLIR['font'].$FLIR['size'].$SPACES_COUNT));
    $FLIR['mode'] = 'spacer';
}

if(file_exists($FLIR['cache']) && !DEBUG) {
    output_file($FLIR['cache']);
}else {    
    verify_gd();
    
    $REAL_HEIGHT_BOUNDS = $FStyle['realFontHeight']=='true' ? bounding_box(HBOUNDS_TEXT, (false !== $FONT_PARENT ? $FONT_PARENT : $FLIR['font'])): false;
    
    switch($FLIR['mode']) {
        default:
            $dir = dir(PLUGIN_DIR);
            $php_mode = strtolower($FLIR['mode'].'.php');
            while(false !== ($entry = $dir->read())) {
                $p = PLUGIN_DIR.'/'.$entry;
                if(is_dir($p) || $entry == '.' || $entry == '..') continue;
                
                if($php_mode == strtolower($entry)) {
                    $dir->close();
                    $PLUGIN_ERROR = false;                    
                    
                    include($p);
                                        
                    if(false !== $PLUGIN_ERROR)
                        break;
                    else
                        break(2);
                }
            }
            $dir->close();

            $bounds = bounding_box($FLIR['text']);
            if($FStyle['realFontHeight']!='true') 
                $REAL_HEIGHT_BOUNDS = $bounds;

            if(false === (@$image = imagecreatetruecolor($bounds['width'], $REAL_HEIGHT_BOUNDS['height'])))
                err('COULD_NOT_CREATE');
                
            gd_alpha();
            imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), gd_bkg());
            render_text($bounds);
            break;
        case 'wrap':
            if(!is_number($FStyle['cLine'], true))
                $FStyle['cLine'] = 1.0;

            $bounds = bounding_box($FLIR['text']);
            if($FStyle['realFontHeight']!='true') 
                $REAL_HEIGHT_BOUNDS = $bounds;
    
            // if mode is wrap, check to see if text needs to be wrapped, otherwise let continue to progressive
            if($bounds['width'] > $FLIR['maxwidth']) {
                $image = imagettftextbox($FLIR['size_pts'], 0, 0, 0, $FLIR['color'], $FLIR['font'], $FLIR['text'], $FLIR['maxwidth'], strtolower($FStyle['cAlign']), $FStyle['cLine']);
                break;
            }else {
                if(false === (@$image = imagecreatetruecolor($bounds['width'], $REAL_HEIGHT_BOUNDS['height'])))
                    err('COULD_NOT_CREATE');

                gd_alpha();
                imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), gd_bkg());
                render_text($bounds);
            }
            break;
        case 'progressive':
            $bounds = bounding_box($FLIR['text']);
            if($FStyle['realFontHeight']!='true') 
                $REAL_HEIGHT_BOUNDS = $bounds;
            
            $offset_left = 0;
            
            $nsize=$FLIR['size_pts'];
            while(($REAL_HEIGHT_BOUNDS['height'] > $FLIR['maxheight'] || $bounds['width'] > $FLIR['maxwidth']) && $nsize > 2) {
                $nsize-=0.5;
                $bounds = bounding_box($FLIR['text'], NULL, $nsize);
                $REAL_HEIGHT_BOUNDS = $FStyle['realFontHeight']=='true' ? bounding_box(HBOUNDS_TEXT, NULL, $nsize) : $bounds;
            }
            $FLIR['size_pts'] = $nsize;
    
            if(false === (@$image = imagecreatetruecolor($bounds['width'], $REAL_HEIGHT_BOUNDS['height'])))
                err('COULD_NOT_CREATE');

            gd_alpha();
            imagefilledrectangle($image, $offset_left, 0, imagesx($image), imagesy($image), gd_bkg());
            
            imagettftext($image, $FLIR['size_pts'], 0, $bounds['xOffset'], $REAL_HEIGHT_BOUNDS['yOffset'], gd_color(), $FLIR['font'], $FLIR['text']);
            render_text($bounds);
            break;
            
        case 'spacer':
            if(false === (@$image = imagecreatetruecolor(($SPACE_BOUNDS['width']*$SPACES_COUNT), 1)))
                err('COULD_NOT_CREATE');

            imagesavealpha($image, true);
            imagealphablending($image, false);
    
            imagefilledrectangle($image, 0, 0, imagesx($image), imagesy($image), gd_bkg());
            break;
    }

    if($FLIR['postscript'])
        imagepsfreefont($FLIR['ps']['font']);

    if(false !== $image) {
        switch($FLIR['output']) {
            default:
            case 'png':
                imagepng($image, $FLIR['cache']);
                break;
            case 'gif':
                imagegif($image, $FLIR['cache']);
                break;
            case 'jpg':
                $qual = is_number($FStyle['quality']) ? $FStyle['quality'] : 90;
                imagejpeg($image, $FLIR['cache'], $qual);
                break;
        }
        imagedestroy($image);
    }

    output_file($FLIR['cache']);    
} // if(file_exists($FLIR['cache'])) {

flush();

if(CACHE_CLEANUP_FREQ != -1 && rand(1, CACHE_CLEANUP_FREQ) == 1)
    @cleanup_cache();
?>