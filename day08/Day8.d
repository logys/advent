import std.stdio;
import std.file;
import std.string;
import std.math;

void main()
{
	File file = File("input","r");
	int counter = 0;
	while (!file.eof()) { 
		string long_line = file.readln();
		if(!long_line)
			break;
		string [] data = long_line.split("|");
		string paterns = data[0].strip();
		string panel = data[1].strip();
		//counter += countNumbersInPanel(panel); //first part
		counter += decodedPanel(panel, paterns); //second part
     	}
	writeln(counter);
	file.close();
}

int countNumbersInPanel(string panel)
{
	string [] displays = panel.split(' ');
	int counter = 0;
	foreach(display; displays){
		if(display.length == 2 ||
			display.length == 3 ||
			display.length == 4 ||
			display.length == 7 )
			counter++;
	}
	return counter;
}

int decodedPanel(string panel, string paterns)
{
	string [] displays = panel.split(' ');
	string [] numbers = paterns.split(' ');
	string one_segments;
	foreach(number; numbers){
		if(number.length == 2)
			one_segments = number;
	}
	string four_segments;
	foreach(number; numbers){
		if(number.length == 4)
			four_segments = number;
	}
	int number = 0;
	foreach(i, display; displays){
		number += pow(10,3-i)*decodeDisplay(display, one_segments, four_segments);
	}
	return number;
}

unittest
{
	string panel = "cdfeb fcadb cdfeb cdbaf";
	string patterns = "acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab";
	auto want = 5353;
	auto get = decodedPanel(panel, patterns);

	assert(want == get);
}

int decodeDisplay(string segments, string one_pattern, string four_pattern)
{
	if(segments.length == 7)
		return 8;
	else if(segments.length == 3)
		return 7;
	else if(segments.length == 4)
		return 4;
	else if(segments.length == 2)
		return 1;
	else if(segments.length == 6)
		return decodeNineSixZero(segments, one_pattern, four_pattern);
	else if(segments.length == 5)
		return decodeFiveThreeTwo(segments, one_pattern, four_pattern);
	return -1;
}

int decodeNineSixZero(string display, string one_segments, string four_segments)
{
	if(countSegmentsInDisplay(display, one_segments) == 2)
		return decodeNineZero(display, four_segments);
	else
		return 6;
}

int countSegmentsInDisplay(string display, string segments)
{
	auto counter = 0;
	foreach(ch; segments){
		counter += count(display, ch);
	}
	return counter;
}

int decodeFiveThreeTwo(string display, string one_segments, string four_segments)
{
	if(countSegmentsInDisplay(display, one_segments) == 2)
		return 3;
	else
		return decodeFiveTwo(display, four_segments);
}

int decodeNineZero(string display, string four_segments)
{
	if(countSegmentsInDisplay(display, four_segments) == 4)
		return 9;
	else
		return 0;
}

int decodeFiveTwo(string display, string four_segments)
{
	if(countSegmentsInDisplay(display, four_segments) == 2)
		return 2;
	else
		return 5;
}

unittest
{
	//Decode 8
	assert(decodeDisplay("abcdefg", "","") == 8, "No decodifica 8");
}

unittest
{
	//Decode 7
	assert(decodeDisplay("abc", "", "") == 7, "No decodifica 7");
}

unittest
{
	//Decode 4
	assert(decodeDisplay("abcd", "", "") == 4, "No decodifica 4");
}

unittest
{
	//Decode 1
	assert(decodeDisplay("ab", "", "") == 1, "No decodifica 1");
}

unittest
{
	//Decode 9
	assert(decodeDisplay("cefabd", "ab", "eafb") == 9, "No decodifica 9");
}

unittest
{
	//Decode 6 whit pattern
	string pattern_one = "ab";
	string pattern_four ="eafb";
	string six = "cdfgeb";

	int get = decodeDisplay(six, pattern_one, pattern_four);
	int want = 6;

	assert( want == get, "No decodifica 6, con patrón");
}

unittest
{
	//Decode 6 whit different pattern 
	string pattern_one = "be";
	string pattern_four ="cgeb";
	string six = "fgaecd";

	int get = decodeDisplay(six, pattern_one, pattern_four);
	int want = 6;

	assert( want == get, "No decodifica 6, con diferente patrón");
}

unittest
{
	//Decode 0 whit pattern
	string pattern_one = "ab";
	string pattern_four ="eafb";
	string zero = "cagedb";

	int get = decodeDisplay(zero, pattern_one, pattern_four);
	int want = 0;

	assert( want == get, "No decodifica 0, con patrón");
}

unittest
{
	//Decode 0 whit different pattern
	string pattern_one = "be";
	string pattern_four ="cgeb";
	string zero = "agebfd";

	int get = decodeDisplay(zero, pattern_one, pattern_four);
	int want = 0;

	assert( want == get, "No decodifica 0, con diferente patrón");
}

unittest
{
	//Decode 9 whit pattern
	string pattern_one = "ab";
	string pattern_four ="eafb";
	string nine = "cefabd";

	int get = decodeDisplay(nine, pattern_one, pattern_four);
	int want = 9;
	assert( want == get, "No decodifica 9, con patrón");
}

unittest
{
	//Decode 0 whit different pattern
	string pattern_one = "be";
	string pattern_four ="cgeb";
	string nine = "cbdgef";

	int get = decodeDisplay(nine, pattern_one, pattern_four);
	int want = 9;

	assert( want == get, "No decodifica 0, con diferente patrón");
}

unittest
{
	//Decode 5
	assert(decodeDisplay("cdfbe", "", "") == 5, "No decodifica 5");
}

unittest
{
	//Decode 3
	string pattern_one = "ab";
	string pattern_four ="eafb";
	string three = "fbcad";

	int get = decodeDisplay(three, pattern_one, pattern_four);
	int want = 3;
	assert( want == get, "No decodifica 3, con patron");
}

unittest
{
	//Decode 3 whit different pattern
	string pattern_one = "be";
	string pattern_four ="cgeb";
	string three = "fecdb";

	int get = decodeDisplay(three, pattern_one, pattern_four);
	int want = 3;

	assert( want == get, "No decodifica 3, con diferente patrón");
}

unittest
{
	//Decode 2
	string pattern_one = "ab";
	string pattern_four ="eafb";
	string two = "gcdfa";

	int get = decodeDisplay(two, pattern_one, pattern_four);
	int want = 2;
	assert( want == get, "No decodifica 2, con patron");
}

unittest
{
	//Decode 2 whit different pattern
	string pattern_one = "be";
	string pattern_four ="cgeb";
	string two = "fabcd";

	int get = decodeDisplay(two, pattern_one, pattern_four);
	int want = 2;

	assert( want == get, "No decodifica 2, con diferente patrón");
}
