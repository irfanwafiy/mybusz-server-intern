while true
:loop
  curl --data "param1=v1" http://homestead.mybusz/calculateETA
  timeout /t 30
goto :loop 
