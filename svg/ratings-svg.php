<?php


/* Start the document */

	header("Content-type:image/svg+xml");
	echo '<?xml version="1.0" encoding="utf-8" ?>';





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
	 *		 $default - A value to return if the specified variable is not available. If not set, defaults to null.
	 *		 $location - String - The location of the variables array. Can take 'GET', 'POST', or 'SESSION'. Defaults to 'GET'.
	 */
	function check_input( $var, $default = null, $location = 'GET' )
	{
		$loc = $_GET; // default
		if ( $location === 'POST' )    { $loc = $_GET; }
		if ( $location === 'SESSION' ) { $loc = $_SESSION; }

		return isset( $loc[$var] ) ? $loc[$var] : $default;
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





/* Outputs */

	// Title
		// SVG doesn't natively wrap text, so we have to insert <tspan> elements to get wrapping
	$glue = '</tspan><tspan x="0" dy="9">'; // The code we'll need to wrap lines in SVG
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

?>





<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 422 30" enable-background="new 0 0 422 30" xml:space="preserve">
	
	<style>

		@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic);
	
		#Heading, #BG {
			font-family: 'Source Sans Pro', 'Calibri', Helvetica, Arial,  sans-serif;
		}
		#Title {
			font-size: 9px;
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
		<?php if ( $section )    { ?><text class="legend" transform="matrix(1 0 0 1 380 6)"   fill="#BE2026">Section</text><?php } ?>
		<?php if ( $department ) { ?><text class="legend" transform="matrix(1 0 0 1 380 13)" fill="#F1B71C">Department</text><?php } ?>
		<?php if ( $college )    { ?><text class="legend" transform="matrix(1 0 0 1 380 20.5)" fill="#75C044">College</text><?php } ?>
		<?php if ( $university ) { ?><text class="legend" transform="matrix(1 0 0 1 380 28)" fill="#1F4389">University</text><?php } ?>
		
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="130" y1="30" x2="130" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="190" y1="30" x2="190" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="250" y1="30" x2="250" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="310" y1="30" x2="310" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="370" y1="30" x2="370" y2="0"/>
	</g>




	<g id="Heading">
		<text id="Title" transform="matrix(1 0 0 1 2 8.0869)">
			<?php echo $titleHover; ?>

			<tspan>
				<?php echo $titleWrapped; ?>
			</tspan>
			
			<?php if ( $numResponded && $classSize ) { ?>
				<tspan class="respondents" x="0" dy="10" fill="#777777">
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