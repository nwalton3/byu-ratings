<?php


/* Start the document */

	header("Content-type:image/svg+xml");
	echo '<?xml version="1.0" encoding="utf-8" ?>';


/* SVG code below */

?>

<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 viewBox="0 0 558 767" enable-background="new 0 0 558 767" xml:space="preserve">
	
	<!-- CSS Styles -->
	<style>
		@import url(http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600);
	
		g { font-family: 'Source Sans Pro', 'Calibri', Helvetica, Arial,  sans-serif; }
		#Title, #Cumulative, .sectionTitle { font-weight: 600; }
		.course { font-size: 18px; }
		.courseInfo { font-size: 14px; }
		.sectionTitle { font-size: 10px; fill: #444444; }
		.labels { font-size: 7.5px; }
		.labels text { fill: #777777; }
		.label { font-size: 10px; }
		.number { font-size: 11px; }
	</style>


	<!-- Page Header -->
	<g id="Header">

		<g id="Title">
			<text x="10" y="13" class="sectionTitle">BYU Student Rating Individual Section Report</text>
			<text x="10" y="36">
				<tspan class="course">ACC 200</tspan>
				<tspan class="courseInfo"> • Fall 2013 • Section 002</tspan>
			</text>
			<text x="10" y="52" font-size="14">Kay Stice</text>
		</g>

		<g id="Cumulative">
			<text x="435" y="25" font-size="9">Cumulative Course Evaluation</text>
			<text>
				<tspan x="465" y="40" class="label">Instruction:</tspan>
				<tspan x="525" y="40" class="number">4.55</tspan>
				<tspan x="465" y="52" class="label">Aims:</tspan>
				<tspan x="525" y="52" class="number">4.32</tspan>
			</text>
		</g>
	</g>



	<!-- Graphs for each outcome -->
	<g id="Outcomes">

		<?php 

			add_divider( "Course-specific Expected Learning Outcomes", 70 );

			/* Parameters used to build the graphs */

			/* You may want to make a separate parameter array for each graph you create, 
			 * but if there are overlapping values it makes sense to just use one and modify
			 * the values that change.
			 */
			$outcome = [
				'minN' => 1,  // The lowest number that can be input for the graph
				'maxN' => 5,  // The highest number that can be input for the graph
				't'  => "",   // Title
				'n'  => 698,  // Class size
				'r'  => 104,  // Respondents
				'sm' => 4,    // Section mean
				'sc' => 0.65, // Section confidence
			];

			// Add the first graph
			$outcome['t'] = 'Basic understanding of background business reading material';
			$outcome['sm'] = 4.0;
			add_ratings_svg( $outcome, 75);

			// Add another graph with minimal changes. 
			$outcome['t'] = 'Use computer-aided learning tools and online learning resources';
			$outcome['sm'] = 3.8;
			add_ratings_svg( $outcome, 115);

			// Add another graph with minimal changes
			$outcome['t'] = 'Intelligently converse about key principles';
			$outcome['sm'] = 3.9;
			add_ratings_svg( $outcome, 155);

		?>



		<g class="labels">
			<text transform="matrix(1 0 0 1 478 197)">
				<tspan x="0" y="0">Very</tspan>
				<tspan x="-8.7" y="8">Successful</tspan>
			</text>
			<text transform="matrix(1 0 0 1 409 197)">
				<tspan x="0" y="0">Successful</tspan>
			</text>
			<text transform="matrix(1 0 0 1 347.3155 197)">
				<tspan x="0" y="0">Moderately</tspan>
				<tspan x="2.2" y="8">Successful</tspan>
			</text>
			<text transform="matrix(1 0 0 1 291 197)">
				<tspan x="0" y="0">Not Very</tspan>
				<tspan x="-2.2" y="8">Successful</tspan>
			</text>
			<text transform="matrix(1 0 0 1 230 197)">
				<tspan x="0" y="0">Not at All</tspan>
				<tspan x="-1.4" y="8">Successful</tspan>
			</text>
		</g>
	</g>


	<g id="Instructor">

		<?php 

			add_divider( "Instructor Effectiveness", 215 );

			// Parameters used to build the graphs
			$instructor = [
				't'  => "",   // Title
				'n'  => 698,  // Class size
				'r'  => 104,  // Respondents
				'sm' => 4,    // Section mean
				'sc' => 0.65, // Section confidence
				'dm' => 3.9,  // Department mean
				'dc' => 0.4,  // Department confidence
				'cm' => 3.85, // College mean
				'cc' => 0.3,  // College confidence
				'um' => 3.7,  // University mean
				'uc' => 0.2,  // University confidence
			];

			$instructor['t'] = 'Meaningful opportunities and encouragement';
			add_ratings_svg( $instructor, 220);

			$instructor['t'] = 'Teaching challenging concepts and skills';
			add_ratings_svg( $instructor, 260);

			$instructor['t'] = 'Demonstrating respect for individual students';
			add_ratings_svg( $instructor, 300);

			$instructor['t'] = 'Organizing course content to enhance learning';
			add_ratings_svg( $instructor, 340);

			$instructor['t'] = 'Helping students who indicate a need for assistance';
			add_ratings_svg( $instructor, 380);

		?>


		<g class="labels">
			<text transform="matrix(1 0 0 1 482.7573 423.5413)">
				<tspan x="0" y="0">Very</tspan>
				<tspan x="-6.3" y="8">Effective</tspan>
			</text>
			<text transform="matrix(1 0 0 1 414.2002 423.5408)">Effective</text>
			<text transform="matrix(1 0 0 1 347.3155 423.4114)">
				<tspan x="0" y="0">Moderately</tspan>
				<tspan x="4.6" y="8">Effective</tspan>
			</text>
			<text transform="matrix(1 0 0 1 289.2007 423.5403)">
				<tspan x="0" y="0">Not Very</tspan>
				<tspan x="0.3" y="8">Effective</tspan>
			</text>
			<text transform="matrix(1 0 0 1 226.2539 423.9021)">
				<tspan x="0" y="0">Not at All</tspan>
				<tspan x="1" y="8">Effective</tspan>
			</text>
		</g>
	</g>



	<g id="Aims">

		<?php 

			add_divider( "Helped students achieve the Aims of a BYU Education", 435 );

			// Parameters used to build the graphs
			$byuAim = [
				't'  => "",   // Title
				'n'  => 698,  // Class size
				'r'  => 104,  // Respondents
				'sm' => 3.75,    // Section mean
				'sc' => 0.65, // Section confidence
				'dm' => 3.3,  // Department mean
				'dc' => 0.4,  // Department confidence
				'cm' => 3.6, // College mean
				'cc' => 0.3,  // College confidence
				'um' => 3.55,  // University mean
				'uc' => 0.2,  // University confidence
			];

			$byuAim['t'] = 'Spiritually strengthening';
			add_ratings_svg( $byuAim, 440);

			$byuAim['t'] = 'Intellectually enlarging';
			add_ratings_svg( $byuAim, 480);

			$byuAim['t'] = 'Character building';
			add_ratings_svg( $byuAim, 520);

			$byuAim['t'] = 'Leading to lifelong learning and service';
			add_ratings_svg( $byuAim, 560);


			add_legend( [ 'Detracted', 'No Effect', 'Moderately Enhanced', 'Enhanced', 'Strongly Enhanced' ] );
		?>

	</g>

	<line fill="none" stroke="#000000" stroke-width="0.25" stroke-miterlimit="2" x1="10" y1="628.5" x2="550" y2="628.5"/>

</svg>


<?php 




	
/* Variables */

	$contentStart = 70; // The starting location for new content. Will be updated by the add_ functions below.
	$graphMin = 115 + 130;
	$graphMax = 115 + 370;






/* Functions */

	/* Func: add_ratings_svg
	 * Desc: Add an SVG image from ratings-svg.php to show a new ratings graph
	 * Args: $arr - Array  - Contains key => value pair for all of the parameters needed in the ratings-svg.php graphic.
	 *       $loc - Number - The y coordinate where the graph should be placed
	 */
	function add_ratings_svg( $arr, $loc = null )
	{
		$q = http_build_query( $arr, '', '&amp;' );
		if ( $loc === null ) { $loc = $contentStart; }

		?><image xlink:href="ratings-svg.php?<?php echo $q; ?>" 
			x="115" y="<?php echo $loc; ?>" width="435" height="35" preserveAspectRatio="xMinYMin" /><?php

		$contentStart += 40;
	}


	/* Func: add_divider
	 * Desc: Add a dividing line with a title between ratings graphs
	 * Args: $title - String - The text of the title that should be displayed
	 *       $loc - Number - The y coordinate where the divider should be placed
	 */
	function add_divider( $title, $loc = null )
	{
		if ( $loc === null ) { $loc = $contentStart; }

		// SVG doesn't natively wrap text, so we have to insert <tspan> elements to get wrapping
		$glue = '</tspan><tspan x="10" dy="12">'; // The code we'll need to wrap lines in SVG
		$titleWrapped = wordwrap( $title, 20, $glue ); // Split the lines. This is the variable that gets inserted below in the SVG code.

		?>

			<line fill="none" stroke="#000000" stroke-width="0.25" stroke-miterlimit="2" x1="10" y1="<?php echo $loc; ?>" x2="550" y2="<?php echo $loc; ?>"/>
			<text x="10" y="<?php echo $loc + 15; ?>" class="sectionTitle">
				<tspan x="10" dy="0" >
					<?php echo $titleWrapped; ?>
				</tspan>
			</text>

		<?php

		$contentStart += 5;
	}


	/* Func: add_legend
	 * Desc: Add a legend after a set of ratings graphs
	 * Args: $legend - Array - A list of strings that define the levels of a graph.
	 */
	function add_legend( $legend, $loc = null )
	{
		if ( $loc === null ) { $loc = $contentStart; }

		?>

		<g class="labels">
			<text transform="matrix(1 0 0 1 477.1987 608.4956)">
				<tspan x="0" y="0">Strongly</tspan>
				<tspan x="-2.6" y="8">Enhanced</tspan>
			</text>
			<text transform="matrix(1 0 0 1 412.3704 609.7729)">Enhanced</text>
			<text transform="matrix(1 0 0 1 347.147 609.7725)">
				<tspan x="0" y="0">Moderately</tspan>
				<tspan x="2.9" y="8">Enhanced</tspan>
			</text>
			<text transform="matrix(1 0 0 1 289.3614 609.772)">No Effect</text>
			<text transform="matrix(1 0 0 1 225.3369 610.1338)">Detracted</text>
		</g>

		<?php

		$contentStart += 20;
	}
