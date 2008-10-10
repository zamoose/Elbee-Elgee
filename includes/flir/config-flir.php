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

define('FONT_DISCOVERY', 			false);

define('ALLOWED_DOMAIN', 			false); // ex: 'example.com', 'subdomain.domain.com', '.allsubdomains.com', false disabled

define('UNKNOWN_FONT_SIZE', 		16); // in pixels

define('CACHE_CLEANUP_FREQ', 		-1); // -1 disable, 1 everytime, 10 would be about 1 in 10 times this script runs (higher number decreases frequency)
define('CACHE_KEEP_TIME', 			604800); // 604800: 7 days

define('CACHE_DIR', 					'cache');
define('FONTS_DIR', 					'fonts');
define('PLUGIN_DIR',					'plugins');

define('HBOUNDS_TEXT', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz[]{}()_'); // see http://facelift.mawhorter.net/docs/

// Each font you want to use should have an entry in the fonts array.
$fonts = array();
$fonts['illuminating'] 	= 'ArtOfIlluminating.ttf';
$fonts['okolaks'] 		= 'okolaksBold.ttf';
$fonts['wanta'] 			= 'wanta_091.ttf';


// The font will default to the following (put your most common font here).
$fonts['default'] 		= $fonts['okolaks'];

/*
// You can now setup collections of fonts that will be automatically detected and used if the proper CSS conditions are met.
// For more information, please visit: http://www.mawhorter.net/projects/facelift-projects/facelift-font-collections
$fonts['your_font']		= array();
$fonts['your_font'][] 	= array('file' => 'test/font_regular.ttf');
$fonts['your_font'][] 	= array('file' => 'test/font_bolditalic.ttf'
										,'font-stretch'			=> ''
										,'font-style'				=> 'italic'
										,'font-variant'			=> ''
										,'font-weight'				=> 'bold'
										,'text-decoration'		=> '');
$fonts['your_font'][] 	= array('file' => 'test/font_bold.ttf'
										,'font-weight'				=> 'bold');
$fonts['your_font'][] 	= array('file' => 'test/font_italic.ttf'
										,'font-style'				=> 'italic');
*/


// Set default replacements for "web fonts" here
$fonts['arial'] = $fonts['helvetica'] = $fonts['sans-serif'] 		= $fonts['okolaks'];
$fonts['times new roman'] = $fonts['times'] = $fonts['serif'] 		= $fonts['illuminating'];
$fonts['courier new'] = $fonts['courier'] = $fonts['monospace'] 	= $fonts['wanta'];

define('IM_EXEC_PATH', '/usr/bin/'); // Path to ImageMagick (with trailing slash).  ImageMagick is needed by some plugins, but not necessary.
?>
