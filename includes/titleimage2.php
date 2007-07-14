<?php
		    // Set some test variables
		    //$font = "fonts/28_days_later.ttf";
			$font = "fonts/blazed/Blazed.ttf";
		    $text = $_REQUEST['text'];
		    $size = 20;
		    $angle = 0;

			$words = explode(" ", $text);
			$num_words = count($words);

			$first_half_num = floor($num_words/2);
			$second_half_num = $num_words - $first_half_num;
			$first_half = '';
			$second_half = '';
			
			for($i = 0; $i < $first_half_num; $i++){
				$first_half .= $words[$i]." ";
			}
			
			for($i = $first_half_num; $i < $num_words; $i++){
				$second_half .= $words[$i]." ";
			}
			
			$whole = $first_half . "\n" . $second_half;
			
			$fhbbox = imagettfbbox_fixed($size, $angle, $font, $first_half);
			$shbbox = imagettfbbox_fixed($size, $angle, $font, $second_half);
			
			$second_half = substr($second_half, 0, -1);

			$bbox = imagettfbbox_fixed($size, $angle, $font, $whole);
			
			$img_width = $bbox['width'] + 25;
			$img_height = $bbox['height'] + 25;

		    $image = imagecreatetruecolor($img_width, $img_height);

			$bgcolor = html2rgb('#4a525a');
			
			$foreground_color = imagecolorallocate($image, 255, 255, 255 );

			$background_color = imagecolorallocate($image, $bgcolor[0], $bgcolor[1], $bgcolor[2] );
			
		    imagefill($image, 0, 0, $background_color);

		    imagettftext($image, $size, $angle, imagesx($image) / 2 - $bbox['width'] / 2, imagesy($image) / 2, $foreground_color, $font, $whole);

		    // Show the image
			header("Content-type: image/png");
		    imagepng($image);

		    function imagettfbbox_fixed($size, $angle, $font, $text)
		    {
		        // Get the boundingbox from imagettfbbox(), which is correct when angle is 0
		        $bbox = imagettfbbox($size, 0, $font, $text);

		        // Rotate the boundingbox
		        $angle = pi() * 2 - $angle * pi() * 2 / 360;
		        for ($i=0; $i<4; $i++)
		        {
		            $x = $bbox[$i * 2];
		            $y = $bbox[$i * 2 + 1];
		            $bbox[$i * 2] = cos($angle) * $x - sin($angle) * $y;
		            $bbox[$i * 2 + 1] = sin($angle) * $x + cos($angle) * $y;
		        }

		        // Variables which tells the correct width and height
		        $bbox['width'] = $bbox[0] + $bbox[4];
		        $bbox['height'] = $bbox[1] - $bbox[5];

		        return $bbox;
		    }

			function html2rgb($color)
			{
			    if ($color[0] == '#')
			        $color = substr($color, 1);

			    if (strlen($color) == 6)
			        list($r, $g, $b) = array($color[0].$color[1],
			                                 $color[2].$color[3],
			                                 $color[4].$color[5]);
			    elseif (strlen($color) == 3)
			        list($r, $g, $b) = array($color[0], $color[1], $color[2]);
			    else
			        return false;

			    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

			    return array($r, $g, $b);
			}
?>