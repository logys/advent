# This is just an example to get you started. A typical binary package
# uses this file as the main entry point of the application.
import std/strutils

type
  Submarine = object
    x: int
    y: int
    aim: int

proc showData(x,y :int) =
  echo("x pos: ", x)
  echo("y pos: ", y)
  echo("Mul: ", x*y)

proc computeRoute(ship: var Submarine, data : FILE) =
  ship.x = 0;
  ship.y = 0;
  while true:
    try:
      var line = split(data.readLine())
      if line[0] == "forward" :
        ship.x += parseInt(line[1])
      elif line[0] == "down":
        ship.y += parseInt(line[1])
      elif line[0] == "up":
        ship.y -= parseInt(line[1])
      else :
        continue
    except:
      break

proc computeRoute2(ship: var Submarine, data : FILE) =
  ship.x = 0;
  ship.y = 0;
  ship.aim = 0;
  while true:
    try:
      var line = split(data.readLine())
      if line[0] == "forward" :
        ship.x += parseInt(line[1])
        ship.y += parseInt(line[1])*ship.aim
      elif line[0] == "down":
        ship.aim += parseInt(line[1])
      elif line[0] == "up":
        ship.aim -= parseInt(line[1])
      else :
        continue
    except:
      break
  
when isMainModule:
  var ship = Submarine()
  let input = open("input")
  computeRoute(ship, input)
  input.close()
  showData(ship.x, ship.y)
  let input2 = open("input")
  computeRoute2(ship, input2)
  input2.close()
  showData(ship.x, ship.y)
