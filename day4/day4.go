package main

//import "fmt"
import "os"
import "bufio"
import "strings"
import "strconv"

func main() {
	//throws = getThrows()
}

type Board struct{
}

func getData()([]int, []Board) {
	file, _ := os.OpenFile("input-test", os.O_RDONLY, 0644)
	defer file.Close()

	line := bufio.NewScanner(file)
	line.Scan()

	throws_array := line.Text()
	throws_string := strings.Split(throws_array, ",")
	throws, _ := sliceAtoi(throws_string)

	return throws, []Board{}
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

func getBoard() [][]int{
	file, _ := os.OpenFile("input-test", os.O_RDONLY, 0644)
	defer file.Close()
	line := bufio.NewScanner(file)
	line.Scan()
	line.Scan()
	board := [][]int{{}}

	for i:= 0; i < 5; i++ {
		line.Scan()
		board_string := line.Text()
		board_array := strings.Split(board_string, " ")
		dummy, _ := sliceAtoi(board_array)
		board[0] = append(board[0], dummy...)
	}
	return board
}
