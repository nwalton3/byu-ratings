<?php


/* Start the document */

	header("Content-type:image/svg+xml");
	echo '<?xml version="1.0" encoding="utf-8" ?>';

/* Variables */
	
	$colStart = 36;
	$colSpace = 36;
	$rowStart = 27;
	$lineHeight = 13;


/* Functions */
	
	/* Func: check_input
	 * Desc: Check whether a variable is in the GET parameters and return it or a default value if not available.
	 * Args: $var - String - The $_GET variable to check.
	 *		 $location - String - The location of the variables array. Can take 'GET', 'POST', or 'SESSION'. Defaults to 'GET'.
	 *		 $default - A value to return if the specified variable is not available. If not set, defaults to null.
	 */
	function check_input( $var, $location = 'GET', $default = null )
	{
		$loc = $_GET; // Default location setting is GET
		if ( $location === 'POST' )    { $loc = $_POST; }
		if ( $location === 'SESSION' ) { $loc = $_SESSION; }

		return isset( $loc[$var] ) ? $loc[$var] : $default; // Return the value if found, return the default if not
	}


	$legendY = check_input('legendY');
	$legendX = check_input('legendX');
	$data    = check_input('data');

/* SVG code below */

?>

<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 150 112" enable-background="new 0 0 150 112" xml:space="preserve">

	 <style>
		@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600);

	 	text { font-family: 'Source Sans Pro', 'Calibri', Helvetica, Arial,  sans-serif; font-size: 8px;}
	 	.title { font-size: 9px; font-weight: 600; }
	 </style>

	<text class="title" x="16.4798" y="10">Grade distribution (%)</text>
	
	<?php

		$numColumns = count($legendX);
		$numRows = count($legendY);

		// Legend on the left side
		echo '<text class="legend" x="5" y="' . $rowStart . '" fill="#888888">';
		echo '<tspan>';
		echo implode ( $legendY, '</tspan><tspan x="5" dy="' . $lineHeight . '">' );
		echo '</tspan>';
		echo '</text>';


		// Data columns
		for ( $c = 0; $c < $numColumns; $c++) {
			$colX = $colStart + ($c * $colSpace);

			// Clean up the data display
			for ( $j = 0; $j < $numRows; $j++ ) {
				$data[$c][$j] = number_format($data[$c][$j], 1);
			}

			echo '<text x="' . $colX . '" y="' . $rowStart . '" fill="#666666">';
			echo '<tspan text-anchor="end">';
			echo implode ( $data[$c], '</tspan><tspan x="' . $colX . '" dy="' . $lineHeight . '" text-anchor="end">' );
			echo '</tspan>';
			echo '</text>';
		}

		// Lines between rows
		for ( $l = 0; $l <= $numRows; $l++ ) { 
			$lineY = ($l * $lineHeight) + $rowStart - 9; ?>
			<line stroke="#cccccc" stroke-width="0.25" x1="16" y1="<?php echo $lineY; ?>" x2="150" y2="<?php echo $lineY; ?>"/>
		<?php }


		// Legend at the bottom
		for ( $l = 0; $l < $numColumns; $l++ ) {
			$xPos = ($l * $colSpace) + $colStart - 5;
			$yPos = ($numRows * $lineHeight) + $rowStart ;
			echo '<text x="' . $xPos . '" y="' . $yPos . '" fill="#888888" text-anchor="middle">' . $legendX[$l] . '</text>';
		}


		?>

</svg>
