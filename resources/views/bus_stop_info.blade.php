<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bus Stop Info</title>
<style>

@font-face {
    font-family: data-latin_font;
    src: url('{{ public_path('fonts/data-latin_font.tff') }}');
}

body {
   background-color: #FFFFFF;
}
.table-users{
    position: absolute;
    height: 100%;
    right: 0;
    bottom: auto;
    left: 0;
    top: -2.5%;
}
p {
  font-weight: bold;
  font-size: 125%;
}
.header {
   background-color: lightcyan;
   color: black;
   text-align: center;
   font-weight: bold;
   font-size: 230%;
   position: absolute;
   top: 8%;
   bottom: 0;
   left: 0;
   right: 0;
   padding-top: 0.5%;
}
table {
    position: absolute;
    top: 18%;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
}

th, td {
    text-align: center;
    color: #005555;
    font-size: 180%;
    width: 30%;
    padding: 1%;
}


tr:nth-child(odd){background-color: #AFEEEE;}
tr:nth-child(even){background-color: #FFFDD0;}


th {
    background-color: darkcyan;
    color: white;
}
</style>

</head>

<body onload="startTime()">
  <div class="table-users">
    <p id="clock"></p>
     <div class="header" id="stop_id" stop_id="{{$data['bus_stop_id']}}" num_bus="{{count($data['bus_data'])}}">{{$data['stop_name']}}</div>

     <table cellspacing="0">
        <tr>
           <th>Service</th>
           <th>Incoming</th>
           <th>Destination</th>
        </tr>
        @foreach($data['bus_data'] as $key=>$value)

        <tr>
           <td>{{$value['bus_service_no']}}</td>

           <!-- <td id="eta">{{$value['stop_eta']}}@if ($value['stop_eta'] != 'NA') @endif</td> -->
           <td id="eta{{$key}}" eta_date="{{$value['eta_date']}}" eta_grace_check="NA">{{$value['stop_eta']}}</td>

           <td id="route{{$key}}" route="{{$value['route']}}">{{$value['Destination']}}</td>
        </tr>
        {{++$key}}
        @endforeach
        <tr id="test">
        <tr>
     </table>



  </div>







</body>
<script>
var buses = 0;
function startScript(num_bus)
{
  buses = num_bus;
  startTime();
}
function startTime() {
    buses = parseInt(document.getElementById("stop_id").getAttribute("num_bus"));
    var today = new Date();
    var months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday","Friday",
    "Saturday"];
    var D = days[today.getDay()];
    var M = months[today.getMonth()];
    var Y = today.getFullYear();
    var d = today.getDate();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    var clock =D + ", " + d + " " + M + " " + " " + Y + " " + h + ":" + m + ":" + s;
    document.getElementById('clock').innerHTML = clock;
    for (var i =0; i < buses; i++)
    {
      var index_date = 'eta' + i;
      var index_route = 'route' + i;
      var bus_stop_id = document.getElementById("stop_id").getAttribute("stop_id");
      var eta_date = document.getElementById(index_date).getAttribute("eta_date");
      var bus_route = document.getElementById(index_route).getAttribute("route");
      var eta_grace_check = document.getElementById(index_date).getAttribute("eta_grace_check");
      if (eta_date == "NA")
      {
        if(eta_grace_check == "NA")
        {
          grace_time = 5 * 60000;
          eta_grace_check = today + grace_time;
          document.getElementById(index_date).getAttribute("eta_grace_check") = eta_grace_check;
        }
        else
        {
          var grace_check = new Date(eta_grace_check);
          if(grace_check >= today)
            {
              refresh(bus_stop_id, bus_route);
              document.getElementById(index_date).getAttribute("eta_grace_check") = "NA";
            }
        }

      }
      else
      {
        var eta_check = new Date(eta_date);

        if(today >= eta_check)
        {

          refresh(bus_stop_id, bus_route);
        }
      }


    }

    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

function refresh(bus_stop_id, bus_route) {
    const userAction = async () => {
    const response = await fetch('https://laravelsyd-fypfinalver.herokuapp.com/getBusStopInfo_refresh', {
      method: 'POST',
      body: {"bus_stop_id": bus_stop_id,
              "bus_route": bus_route}, // string or object
      headers:{
        'Content-Type': 'application/json'
      }
    });
    const myJson = await response.json(); //extract JSON from the http response
    document.getElementById('test').innerHTML = myJson;
  }
}

</script>

</html>
