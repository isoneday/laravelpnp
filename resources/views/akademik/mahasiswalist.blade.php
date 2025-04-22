<!DOCTYPE html>
<html lang="id">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Daftar Mahasiswa</title>
 <style>
   body {
     font-family: 'Arial', sans-serif;
     background: #f4f4f9;
     margin: 0;
     padding: 20px;
   }
   .container {
     max-width: 800px;
     margin: 0 auto;
     background: #fff;
     border-radius: 8px;
     box-shadow: 0 2px 4px rgba(0,0,0,0.1);
     padding: 20px;
   }
   h1 {
     text-align: center;
     color: #333;
   }
   table {
     width: 100%;
     border-collapse: collapse;
     margin-top: 20px;
   }
   th, td {
     text-align: left;
     padding: 12px 15px;
     border-bottom: 1px solid #ddd;
   }
   th {
     background-color: #007BFF;
     color: #fff;
   }
   tr:hover {
     background-color: #f1f1f1;
   }
 </style>
 </head>
<body>
 <div class="container">
   <h1>Daftar Mahasiswa</h1>
   <table>
     <thead>
       <tr>
         <th>No</th>
         <th>Nama</th>
         <th>NIM</th>
         <th>Jurusan</th>
       </tr>
     </thead>
     <tbody>
      
       <tr>
         <td>1</td>
         <td>{{ $mhs1 }} </td>
         <td>123456789</td>
         <td>Teknik Informatika</td>
       </tr>
         <tr>
         <td>1</td>
         <td>{{  $mhs2}} </td>
         <td>123456789</td>
         <td>Teknik Informatika</td>
       </tr>
      
       <tr>
         <td>1</td>
         <td>{{  $mhs3 }}</td>
         <td>123456789</td>
         <td>Teknik Informatika</td>
       </tr>
      
     </tbody>
   </table>
 </div>
 <h4  style="text-align: center;" class="container">Padang, &copy; <?= date("Y") ?></h4>
</body>
</html>
