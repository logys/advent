import unittest
from Day9 import Point
from Day9 import getAround
from Day9 import readMatrix
from Day9 import getBashinLen
from Day9 import score1
from Day9 import score2
from Day9 import isMin
from Day9 import getMins
from Day9 import removePointsDuplicated

class TestDay9(unittest.TestCase):

    def test_getBashin(self):
        point = Point(0, 1)
        matrix = readMatrix("input-test")
        get = getBashinLen(point, matrix)
        want = 3
        self.assertEqual(want, get)

    def test_getBashin2(self):
        point = Point(1, 1)
        matrix = [
                [2, 2, 2],
                [2, 1, 2],
                [2, 2, 2],
                ]
        get = getBashinLen(point, matrix)
        want = 5
        self.assertEqual(want, get)

    def test_getBashin3(self):
        point = Point(1, 1)
        matrix = [
                [2, 3, 4],
                [1, 0, 5],
                [8, 7, 6],
                ]
        get = getBashinLen(point, matrix)
        want = 9
        self.assertEqual(want, get)

    def test_getScore(self):
        matrix = readMatrix("input-test")
        get = score2(matrix)
        want = 1134
        self.assertEqual(want, get)

    def test_isMin(self):
        matrix = readMatrix("input-test")
        get = isMin(Point(0, 9), matrix)
        want = True
        self.assertEqual(want, get)

    def test_getMins(self):
        matrix = readMatrix("input-test")
        get = getMins(matrix)
        want = [Point(0, 1), Point(0, 9), Point(2, 2), Point(4, 6)]
        self.assertEqual(want, get)

    def test_remove_duplicates(self):
        duplicates = [Point(0, 1), Point(0, 1)]
        get = removePointsDuplicated(duplicates)
        want = [Point(0, 1)]
        self.assertEqual(want, get)

if __name__ == '__main__':
    unittest.main()
