<?php
		    // Set some test variables
		    $font = "fonts/tuffy/Tuffy_Bold.ttf";
		    $text = $_REQUEST['text'];
		    $size = 25;
		    $angle = 0;

			$words = explode(" ", $text);
			$num_words = count($words);

			$first_half_num = ceil($num_words/2);
			$second_half_num = $num_words - $first_half_num;
			$first_half = '';
			$second_half = '';
			
			for($i = 0; $i < $first_half_num; $i++){
				$first_half .= $words[$i]." ";
			}
			
			for($i = $first_half_num; $i < $num_words; $i++){
				$second_half .= $words[$i]." ";
			}
			
			$fhbbox = imagettfbbox_fixed($size, $angle, $font, $first_half);
			$shbbox = imagettfbbox_fixed($size, $angle, $font, $second_half);
			
			$second_half = substr($second_half, 0, -1);

			$bbox = imagettfbbox_fixed($size, $angle, $font, $text);
			
			$img_width = $bbox['width'] + 25;
			$img_height = $bbox['height'] + 25;

		    $image = imagecreatetruecolor($img_width, $img_height);

			//Light Green
			$foreground_color = imagecolorallocate($image, 171, 195, 172 );
			//Dark Green
			$secondary_color = imagecolorallocate($image, 255, 255, 255 );
			//White
			$background_color = imagecolorallocate($image, 34, 70, 79 );
			
		    imagefill($image, 0, 0, $background_color);

		    imagettftext($image, $size, $angle, imagesx($image) / 2 - $bbox['width'] / 2, imagesy($image) / 2 + $bbox['height'] / 2, $foreground_color, $font, $first_half);
		    imagettftext($image, $size, $angle, $fhbbox['width'] + imagefontwidth($font), imagesy($image) / 2 + $bbox['height'] / 2, $secondary_color, $font, $second_half);
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
?>