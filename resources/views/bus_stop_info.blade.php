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
   top: 7%;
   bottom: 0;
   left: 0;
   right: 0;
   padding-top: 1%;
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

<body>

  <div class="table-users">
    <p>Tuesday, 13 November 2018 21:00</p>
     <div class="header">Opp Sembawang Stn (1201)</div>

     <table cellspacing="0">
        <tr>
           <th>Service</th>
           <th>Incoming</th>
           <th>Destination</th>
        </tr>
        @foreach ($getBusStopInfo_array as $data)
        <tr>
           <td>{{$data->bus_service_no}}</td>
           <td>{{$data->stop_eta}} mins</td>
           <td>{{$data->Destination}}</td>
        </tr>
        @endforeach
        <tr>
           <td>117</td>
           <td>20 mins</td>
           <td>Sembawang Int</td>
        </tr>

        <tr>
           <td>Jane Doe</td>
           <td>jane.doe@foo.com</td>
           <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </td>
        </tr>

        <tr>
           <td>Jane Doe</td>
           <td>jane.doe@foo.com</td>
           <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </td>
        </tr>

        <tr>
           <td>Jane Doe</td>
           <td>jane.doe@foo.com</td>
           <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </td>
        </tr>
     </table>
  </div>







</body>
</html>