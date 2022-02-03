package main

import "testing"
import "reflect"

func TestGetBoard(t *testing.T){
	t.Run("Get first board", func(t *testing.T) {
		got := getBoards("input-test")[0]
		want := []int {	22, 13, 17, 11,  0,
		8,  2, 23,  4, 24,
		21,  9, 14, 16,  7,
		6, 10,  3, 18,  5,
		1, 12, 20, 15, 19}

		if !reflect.DeepEqual(got, want) {
			t.Errorf("got %q want %q", got, want)
		}
	})

	t.Run("Get second board", func(t *testing.T) {
		got := getBoards("input-test")[1]
		want := []int {	
			3, 15,  0,  2, 22,
			9, 18, 13, 17,  5,
			19,  8,  7, 25, 23,
			20, 11, 10, 24,  4,
			14, 21, 16, 12,  6}

		if !reflect.DeepEqual(got, want) {
			t.Errorf("got %q want %q", got, want)
		}
	})
}

func TestThrows(t *testing.T){
	t.Run("get throws list", func(t *testing.T) {
		got := getThrows("input-test")
		want := []int {	7, 4, 9, 5, 11, 17, 23, 2, 0, 14,
				21, 24, 10, 16, 13, 6, 15, 25, 12,
				22, 18, 20, 8, 19, 3, 26, 1}
		if !reflect.DeepEqual(got, want) {
			t.Errorf("got %q want %q", got, want)	
		}
	})

	t.Run("Mark 2 in second board, but no mark 3 in first board",
			func(t *testing.T) {
		board := getBoards("input-test")[1]
		throwMarkBoard(2, board)
		got2 := board[3]
		got3 := board[0]
		want2 := -1
		want3 := 3

		if got2 != want2 {
			t.Errorf("got %q want %q", got2, want2)
		}
		if got3 != want3 {
			t.Errorf("got %q want %q", got3, want3)
		}
	})

	t.Run("Mark 2 in all boards ", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(0, boards)
		got := boards[0][4]
		got2 := boards[1][2]
		want := -1

		if got != want {
			t.Errorf("got %q want %q", got, want)
		}
		if got2 != want {
			t.Errorf("got %q want %q", got2, want)
		}
	})
}


func TestCompletedLine(t *testing.T){
	t.Run("Check completed first row in first board", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(22, boards)
		throw(13, boards)
		throw(17, boards)
		throw(11, boards)
		throw(0, boards)
		got := completedRow(boards[0], 1)
		want := true

		if got != want {
			t.Errorf("got %t want %t", got, want)
		}
	})

	t.Run("Check completed second row in second board", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(9, boards)
		throw(18, boards)
		throw(13, boards)
		throw(17, boards)
		throw(5, boards)
		got := completedRow(boards[1], 2)
		want := true

		if got != want {
			t.Errorf("got %t want %t", got, want)
		}
	})

	t.Run("Check completed first column in first board", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(22, boards)
		throw(8, boards)
		throw(21, boards)
		throw(6, boards)
		throw(1, boards)
		got := completedColumn(boards[0], 1)
		want := true

		if got != want {
			t.Errorf("got %t want %t", got, want)
		}
	})
}

func TestCompletedBoard(t *testing.T){
	t.Run("Check completed board", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(22, boards)
		throw(8, boards)
		throw(21, boards)
		throw(6, boards)
		throw(1, boards)
		got := completedBoard(boards[0])
		want := true

		if got != want {
			t.Errorf("got %t want %t", got, want)
		}
	})
}

func TestCompletedAnyBoard(t *testing.T){
	t.Run("Check completed Any board", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(4, boards)
		throw(19, boards)
		throw(20, boards)
		throw(5, boards)
		throw(7, boards)
		got, _ := completedAnyBoard(boards)
		want := true

		if got != want {
			t.Errorf("got %t want %t", got, want)
		}
	})
}

func TestComputeResult(t *testing.T){
	t.Run("Check computed result ", func(t *testing.T) {
		boards := getBoards("input-test")
		throw(4, boards)
		throw(19, boards)
		throw(20, boards)
		throw(5, boards)
		throw(7, boards)
		got := computeWinnerBoard(boards[2])
		want := 270

		if got != want {
			t.Errorf("got %q want %q", got, want)
		}
	})

	t.Run("Check game result", func(t *testing.T) {
		throws := getThrows("input-test")
		boards := getBoards("input-test")
		got := computeGame(throws, boards)
		want := 4512

		if got != want {
			t.Errorf("got %d want %d", got, want)
		}
	})
}

func TestComputeResult2part(t *testing.T){
	t.Run("Check game result", func(t *testing.T) {
		throws := getThrows("input-test")
		boards := getBoards("input-test")
		got := computeGame2(throws, boards)
		want := 1924

		if got != want {
			t.Errorf("got %d want %d", got, want)
		}
	})
}
