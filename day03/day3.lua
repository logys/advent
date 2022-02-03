data = io.input("input")
number_counter = 0
ones_counter_table = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 , 0}
binary_size = 12

while true do
	local string_number = io.read()
	if string_number == nil then break end
	number_counter = number_counter + 1
	local number = tonumber(string_number, 2)
	for i = 1, binary_size do
		if (number&(1<<(binary_size-i))) ~= 0 then
			ones_counter_table[i] = ones_counter_table[i] + 1
		end
	end
end

omega = 0
epsilon = 0
for i = 1, binary_size do
	if (number_counter - ones_counter_table[i]) < number_counter/2 then
		omega = omega + (1<<(binary_size-i))
	else
		epsilon = epsilon + (1<<(binary_size-i))
	end
end
io.close(data)
print("omega epsilon: ", omega*epsilon)

--Second part
data = io.input("input")
binary_size = 12
data_oxygen = {}
i = 1
while true do
	local string_number = io.read()
	if string_number == nil then break end
	data_oxygen[i] = tonumber(string_number, 2)
	i = i+1
end

function getNoDominantBit(data, bit, priority)
	local counter = 0
	if priority == 1 then
		for i = 1, #data do
			if data[i]>>(binary_size - bit)&1 == 1 then
				counter = counter + 1
				if counter >= #data/2 then
					return 0
				end
			end
		end
		return 1
	else 
		for i = 1, #data do
			if data[i]>>(binary_size - bit)&1 == 0 then
				counter = counter + 1
				if counter > #data/2 then
					return 1
				end
			end
		end
		return 0
	end

end

function removeBinaryFromStack(value, bit, data)
	for i = #data ,1 , -1 do
		if data[i]>>(binary_size-bit)&1 == value then
			table.remove(data, i)
		end
	end
end

function table.shallow_copy(t)
  local t2 = {}
  for k,v in pairs(t) do
    t2[k] = v
  end
  return t2
end

data_co2 = table.shallow_copy(data_oxygen)

for i = 1, binary_size do
	nodomin = getNoDominantBit(data_oxygen, i, 1)
	removeBinaryFromStack(nodomin, i, data_oxygen)
end

for i = 1, binary_size do
	if #data_co2 == 1 then break end
	nodomin = getNoDominantBit(data_co2, i, 0)
	if nodomin == 1 then
		removeBinaryFromStack(0, i, data_co2)
	else
		removeBinaryFromStack(1, i, data_co2)
	end
	--print(#data_co2)
end

print(data_oxygen[1]*data_co2[1])
