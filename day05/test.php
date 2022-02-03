<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class GeneralTests extends TestCase
{
	public function testSameCoordinate(): void
	{
		$point1 = new Point(1, 1);
		$point2 = new Point(1, 1);
		$get = $point1->sameXYCoordinate($point2);
		$want = true;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testParsePoint(): void
	{
		$get = parsePoint("1, 2");
		$want = new Point(1,2);

		$this->assertEquals(
			$want,
			$get
		);
    	}

	public function testSameY() : void
	{
		$point = parsePoint("1, 2");	
		$point2 = parsePoint("10, 2");	
		$get = $point->sameY($point2);
		$want = true;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testParseLine() : void
	{
		$get = parseLine("0,9 -> 5,9");
		$want = new Line(new Point(0, 9), new Point(5, 9));

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testIsLineRect() : void
	{
		$line = new Line(new Point(0, 9), new Point(5, 9));
		$get = $line->isRect();
		$want = true;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testIsNotLineRect() : void
	{
		$line = new Line(new Point(0, 8), new Point(5, 9));
		$get = $line->isRect();
		$want = false;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testIsDiag() : void
	{
		$line = new Line(new Point(0, 0), new Point(5, 5));
		$get = $line->isDiag();
		$want = true;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testIsNotDiag() : void
	{
		$line = new Line(new Point(0, 0), new Point(6, 5));
		$get = $line->isDiag();
		$want = false;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetLinesRects() : void
	{
		$file = 'input-test';
		$get = getLines($file)[1];
		$want = new Line(new Point(9, 4), new Point(3, 4));

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetLinesRectsAndDiag() : void
	{
		$file = 'input-test';
		$get = getLinesDiagonal($file)[1];
		$want = new Line(new Point(8, 0), new Point(0, 8));

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetPointsFromLine() : void
	{
		$line = parseLine("3,9 -> 3,7");
		$get = $line->getPoints();
		$want = array(new Point(3,9), new Point(3,8), new Point(3,7));

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetPointsFromLeftToUp() : void
	{
		$line = parseLine("3,3 -> 5,5");
		$get = $line->getPoints();
		$want = array(new Point(3,3), new Point(4,4), new Point(5,5));

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetPointsFromLeftToDown() : void
	{
		$line = parseLine("3,3 -> 5,1");
		$get = $line->getPoints();
		$want = array(new Point(3,3), new Point(4,2), new Point(5,1));

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testRectEquation() : void
	{
		$point1 = new Point(3,3);
		$point2 = new Point(5,1);
		$line = new Line($point1, $point2);
		$get = $line->rectEquation($point1, $point2, 5);
		$want = new Point(5,1);

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetPointsFromRightToUp() : void
	{
		$line = parseLine("8,0 -> 0,8");
		$get = $line->getPoints();
		$want = array(	new Point(8,0),
				new Point(7,1),
				new Point(6,2),
				new Point(5,3),
				new Point(4,4),
				new Point(3,5),
				new Point(2,6),
				new Point(1,7),
				new Point(0,8)
		);

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testGetPointsFromRightToDown() : void
	{
		$line = parseLine("6,4 -> 2,0");
		$get = $line->getPoints();
		$want = array(	new Point(6,4),
				new Point(5,3),
				new Point(4,2),
				new Point(3,1),
				new Point(2,0)
		);

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testAddPointsToBoard() : void
	{
		$board = new Board();
		$points = array(new Point(1, 1), new Point(1, 1));
		$board->fillBoardWithPoints($points);
		$get = $board->points[1][1];
		$want = 2;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testAddHorizontalLineToBoard() : void
	{
		$line = parseLine("3,0 -> 1,0");
		$board = new Board();
		$points = $line->getPoints();
		$board->fillBoardWithPoints($points);

		$get = $board->points[2][0];
		$want = 1;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testAddVerticalLineToBoard2() : void
	{
		$line = parseLine("3,9 -> 3,1");
		$board = new Board();
		$points = $line->getPoints();
		$board->fillBoardWithPoints($points);

		$get = $board->points[3][4];
		$want = 1;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testLenBoard() : void
	{
		$line = parseLine("1,0 -> 1,2");
		$board = new Board();
		$points = $line->getPoints();
		$board->fillBoardWithPoints($points);
		$get = count($board->points[1]);
		$want = 3;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testCounterSamePoint() : void
	{
		$line1 = parseLine("1,1 -> 1,4");
		$line2 = parseLine("1,1 -> 4,1");
		$points1 = $line1->getPoints();
		$points2 = $line2->getPoints();
		$board = new Board();
		$board->fillBoardWithPoints($points1);
		$board->fillBoardWithPoints($points2);
		$board->fillBoardWithPoints($points2);

		$get = $board->points[1][1];
		$want = 3;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testCountIntensePoints() : void
	{
		$line1 = parseLine("1,1 -> 1,4");
		$line2 = parseLine("1,1 -> 4,1");
		$points1 = $line1->getPoints();
		$points2 = $line2->getPoints();
		$board = new Board();
		$board->fillBoardWithPoints($points1);
		$board->fillBoardWithPoints($points2);

		$get = $board->countIntensePoints();
		$want = 1;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testNumLinesRects() : void
	{
		$file = 'input-test';
		$get = count(getLines($file));
		$want = 6;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testFillBoard() : void
	{
		$file = 'input-test';
		$lines = getLines($file);
		$board = new Board();
		$board->fillBoardWithLines($lines);
		$get =$board->points[3][4];
		$want = 2;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testCountAllPoints() : void
	{
		$file = 'input-test';
		$lines = getLines($file);
		$board = new Board();
		$board->fillBoardWithLines($lines);
		$get = $board->countIntensePoints();
		$want = 5;

		$this->assertEquals(
			$want,
			$get
		);
	}

	public function testCountAllPointsWhitDiags() : void
	{
		$file = 'input-test';
		$lines = getLinesDiagonal($file);
		$board = new Board();
		$board->fillBoardWithLines($lines);
		$get = $board->countIntensePoints();
		$want = 12;

		$this->assertEquals(
			$want,
			$get
		);
	}
}
