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
				$result[] = new Point($value, $this->end->y);
			}
		}else{
			foreach(range($this->begin->y, $this->end->y) as $value){
				$result[] = new Point($this->end->x, $value);
			}
		}
		return $result;
	}

	private function isHorizontalLine() : bool
	{
		return $this->begin->sameY($this->end);
	}

	public function writeLineToBoard(&$board) : void
	{
		if($this->begin->x > $this->end->x){
			$tmp = $this->end->x;
			$this->end->x = $this->begin->x;
			$this->begin->x = $tmp;
		}
		if($this->begin->y > $this->end->y){
			$tmp = $this->end->y;
			$this->end->y = $this->begin->y;
			$this->begin->y = $tmp;
		}
		for($i = $this->begin->x; $i <= $this->end->x; $i++){
			for($j = $this->begin->y; $j <= $this->end->y; $j++){
				try{
					$board[$i][$j] += 1;
				}catch(Exception $e){
					$board[$i][$j] = 1;
				}
			}
		}
	}
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
	return $result;
}

$file = 'input';
$lines = getLines($file);
$board = new Board();
$board->fillBoardWithLines($lines);
echo 'Puntos calientes: ', $board->countIntensePoints(), "\n";
