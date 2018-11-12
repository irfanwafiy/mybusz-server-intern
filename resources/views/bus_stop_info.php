<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Visit www.psdgraphics.com for more stuff</title>
<style>



body {
   background-color: lighten(#398B93, 30%);
   * { box-sizing: border-box; }
}

.header {
   background-color: darken(#398B93, 5%);
   color: white;
   font-size: 1.5em;
   padding: 1rem;
   text-align: center;
   text-transform: uppercase;
}

img {
   border-radius: 50%;
   height: 60px;
   width: 60px;
}

.table-users {
   border: 1px solid darken(#398B93, 5%);
   border-radius: 10px;
   box-shadow: 3px 3px 0 rgba(0,0,0,0.1);
   max-width: calc(100% - 2em);
   margin: 1em auto;
   overflow: hidden;
   width: 800px;
}

table {
   width: 100%;

   td, th {
      color: darken(#398B93, 10%);
      padding: 10px;
   }

   td {
      text-align: center;
      vertical-align: middle;

      &:last-child {
         font-size: 0.95em;
         line-height: 1.4;
         text-align: left;
      }
   }

   th {
      background-color: lighten(#398B93, 50%);
      font-weight: 300;
   }

   tr {
      &:nth-child(2n) { background-color: white; }
      &:nth-child(2n+1) { background-color: lighten(#398B93, 55%) }
   }
}

@media screen and (max-width: 700px) {
   table, tr, td { display: block; }

   td {
      &:first-child {
         position: absolute;
         top: 50%;
         transform: translateY(-50%);
         width: 100px;
      }

      &:not(:first-child) {
         clear: both;
         margin-left: 100px;
         padding: 4px 20px 4px 90px;
         position: relative;
         text-align: left;

         &:before {
            color: lighten(#398B93, 30%);
            content: '';
            display: block;
            left: 0;
            position: absolute;
         }
      }

      &:nth-child(2):before { content: 'Name:'; }
      &:nth-child(3):before { content: 'Email:'; }
      &:nth-child(4):before { content: 'Phone:'; }
      &:nth-child(5):before { content: 'Comments:'; }
   }

   tr {
      padding: 10px 0;
      position: relative;
      &:first-child { display: none; }
   }
}

@media screen and (max-width: 500px) {
   .header {
      background-color: transparent;
      color: lighten(#398B93, 60%);
      font-size: 2em;
      font-weight: 700;
      padding: 0;
      text-shadow: 2px 2px 0 rgba(0,0,0,0.1);
   }

   img {
      border: 3px solid;
      border-color: lighten(#398B93, 50%);
      height: 100px;
      margin: 0.5rem 0;
      width: 100px;
   }

   td {
      &:first-child {
         background-color: lighten(#398B93, 45%);
         border-bottom: 1px solid lighten(#398B93, 30%);
         border-radius: 10px 10px 0 0;
         position: relative;
         top: 0;
         transform: translateY(0);
         width: 100%;
      }

      &:not(:first-child) {
         margin: 0;
         padding: 5px 1em;
         width: 100%;

         &:before {
            font-size: .8em;
            padding-top: 0.3em;
            position: relative;
         }
      }

      &:last-child  { padding-bottom: 1rem !important; }
   }

   tr {
      background-color: white !important;
      border: 1px solid lighten(#398B93, 20%);
      border-radius: 10px;
      box-shadow: 2px 2px 0 rgba(0,0,0,0.1);
      margin: 0.5rem 0;
      padding: 0;
   }

   .table-users {
      border: none;
      box-shadow: none;
      overflow: visible;
   }
}
</style>

</head>

<body>

  <div class="table-users">
     <div class="header">Users</div>

     <table cellspacing="0">
        <tr>
           <th>Picture</th>
           <th>Name</th>
           <th>Email</th>
           <th>Phone</th>
           <th width="230">Comments</th>
        </tr>

        <tr>
           <td><img src="http://lorempixel.com/100/100/people/1" alt="" /></td>
           <td>Jane Doe</td>
           <td>jane.doe@foo.com</td>
           <td>01 800 2000</td>
           <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. </td>
        </tr>

        <tr>
           <td><img src="http://lorempixel.com/100/100/sports/2" alt="" /></td>
           <td>John Doe</td>
           <td>john.doe@foo.com</td>
           <td>01 800 2000</td>
           <td>Blanditiis, aliquid numquam iure voluptatibus ut maiores explicabo ducimus neque, nesciunt rerum perferendis, inventore.</td>
        </tr>

        <tr>
           <td><img src="http://lorempixel.com/100/100/people/9" alt="" /></td>
           <td>Jane Smith</td>
           <td>jane.smith@foo.com</td>
           <td>01 800 2000</td>
           <td> Culpa praesentium unde pariatur fugit eos recusandae voluptas.</td>
        </tr>

        <tr>
           <td><img src="http://lorempixel.com/100/100/people/3" alt="" /></td>
           <td>John Smith</td>
           <td>john.smith@foo.com</td>
           <td>01 800 2000</td>
           <td>Aut voluptatum accusantium, eveniet, sapiente quaerat adipisci consequatur maxime temporibus quas, dolorem impedit.</td>
        </tr>
     </table>
  </div>







</body>
</html>
