<?php declare(strict_types=1);

class Board
{
	public $points = array(array());

	public function fillBoardWithPoints($points)
	{
		foreach($points as $value){
			try{
				$this->points[$value->x][$value->y]++;
			}catch(Exception $e){
				$this->points[$value->x][$value->y] = 1;
			}
		}
	}

	public function countIntensePoints(): int
	{
		$counter = 0;
		foreach($this->points as $valor){
			foreach($valor as $value){
				if($value > 1)
					$counter++;
			}
		}
		return $counter;
	}

	public function fillBoardWithLines($lines) : void
	{
		foreach($lines as $value){
			$points = $value->getPoints();
			$this->fillBoardWithPoints($points);
		}
	}
}

class Point
{
	public $x;
	public $y;

	public function __construct($x, $y){
		$this->x = $x;
		$this->y = $y;
	}

	public function sameXYCoordinate($point) : bool
	{
		if($this->x == $point->x || $this->sameY($point))
			return true;
		return false;
	}

	public function sameY($point) : bool
	{
		if($this->y == $point->y)
			return true;
		return false;
	}
}

class Line
{
	private $begin;
	private $end;

	public function __construct($begin, $end)
	{
		$this->begin = $begin;
		$this->end = $end;
	}

	public function isRect() : bool
	{
		if($this->begin->sameXYCoordinate($this->end))
			return true;
		else 
			return false;
	}

	public function getPoints() : array
	{
		$result = array();
		
		if($this->isHorizontalLine()){
			foreach(range($this->begin->x, $this->end->x) as $value){
				$result[] = $this->rectEquation($this->begin, 
					$this->end, $value);
			}
		}else if($this->isDiag()){
			foreach(range($this->begin->x, $this->end->x) as $value){
				$result[] = $this->rectEquation($this->begin, 
					$this->end, $value);
			}
		}else{
			foreach(range($this->begin->y, $this->end->y) as $value){
				$result[] = new Point($this->end->x, $value);
			}
		}
		//print_r($result);
		return $result;
	}

	private function isHorizontalLine() : bool
	{
		return $this->begin->sameY($this->end);
	}

	public function rectEquation($point1, $point2, $abscissa) : Point
	{
		try{
			$y = ($point2->y -$point1->y)/($point2->x - $point1->x)*
				($abscissa - $point1->x) + $point1->y;
		}catch(Exception $e){
			return new Point($point1->y, $point1->y);
		}
		return new Point($abscissa, $y);
	}

	public function isDiag() : bool
	{
		$difx =abs($this->begin->x - $this->end->x);
		$dify =abs($this->begin->y - $this->end->y);

		if($difx == $dify)
			return true;
		else 
			return false;
	}

}
function interchangePoints(&$point1, &$point2) : void
{
	$tmp = $point1;
	$point1 = $point2;
	$point2 = $tmp;
}

set_error_handler('exceptions_error_handler');

function exceptions_error_handler($severity, $message, $filename, $lineno) {
  if (error_reporting() == 0) {
    return;
  }
  if (error_reporting() & $severity) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
  }
}

function parsePoint($point_string)
{
	$tmp = explode(",", $point_string);
	$result = new Point((int)$tmp[0],(int)$tmp[1]);
	return $result;
}

function parseLine($line_string)
{
	$tmp = explode("->", $line_string);
	$point1 = parsePoint($tmp[0]);
	$point2 = parsePoint($tmp[1]);
	$result = new Line($point1, $point2);
	return $result;
}

function getLines($file) : array
{
	$handle = fopen($file, 'r');
	$result = array();
	while (($line_string = fgets($handle)) !== false) {
		$line = parseLine($line_string);
		if($line->isRect())
			$result[] = $line;
	}
	fclose($handle);
	return $result;
}

function getLinesDiagonal($file) : array
{
	$handle = fopen($file, 'r');
	$result = array();
	while (($line_string = fgets($handle)) !== false) {
		$line = parseLine($line_string);
		if($line->isRect() || $line->isDiag())
			$result[] = $line;
	}
	fclose($handle);
	return $result;
}
$file = 'input';
$lines = getLinesDiagonal($file);
$board = new Board();
$board->fillBoardWithLines($lines);
echo 'Puntos calientes: ', $board->countIntensePoints(), "\n";
