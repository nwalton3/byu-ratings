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

	public static $minInput = 1;
	public static $maxInput = 5;

	public static $minGraphCoordinate = 130;
	public static $maxGraphCoordinate = 370;


	/* Foundation variables for building the graph */

	protected $maxN; // The highest possible number that can be scored on the ratings scale
	protected $minN; // The lowest possible number that can be scored on the ratings scale
	protected $numSpan; // The absolute number of steps between min and max on the ratings scale

	protected $graphStartX; // The horizontal start coordinate of the visual graph
	protected $graphEndX;   // The horizontal end coordinate of the visual graph
	protected $graphWidth; // The absolute width of the graph

	protected $graphFactor; // The multiplier that translates the scale to the graph coordinates



	/* Constructor */

	public function __construct( $mean, $confidence )
	{
		$this->mean       = $mean;
		$this->confidence = $confidence;

		$this->minN = self::$minInput;
		$this->maxN = self::$maxInput;

		$this->graphStartX = self::$minGraphCoordinate;
		$this->graphEndX   = self::$maxGraphCoordinate;

		$this->numSpan = $this->maxN - $this->minN;
		$this->graphWidth = $this->graphEndX - $this->graphStartX;
		$this->graphFactor = $this->graphWidth / $this->numSpan;
	}



	/* Func: getGraphCoordinates
	 * Desc: Translate the raw numbers in to lines on the coordinate system
	 * Args: $n - The raw number calculated from the survey data (based on a 1-5 scale)
	 */
	public function getGraphCoordinates()
	{

		// Get the two ends of the graph bar by adding or subtracting the confidence interval
		$low  = $this->mean - $this->confidence;
		$high = $this->mean + $this->confidence;

		// Translate those numbers into coordinates on the graph
		$begin  = $this->translateCoordinates( $low );
		$end    = $this->translateCoordinates( $high );

		// Return an array with the correct coordinates to be used in the SVG
		$array = [
			'begin'  => $begin,
			'end'    => $end,
			'length' => $end - $begin,
		];

		return $array;
	}


	/* Func: translateCoordinates
	 * Desc: Translate the raw numbers in to lines on the coordinate system
	 * Args: $n - The raw number calculated from the survey data (based on a 1-5 scale)
	 */
	protected function translateCoordinates( $n )
	{
		// Make the numbering start at zero
		$num = $n - $this->minN;

		// Translate the number to a coordinate in the SVG graphic
		return $this->graphStartX + ( $num * $this->graphFactor );
	}

}