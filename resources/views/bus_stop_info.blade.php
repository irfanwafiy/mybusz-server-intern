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

<body onload="startScript({{count($data['bus_data'])}})">
  <div class="table-users">
    <p id="clock"></p>
     <div class="header">{{$data['stop_name']}}</div>

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
           <td id="eta{{$key}}" eta_date="{{$value['eta_date']}}">@if ($key < 1) 17:25:00 @elseif ($key >= 1) 17:26:00  @endif</td>

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
      var index = 'eta' + i
      var eta_date = document.getElementById(index).getAttribute("eta_date");
      if (eta_date == "NA")
      {
        if(i > 0)
        {
          eta_date = '2018-11-19 18:40:00';
        }
        else {
          eta_date = '2018-11-19 18:30:00';
        }

      }

      var eta_check = new Date(eta_date);

      if(today >= eta_check)
      {

        document.getElementById(index).innerHTML = "Update";
      }
    }

    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}

function refresh() {
    const userAction = async () => {
    const response = await fetch('http://example.com/movies.json', {
      method: 'POST',
      body: {""}, // string or object
      headers:{
        'Content-Type': 'application/json'
      }
    });
    const myJson = await response.json(); //extract JSON from the http response
    // do something with myJson
  }
}

</script>

</html>
