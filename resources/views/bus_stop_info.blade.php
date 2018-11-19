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

<body onload="startTime()">
  <div class="table-users">
    <p id="clock"></p>
     <div class="header">{{$data['stop_name']}}</div>

     <table cellspacing="0">
        <tr>
           <th>Service</th>
           <th>Incoming</th>
           <th>Destination</th>
        </tr>
        @foreach($data['bus_data'] as $value)

        <tr>
           <td>{{$value['bus_service_no']}}</td>

           <td>{{$value['stop_eta']}}@if ($value['stop_eta'] != 'NA') mins @endif</td>


           <td>{{$value['Destination']}}</td>
        </tr>
        @endforeach

     </table>


  </div>







</body>
@section("scripts")

<!-- Scripts -->

<script src="{{ URL::asset('/js/clock.js') }}"></script>


@stop
</html>
