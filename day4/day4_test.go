package main

import "testing"
import "reflect"


func TestThrows(t *testing.T){
	got, _ := getData()
	want := []int {7, 4, 9, 5, 11, 17, 23, 2, 0, 14, 21, 24, 10, 16, 13, 6, 15, 25, 12, 22, 18, 20, 8, 19, 3, 26, 1}
	if !reflect.DeepEqual(got, want) {
		t.Errorf("got %q want %q", got, want)
	}
}

func TestGetBoard(t *testing.T){
	t.Run("Get first board", func(t *testing.T) {
		got := getBoard()[0]
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
		got := getBoard()[1]
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
