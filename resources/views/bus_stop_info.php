<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Visit www.psdgraphics.com for more stuff</title>
<style>

@font-face {
    font-family: data-latin_font;
    src: url('{{ public_path('fonts/data-latin_font.tff') }}');
}

body {
   background-color: #FFFFFF;
}

.table-users {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}
p {
  font-weight: bold;
}
.header {
   background-color: lightcyan;
   color: black;
   font-size: 1.5em;
   text-align: center;
   font-weight: bold;
   font-size: 230%;
   position: absolute;
   top: 5%;
   bottom: 0;
   left: 0;
   right: 0;
   padding-top: 1%;
}
table {
    position: absolute;
    top: 16%;
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
