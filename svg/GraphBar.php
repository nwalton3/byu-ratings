<?php 

/**
 * GraphBar
 *
 * This class provides methods for translating a set of data (the mean and confidence interval)
 * into the visual graph contained in the SVG graphics code below.
 *
 */
class GraphBar
{

	/* Variables required for constructor */

	protected $mean; // The mean of the student responses
	protected $confidence; // The confidence interval for those student responses

	/* Static variables. Use these to set default values for all graphs in a page if needed. */

	public static $minInput = 1;
	public static $maxInput = 5;

	public static $minGraphCoordinate = 130;
	public static $maxGraphCoordinate = 370;


	/* Foundation variables for building the graph. Initiated by constructor. */

	protected $inputMin; // The lowest possible number that can be scored on the ratings scale
	protected $inputMax; // The highest possible number that can be scored on the ratings scale
	protected $inputSpan; // The absolute number of steps between min and max on the ratings scale

	protected $graphMin; // The horizontal start coordinate of the visual graph
	protected $graphMax;   // The horizontal end coordinate of the visual graph
	protected $graphWidth; // The absolute width of the graph

	protected $graphFactor; // The multiplier that translates the scale to the graph coordinates



	/* Constructor */

	public function __construct( $mean, $confidence )
	{
		$this->mean       = $mean;
		$this->confidence = $confidence;

		$this->setInputRange ( self::$minInput, self::$maxInput );
		$this->setGraphBoundaries ( self::$minGraphCoordinate, self::$maxGraphCoordinate );
	}



	/* Func: getGraphCoordinates
	 * Desc: Translate the raw numbers in to lines on the coordinate system
	 * Args: $n - The raw number calculated from the survey data (based on a 1-5 scale)
	 */
	public function getGraphCoordinates()
	{

		// Get the two ends of the graph bar by adding or subtracting the confidence interval
		$conf = abs( $this->confidence ); // Use absolute value so low isn't above high
		$low  = $this->mean - $conf; 
		$high = $this->mean + $conf;

		// Check for accuracy
		if ( $low  < $this->inputMin ) { $low  = $this->inputMin; }
		if ( $high > $this->inputMax ) { $high = $this->inputMax; }


		// Translate those numbers into coordinates on the graph
		$begin  = $this->translateCoordinates( $low );
		$end    = $this->translateCoordinates( $high );

		// Return an array with the correct coordinates to be used in the SVG display
		$array = array(
			'begin'  => $begin,
			'end'    => $end,
			'length' => $end - $begin,
		);

		return $array;
	}


	/* Func: setInputRange
	 * Desc: Set the minimum and maximum number input to display on the graph
	 * Args: $min - The lowest number allowed in the graph bar
	 *		 $max - The highest number allowed
	 */
	public function setInputRange( $min, $max )
	{
		$this->inputMin = $min;
		$this->inputMax = $max;
		$this->inputSpan = $max - $min;
		$this->graphFactor = $this->graphWidth / $this->inputSpan;
	}


	/* Func: getInputRange
	 * Desc: Get the min and max number inputs that will be displayed on the graph
	 * Args: none
	 */
	public function getInputRange()
	{
		return array( 'min' => $this->inputMin, 'max' => $this->inputMax = $this->inputMax );
	}


	/* Func: setGraphBoundaries
	 * Desc: Set the minimum and maximum x coordinates of the graph
	 * Args: $min - The left-most x coordinate in the visual graph
	 *		 $max - The right-most x coordinate in the visual graph
	 */
	public function setGraphBoundaries( $min, $max )
	{
		$this->graphMin = $min;
		$this->graphMax = $max;
		$this->graphWidth = $max - $min;
		$this->graphFactor = $this->graphWidth / $this->inputSpan;
	}


	/* Func: getGraphBoundaries
	 * Desc: Get the left and right borders of the graph, based on the SVG coordinate system
	 * Args: none
	 */
	public function getGraphBoundaries()
	{
		return array( 'min' => $this->graphMin, 'max' => $this->graphMax );
	}


	/* Func: translateCoordinates
	 * Desc: Translate the raw numbers in to lines on the coordinate system
	 * Args: $n - The raw number calculated from the survey data (based on a 1-5 scale)
	 */
	public function translateCoordinates( $n )
	{
		// Make the numbering start at zero
		$num = $n - $this->inputMin;

		// Translate the number to a coordinate in the SVG graphic
		return $this->graphMin + ( $num * $this->graphFactor );
	}

}

