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
		Dictionary<char, int> score = new Dictionary<char, int>();
		score.Add(')', 3);
		score.Add(']', 57);
		score.Add('}', 1197);
		score.Add('>', 25137);
		long result = 0;
		while(stack.Count > 0){
			result += score[stack.Pop()];
		}
		Console.WriteLine("Result 1: " + result);
		result = 0;
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
    }
}
