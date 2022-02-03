#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>

int sum(int first, int second, int third);
bool incremented(int sum_a, int sum_b);

int main(void)
{
	FILE * input_data;
	input_data = fopen("input", "r");
	if( input_data == NULL){
		puts("No hay un fichero llamado input, que contenga los datos");
		return 1;
	}
	int last = 0;
	int current = 0;
	int counter = 0;
	char buffer[100];

	/* Part 1 */
	fgets(buffer, 100, input_data);
	last = atoi(buffer);
	while(fgets(buffer, 100, input_data)){
		current = atoi(buffer);
		if(current > last)
			counter++;
		last = current;
	}
	printf("Contador: %d\n", counter);
	fclose(input_data);

	/* Part 2 */
	int first = -1;
	int second = -1;
	int third = -1;
	int current_sum = -1;
	int last_sum = -1;
	counter = 0;
	input_data = fopen("input", "r");
	while(fgets(buffer, 100, input_data)){
		first = atoi(buffer);
		/* suma todo */
		current_sum = sum(first, second, third);
		if(incremented(current_sum, last_sum))
			counter++;
		/* Recorre los valores */
		last_sum = current_sum;
		third = second;
		second = first;
	}
	fclose(input_data);
	printf("Contador 2: %d\n", counter);
	return 0;
}

int sum(int first, int second, int third)
{
	if( (first == -1) | (second == -1) | (third == -1))
		return -1;
	return first + second + third;
}

bool incremented(int sum_a, int sum_b)
{
	if((sum_a == -1) | (sum_b == -1))
		return false;
	return sum_a > sum_b;
}
