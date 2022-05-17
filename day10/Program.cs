using System;
using System.Collections.Generic;

namespace day10
{
    class Program
    {
        static void Main(string[] args)
        {
		Stack<char> stack = new Stack<char>();
		foreach (string line in System.IO.File.ReadLines("input"))
		{
			char corrupted_close = lineCorrupted(line);
			if (corrupted_close != '0')
				stack.Push(corrupted_close);
		}
		Dictionary<char, long> score = new Dictionary<char, long>();
		score.Add(')', 3);
		score.Add(']', 57);
		score.Add('}', 1197);
		score.Add('>', 25137);
		long result = 0;
		while(stack.Count > 0){
			result += score[stack.Pop()];
		}
		Console.WriteLine("Result 1: " + result);
		Console.WriteLine("Result 2: " + result2("input"));
        }

	static char lineCorrupted(string line)
	{
		Stack<char> stack = new Stack<char>();
		Dictionary<char, char> pair = new Dictionary<char, char>();
		pair.Add('(', ')');
		pair.Add('[', ']');
		pair.Add('<', '>');
		pair.Add('{', '}');
		foreach (char character in line){
			if(isClose(character)){
				if (pair[stack.Pop()] != character){
					return character;
				}
			}else{
				stack.Push(character);
			}
		}
		return '0';
	}

	static bool isClose(char simbol)
	{
		if(	simbol == ')' ||
			simbol == ']' ||
			simbol == '}' ||
			simbol == '>'
			)
			return true;
		return false;

	}

	static long result2(string file)
	{
		List<long> score_list = new List<long>();
		foreach (string line in System.IO.File.ReadLines(file)) {
			if (lineCorrupted(line) == '0')
				score_list.Add(lineScore(line));
		}
		score_list.Sort();
		int midle = score_list.Count/2;
		return score_list[midle];
	}

	static long lineScore(string line)
	{
		Stack<char> char_stack = new Stack<char>();
		foreach (char character in line) {
			if (isClose(character)){
				char_stack.Pop();
			} else {
				char_stack.Push(character);
			}
		}

		long score = 0;
		while(char_stack.Count > 0){
			score = score*5 + simbolValue(char_stack.Pop());
		}
		return score;
	}

	static long simbolValue(char simbol)
	{
		switch (simbol) {
			case '(':
				return 1;
			case '[':
				return 2;
			case '{':
				return 3;
			case '<':
				return 4;
		}
		return 0;
	}
    }
}

