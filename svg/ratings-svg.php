<?php


/* Get class for building the graph bars */

	require_once('GraphBar.php');

	// GraphBar::$minInput = 1;
	// GraphBar::$maxInput = 5;
	// GraphBar::$minGraphCoordinate = 130;
	// GraphBar::$maxGraphCoordinate = 370;


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





/* Inputs */

	// Respondents
	$numResponded = check_input('r');
	$classSize    = check_input('n');

	// Title
	$title = check_input('t');

	// Number bars
	$sectionMean       = check_input('sm');
	$sectionConfidence = check_input('sc');

	$departmentMean       = check_input('dm');
	$departmentConfidence = check_input('dc');

	$collegeMean       = check_input('cm');
	$collegeConfidence = check_input('cc');

	$universityMean       = check_input('um');
	$universityConfidence = check_input('uc');

	if ( check_input('minN') ) { GraphBar::$minInput = $_REQUEST['minN']; }
	if ( check_input('maxN') ) { GraphBar::$maxInput = $_REQUEST['maxN']; }

	if ( check_input('minG') ) { GraphBar::$minGraphCoordinate = $_REQUEST['minG']; }
	if ( check_input('maxG') ) { GraphBar::$maxGraphCoordinate = $_REQUEST['maxG']; }


/* Outputs */

	// Title
		// SVG doesn't natively wrap text, so we have to insert <tspan> elements to get wrapping
	$glue = '</tspan><tspan x="0" dy="8.5">'; // The code we'll need to wrap lines in SVG
	$titleWrapped = wordwrap( $title, 30, $glue ); // Split the lines. This is the variable that gets inserted below in the SVG code.
	$titleLines = explode( $glue, $titleWrapped ); // Use this to check the number of lines
	$titleHover = null;
	
	if ( count($titleLines) > 3 ) // If there's more than 3 lines, cut it down to 3 and add ellipsis
	{
		$titleLines = array_slice( $titleLines, 0, 3);
		$titleWrapped = implode( $titleLines, $glue ) . "...";
		$titleHover = '<title>' . $title . '</title>'; // Add text hover to show the full title text
	}


	// Section bar
	if ( $sectionMean !== null)
	{
		$sectionObj = new GraphBar( $sectionMean, $sectionConfidence );
		$section = $sectionObj->getGraphCoordinates();
	} else {
		$section = false;
	}


	// Department bar
	if ( $departmentMean !== null )
	{
		$departmentObj = new GraphBar( $departmentMean, $departmentConfidence );
		$department = $departmentObj->getGraphCoordinates();
	} else {
		$department = false;
	}


	// College bar
	if ( $collegeMean !== null )
	{
		$collegeObj = new GraphBar( $collegeMean, $collegeConfidence );
		$college = $collegeObj->getGraphCoordinates();
	} else {
		$college = false;
	}


	// University bar
	if ( $universityMean !== null )
	{	
		$universityObj = new GraphBar( $universityMean, $universityConfidence );
		$university = $universityObj->getGraphCoordinates();
	} else {
		$university = false;
	}




/* Start the document */

	header("Content-type:image/svg+xml");
	echo '<?xml version="1.0" encoding="utf-8" ?>';

	/* */
?>





<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 435 35" enable-background="new 0 0 430 35" xml:space="preserve">
	
	<style>

		@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic);
	
		#Heading, #BG {
			font-family: 'Source Sans Pro', 'Calibri', Helvetica, Arial,  sans-serif;
		}
		#Title {
			font-size: 8.5px;
		}
		.respondents {
			font-size: 7px;
			font-style: italic;
		}
		.legend {
			font-size: 7px;
		}

	</style>



	<g id="BG">
		<?php if ( $section )    { ?><text class="legend" transform="matrix(1 0 0 1 398 6)"   fill="#BE2026">Section</text><?php } ?>
		<?php if ( $department ) { ?><text class="legend" transform="matrix(1 0 0 1 398 13)" fill="#F1B71C">Department</text><?php } ?>
		<?php if ( $college )    { ?><text class="legend" transform="matrix(1 0 0 1 398 20.5)" fill="#75C044">College</text><?php } ?>
		<?php if ( $university ) { ?><text class="legend" transform="matrix(1 0 0 1 398 28)" fill="#1F4389">University</text><?php } ?>
		
		<?php 
			// Get the boundaries of the input and the graph
			$input = $sectionObj->getInputRange();
			$graph = $sectionObj->getGraphBoundaries();

			// Add a vertical graph line for each whole number
			for ( $i = $input['min']; $i <= $input['max']; $i++ ) {

				$lineX = $sectionObj->translateCoordinates( $i ); ?>

				<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="<?php echo $lineX; ?>" y1="30" x2="<?php echo $lineX; ?>" y2="0"/> 

				<?php 
			}

		?>

	</g>




	<g id="Heading">
		<text id="Title" transform="matrix(1 0 0 1 2 8.0869)">
			<?php echo $titleHover; // There's no hover unless we truncate the title ?>

			<tspan>
				<?php echo $titleWrapped; ?>
			</tspan>
			
			<?php if ( $numResponded && $classSize ) { ?>
				<tspan class="respondents" x="0" dy="9" fill="#777777">
					<?php echo $numResponded; ?> / <?php echo $classSize; ?> responded
				</tspan>
			<?php } ?>
		</text>
	</g>




	<g id="Bars">
		
		<?php 
		if ( $section ) { // Only show the section bar if it's defined. ?>

			<g id="Section">
				<rect x="<?php echo $section['begin']; ?>" y="3" fill="#BF2026" width="<?php echo $section['length']; ?>" height="1"/>
				<line fill="none" stroke="#BF2026" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $section['begin']; ?>" y1="2" x2="<?php echo $section['begin']; ?>" y2="5"/>
				<line fill="none" stroke="#BF2026" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $section['end']; ?>"   y1="2" x2="<?php echo $section['end']; ?>"   y2="5"/>
			</g>
		
		<?php 
		}
		if ( $department ) { // Only show the dept bar if it's defined. ?>

			<g id="Dept">
				<rect x="<?php echo $department['begin']; ?>" y="9" fill="#CB7A29" width="<?php echo $department['length']; ?>" height="2"/>
				<line fill="none" stroke="#CB7A29" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $department['begin']; ?>" y1="8" x2="<?php echo $department['begin']; ?>" y2="12"/>
				<line fill="none" stroke="#CB7A29" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $department['end']; ?>"   y1="8" x2="<?php echo $department['end']; ?>"   y2="12"/>
			</g>

		<?php 
		}
		if ( $college ) { // Only show the college bar if it's defined. ?>

			<g id="College">
				<rect x="<?php echo $college['begin']; ?>" y="16" fill="#53A746" width="<?php echo $college['length']; ?>" height="3"/>
				<line fill="none" stroke="#53A746" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $college['begin']; ?>" y1="15" x2="<?php echo $college['begin']; ?>" y2="20"/>
				<line fill="none" stroke="#53A746" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $college['end']; ?>"   y1="15" x2="<?php echo $college['end']; ?>"   y2="20"/>
			</g>
		
		<?php
		}
		if ( $university ) { // Only show the university bar if it's defined. ?>

			<g id="Univ">
				<rect x="<?php echo $university['begin']; ?>" y="24" fill="#144A8A" width="<?php echo $university['length']; ?>" height="4"/>
				<line fill="none" stroke="#144A8A" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $university['begin']; ?>" y1="23" x2="<?php echo $university['begin']; ?>" y2="29"/>
				<line fill="none" stroke="#144A8A" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $university['end']; ?>"   y1="23" x2="<?php echo $university['end']; ?>"   y2="29"/>
			</g>

		<?php } ?>

	</g>
</svg>



<?php

// End of file