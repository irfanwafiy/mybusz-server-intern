while true
:loop
  curl --data "param1=v1" http://192.168.10.10/calculateETA
  timeout /t 30
goto :loop 
