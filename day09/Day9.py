from collections import deque

class Point():
    def __init__(self, row, col):
        self.row = row
        self.col = col

    def __eq__(self, other):
        if (isinstance(other, Point)):
            return self.row == other.row and self.col == other.col
        return False

def main():
    matrix = readMatrix("input-test")
    print("part 1: ", score1(matrix))
    print("part 2: ", score2(matrix))

def score1(matrix):
    score = 0
    mins = getMins(matrix)
    for point in mins:
        score += pointValue(point, matrix)
    return score + len(mins)

def pointValue(point, matrix):
    return matrix[point.row][point.col]

def removePointsDuplicated(points):
    result = []
    for point in points:
        if point not in result:
            result.append(point)
    return result

def score2(matrix):
    bashin_num = []
    for row in range(len(matrix)):
        for col in range(len(matrix[0])):
            bashin_num.append(getBashinLen(Point(row, col), matrix))
    bashin_num.sort()
    return bashin_num[-1]*bashin_num[-2]*bashin_num[-3]

def getMins(matrix):
    mins = []
    for row in range(len(matrix)):
        for col in range(len(matrix[0])):
            if isMin(Point(row, col), matrix):
                    mins.append(Point(row, col))
    return mins


def isMin(input_point, matrix):
    points = getAround(input_point, matrix)
    for point in points:
        if matrix[point.row][point.col] <= matrix[input_point.row][input_point.col]:
            return False
    return True

def pointIsNine(point, matrix):
    return pointValue(point, matrix) == 9

def getBashinLen(point, matrix):
    if pointIsNine(point, matrix):
        return 0
    visited = []
    buffer_point = deque();
    buffer_point.append(point)
    counter = 0
    while(buffer_point):
        tmp = buffer_point.popleft()
        if tmp in visited:
            continue
        visited.append(tmp)
        counter += 1
        around_points = getAround(tmp, matrix)
        for point in around_points:
            if pointValue(point, matrix) >= (pointValue(tmp, matrix)+1):
                buffer_point.append(point)

    return counter

def getAround(point, matrix):
    up = Point(point.row-1, point.col)
    right = Point(point.row, point.col+1)
    down = Point(point.row+1, point.col)
    left = Point(point.row, point.col-1)
    points_around = [up, right, down, left]
    points = []
    for i in range(4):
        if (not pointInBoard(points_around[i], matrix) or
                pointIsNine(points_around[i], matrix)):
                continue
        points.append(points_around[i])
    return points

def pointInBoard(point, matrix):
    rows_number = len(matrix)
    cols_number = len(matrix[0])
    if (point.row < 0 or point.col < 0 or
            point.row >= rows_number or point.col >= cols_number):
        return False
    return True

def readMatrix(file_name):
    file = open(file_name, 'r')
    lines = file.readlines()
    row = 0
    matrix = []
    for line in lines:
        matrix.append([])
        for i in range(len(line)-1):
            matrix[row].append(int(line[i]))
        row += 1
    file.close()
    return matrix

if __name__ == '__main__':
    main()
