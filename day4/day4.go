package main

import "fmt"
import "os"
import "bufio"
import "strings"
import "strconv"

func main() {
	throws := getThrows("input")
	boards := getBoards("input")
	fmt.Printf("Puntuación 1: %d\n", computeGame(throws, boards))
	throws2 := getThrows("input")
	boards2 := getBoards("input")
	fmt.Printf("Puntuación 2: %d\n", computeGame2(throws2, boards2))
}

type Board struct{
}

func getThrows(data_input string)([]int) {
	file, _ := os.OpenFile(data_input, os.O_RDONLY, 0644)
	defer file.Close()

	line := bufio.NewScanner(file)
	line.Scan()

	throws_array := line.Text()
	throws_string := strings.Split(throws_array, ",")
	throws, _ := sliceAtoi(throws_string)

	return throws
}

func sliceAtoi(sa []string) ([]int, error) {
    si := []int{}
    for _, a := range sa {
        i, err := strconv.Atoi(a)
        if err != nil {
		continue
        }
        si = append(si, i)
    }
    return si, nil
}

func getBoards(data_input string) [][]int{
	file, _ := os.OpenFile(data_input, os.O_RDONLY, 0644)
	defer file.Close()
	line := bufio.NewScanner(file)
	line.Scan()
	board := [][]int{{}}

	i := 0
	row_counter := 0
	for line.Scan() {
		board_string := line.Text()
		if board_string == ""{
			continue
		}
		board_array := strings.Split(board_string, " ")
		dummy, _ := sliceAtoi(board_array)
		board[i] = append(board[i], dummy...)
		row_counter++
		if row_counter == 5{
			board = append(board, [][]int{{}}...)
			row_counter = 0
			i++
		}
	}
	return board[:len(board) - 1]
}

func throwMarkBoard(throw int, board []int){
	for i, _ := range board{
		if(board[i] == throw){
			board[i] = -1
		}
	}
}

func throw(throw int, boards [][]int){
	for i, _ := range boards{
		throwMarkBoard(throw, boards[i])
	}
}

func completedRow(board []int, row int) bool{
	columns := []int{}
	if row == 1{
		columns = append(columns, []int{0, 1, 2, 3, 4}...)
	}else if row == 2{
		columns = append(columns, []int{5, 6, 7, 8, 9}...)
	}else if row == 3{
		columns = append(columns, []int{10, 11, 12, 13, 14}...)
	}else if row == 4{
		columns = append(columns, []int{15, 16, 17, 18, 19}...)
	}else if row == 5{
		columns = append(columns, []int{20, 21, 22, 23, 24}...)
	}else{
		columns = append(columns, []int{}...)
	}
	for _, i := range columns{
		if board[i] != -1{
			return false
		}
	}
	return true
}

func completedColumn(board []int, column int) bool{
	rows := []int{}
	if column == 1{
		rows = append(rows, []int{0, 5, 10, 15, 20}...)
	}else if column == 2{
		rows = append(rows, []int{1, 6, 11, 16, 21}...)
	}else if column == 3{
		rows = append(rows, []int{2, 7, 12, 17, 22}...)
	}else if column == 4{
		rows = append(rows, []int{3, 8, 13, 18, 23}...)
	}else if column == 5{
		rows = append(rows, []int{4, 9, 14, 19, 24}...)
	}else{
		rows = append(rows, []int{}...)
	}
	for _, i := range rows{
		if board[i] != -1{
			return false
		}
	}
	return true
}

func completedBoard(board []int) bool{
	for i := 1; i<6; i++{
		if completedRow(board, i) || completedColumn(board, i){
			return true
		}
	}
	return false
}

func completedAnyBoard(board [][]int) (bool, int){
	for i, _ := range board{
		if completedBoard(board[i]){
			return true, i
		}
	}
	return false, -1
}

func computeWinnerBoard(board []int) int{
	sumator := 0
	for _, value := range board{
		if value != -1{
			sumator += value
		}
	}
	return sumator
}

func computeGame(throws []int, boards [][]int) int{
	for _, value := range throws{
		throw(value, boards)
		winner, boardWinner := completedAnyBoard(boards)
		if winner{
			return value * computeWinnerBoard(boards[boardWinner])
		}
	}
	return 0
}

func computeGame2(throws []int, boards [][]int) int{
	i := 0
	for ; i<(len(throws)-1); i++{
		throw(throws[i], boards)
		completed, number_completed := completedAnyBoard(boards)
		for completed{
			if len(boards) == 1 && completedBoard(boards[0]){
				return throws[i] * computeWinnerBoard(boards[0])
			}
			if completed{
				boards = append(boards[:number_completed], 
					boards[number_completed+1:]...)
			}
			completed, number_completed = completedAnyBoard(boards)
		}
	}
	fmt.Println(boards[0])
	fmt.Println(len(boards))
	return throws[i] * computeWinnerBoard(boards[0])
}
