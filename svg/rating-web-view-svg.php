<?php


/* Start the document */

	header("Content-type:image/svg+xml");
	echo '<?xml version="1.0" encoding="utf-8" ?>';

	require_once('GraphBar.php');
	// GraphBar::$minInput = 1;
	// GraphBar::$maxInput = 5;
	GraphBar::$minGraphCoordinate = 0;
	GraphBar::$maxGraphCoordinate = 99;


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

	$numSteps = 5;



/* Outputs */

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




/* SVG code below */

?>


<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="60"
		viewbox="0 0 600 60" preserveAspectRatio="none">
	
	<g id="lines">
		<?php
		// Draw the lines
		for ( $i = 0; $i < $numSteps; $i++ )
		{
			$xPos = GraphBar::$maxGraphCoordinate / ($numSteps - 1) * $i;
			echo '<line fill="none" stroke="#aaaaaa" stroke-width="1" x1="' . $xPos . '%" y1="0" x2="' . $xPos . '%" y2="60" transform="translate(2)"/>';
		}
		?>
	</g>

	<g id="Bars">
		
		<?php 
		if ( $section ) { // Only show the section bar if it's defined. ?>

			<g id="Section" transform="translate(2, 3)">
				<rect x="<?php echo $section['begin']; ?>%" y="2" fill="#BF2026" width="<?php echo $section['length']; ?>%" height="3"/>
				<line fill="none" stroke="#BF2026" stroke-linecap="round" stroke-width="2" y1="0" y2="7" x1="<?php echo $section['begin']; ?>%" x2="<?php echo $section['begin']; ?>%"/>
				<line fill="none" stroke="#BF2026" stroke-linecap="round" stroke-width="2" y1="0" y2="7" x1="<?php echo $section['end']; ?>%"   x2="<?php echo $section['end']; ?>%"  />
			</g>
		
		<?php 
		}
		if ( $department ) { // Only show the dept bar if it's defined. ?>

			<g id="Dept" transform="translate(2, 16)">
				<rect x="<?php echo $department['begin']; ?>%" y="2" fill="#CB7A29" width="<?php echo $department['length']; ?>%" height="4"/>
				<line fill="none" stroke="#CB7A29" stroke-linecap="round" stroke-width="2" y1="0" y2="8" x1="<?php echo $department['begin']; ?>%" x2="<?php echo $department['begin']; ?>%"/>
				<line fill="none" stroke="#CB7A29" stroke-linecap="round" stroke-width="2" y1="0" y2="8" x1="<?php echo $department['end']; ?>%"   x2="<?php echo $department['end']; ?>%"  />
			</g>

		<?php 
		}
		if ( $college ) { // Only show the college bar if it's defined. ?>

			<g id="College" transform="translate(2, 30)">
				<rect x="<?php echo $college['begin']; ?>%" y="2" fill="#53A746" width="<?php echo $college['length']; ?>%" height="5"/>
				<line fill="none" stroke="#53A746" stroke-linecap="round" stroke-width="2" y1="0" y2="9" x1="<?php echo $college['begin']; ?>%" x2="<?php echo $college['begin']; ?>%"/>
				<line fill="none" stroke="#53A746" stroke-linecap="round" stroke-width="2" y1="0" y2="9" x1="<?php echo $college['end']; ?>%"   x2="<?php echo $college['end']; ?>%"  />
			</g>
		
		<?php
		}
		if ( $university ) { // Only show the university bar if it's defined. ?>

			<g id="Univ" transform="translate(2, 45)">
				<rect x="<?php echo $university['begin']; ?>%" y="2" fill="#144A8A" width="<?php echo $university['length']; ?>%" height="6"/>
				<line fill="none" stroke="#144A8A" stroke-linecap="round" stroke-width="2" y1="0" y2="10" x1="<?php echo $university['begin']; ?>%" x2="<?php echo $university['begin']; ?>%"/>
				<line fill="none" stroke="#144A8A" stroke-linecap="round" stroke-width="2" y1="0" y2="10" x1="<?php echo $university['end']; ?>%"   x2="<?php echo $university['end']; ?>%"  />
			</g>

		<?php } ?>

	</g>

</svg>

