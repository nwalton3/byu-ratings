<?php


/* Start the document */

	header("Content-type:image/svg+xml");
	echo '<?xml version="1.0" encoding="utf-8" standalone="no"?>';


/* Get class for building the graph bars */

	require('GraphBar.php');

	// GraphBar::$minInput = 1;
	// GraphBar::$maxInput = 5;
	// GraphBar::$minGraphCoordinate = 130;
	// GraphBar::$maxGraphCoordinate = 370;


/* Inputs */


	// Respondents
	$numResponded = 220; // r
	$classSize = 549; // n

	// Title
	$titleLine1 = "Meaningful Opportunities"; // t1
	$titleLine2 = "and Encouragement"; // t2

	// Number bars
	$sectionMean = 4.2; // sm
	$sectionConfidence = 0.75; // sc

	$departmentMean = 4.1; // dm
	$departmentConfidence = 0.5; // dc

	$collegeMean = 4.0; // cm
	$collegeConfidence = 0.35; // cc

	$universityMean = 3.9; // um
	$universityConfidence = 0.25; // uc






/* Outputs */

	// Section bar
	$sectionObj = new GraphBar( $sectionMean, $sectionConfidence );
	$section = $sectionObj->getGraphCoordinates();

	// Department bar
	$departmentObj = new GraphBar( $departmentMean, $departmentConfidence );
	$department = $departmentObj->getGraphCoordinates();

	// College bar
	$collegeObj = new GraphBar( $collegeMean, $collegeConfidence );
	$college = $collegeObj->getGraphCoordinates();

	// University bar
	$universityObj = new GraphBar( $universityMean, $universityConfidence );
	$university = $universityObj->getGraphCoordinates();


?>


<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 422 30" enable-background="new 0 0 422 30" xml:space="preserve">
	
	<style>
		.legend {
			font-family: 'Calibri';
			font-size: 7px;
		}
		#Title {
			font-family: 'Calibri';
			font-size: 9px;
		}
	</style>



	<g id="BG">
		<text class="legend" transform="matrix(1 0 0 1 380 6)"   fill="#BE2026">Section</text>
		<text class="legend" transform="matrix(1 0 0 1 380 13)" fill="#F1B71C">Department</text>
		<text class="legend" transform="matrix(1 0 0 1 380 20.5)" fill="#75C044">College</text>
		<text class="legend" transform="matrix(1 0 0 1 380 28)" fill="#1F4389">University</text>
		
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="130" y1="30" x2="130" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="190" y1="30" x2="190" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="250" y1="30" x2="250" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="310" y1="30" x2="310" y2="0"/>
		<line fill="none" stroke="#888888" stroke-width="0.25" stroke-miterlimit="10" x1="370" y1="30" x2="370" y2="0"/>
	</g>




	<g id="Heading">
		<text id="Respondents" transform="matrix(1 0 0 1 2 27.3378)" fill="#666766" font-family="'Calibri-Italic'" font-size="8">
			<?php echo $numResponded; ?>/<?php echo $classSize; ?> responded
		</text>

		<text id="Title" transform="matrix(1 0 0 1 2 8.0869)">
			<tspan x="0" y="0">
				<?php echo $titleLine1; ?>
			</tspan>
			<tspan x="0" y="9">
				<?php echo $titleLine2; ?>
			</tspan>
		</text>
	</g>




	<g id="Bars">

		<g id="Section">
			<rect x="<?php echo $section['begin']; ?>" y="3" fill="#BF2026" width="<?php echo $section['length']; ?>" height="1"/>
			<line fill="none" stroke="#BF2026" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $section['begin']; ?>" y1="2" x2="<?php echo $section['begin']; ?>" y2="5"/>
			<line fill="none" stroke="#BF2026" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $section['end']; ?>"   y1="2" x2="<?php echo $section['end']; ?>"   y2="5"/>
		</g>

		<g id="Dept">
			<rect x="<?php echo $department['begin']; ?>" y="9" fill="#CB7A29" width="<?php echo $department['length']; ?>" height="2"/>
			<line fill="none" stroke="#CB7A29" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $department['begin']; ?>" y1="8" x2="<?php echo $department['begin']; ?>" y2="12"/>
			<line fill="none" stroke="#CB7A29" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $department['end']; ?>"   y1="8" x2="<?php echo $department['end']; ?>"   y2="12"/>
		</g>

		<g id="College">
			<rect x="<?php echo $college['begin']; ?>" y="16" fill="#53A746" width="<?php echo $college['length']; ?>" height="3"/>
			<line fill="none" stroke="#53A746" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $college['begin']; ?>" y1="15" x2="<?php echo $college['begin']; ?>" y2="20"/>
			<line fill="none" stroke="#53A746" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $college['end']; ?>"   y1="15" x2="<?php echo $college['end']; ?>"   y2="20"/>
		</g>

		<g id="Univ">
			<rect x="<?php echo $university['begin']; ?>" y="24" fill="#144A8A" width="<?php echo $university['length']; ?>" height="4"/>
			<line fill="none" stroke="#144A8A" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $university['begin']; ?>" y1="23" x2="<?php echo $university['begin']; ?>" y2="29"/>
			<line fill="none" stroke="#144A8A" stroke-linecap="round" stroke-miterlimit="2" x1="<?php echo $university['end']; ?>"   y1="23" x2="<?php echo $university['end']; ?>"   y2="29"/>
		</g>

	</g>
</svg>



<?php

// End of file