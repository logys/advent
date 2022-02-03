import java.io.*;

public class Day6{
	static final int life_time = 6;
	static final int born_time = 8;

	public static void main(String[] args){
		long[] fishes = new long[9];
		fillSea("input", fishes);
		int days = 256;
		for(int i = 0; i<days; i++){
			advanceDays(fishes);
		}
		long fishes_counter = 0;
		for(int i = 0; i<fishes.length; i++){
			fishes_counter += fishes[i];
		}
		System.out.println("Peces totales: " + fishes_counter);
	}

	static void fillSea(String data, long[] fishes){
		try{
			FileReader file = new FileReader(data);
			BufferedReader input_buffer = new BufferedReader(file);
			String line = input_buffer.readLine();
			for(int i = 0; i<line.length(); i++){
				char c = line.charAt(i);
				if(line.charAt(i) == ',')
					continue;
				int num = (int)c;
				fishes[num-48] += 1;
			}
		}catch(IOException e){
			e.printStackTrace();
		}
	}

	static void advanceDays(long[] fishes){
		long borns = fishes[0];
		for(int i = 0; i<fishes.length-1; i++){
			fishes[i] = fishes[i+1];
		}
		fishes[born_time] = borns;
		fishes[life_time] += borns;
	}
}
