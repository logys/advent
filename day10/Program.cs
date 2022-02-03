using System;
using System.Collections.Generic;

namespace day10
{
    class Program
    {
        static void Main(string[] args)
        {
		var line = "{([(<{}[<>[]}>{[]{[(<()>";
		Console.WriteLine("Es: "+ lineCorrupted(line));
        }

	static bool lineCorrupted(string line)
	{
		List<char> stack = new List<char>();
		foreach (char character in line){
			if(isClose(character)){
				var open = stack[stack.Count -1];
				stack.RemoveAt(stack.Count -1);
				if(open.Equals(character)){
					Console.WriteLine(open);
					Console.WriteLine(character);
					return true;
				}
			}else{
				stack.Add(character);
			}
		}
		return false;
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
