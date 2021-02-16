<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
 <title>Vizualizare Inregistrari</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 </head>
 <body>
 <img align="right" src="product-images/logo.jpg">
 <div id="header" align="left"><a href="index.php">LOGOUT</a>
 </div>
 <h1>Produsele existente pe stoc</h1>
 <?php
 // connectare bazadedate
 include("Conection.php");
 $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 // se preiau inregistrarile din baza de date
 $query="SELECT * FROM tblproduct";
 if ($result = mysqli_query($db,$query))
 { // Afisare inregistrari pe ecran
 if ($result->num_rows > 0)
 {
 // afisarea inregistrarilor intr-o table

 echo "<table border='1' cellpadding='10'>";

 // antetul tabelului
 echo
"<tr><th>ID</th><th>Numele produsului</th><th>Descrierea produsului</th><th>Imagine</th><th>Pret</th><th></th><th></th></tr>";

 while ($row = $result->fetch_object())
 {
 // definirea unei linii pt fiecare inregistrare
echo "<tr>";
echo "<td>" . $row->id . "</td>";
echo "<td>" . $row->name . "</td>";
echo "<td>" . $row->code . "</td>";
echo "<td>" . "<img src=".$row->image.">" . "</td>";
echo "<td>" . $row->price . "</td>";
 echo "<td><a href='modificamysqli.php?id=" . $row->id ."'>Modificare</a></td>";
 echo "<td><a href='stergeremysqli.php?id=" . $row->id ."'>Stergere</a></td>";
 echo "</tr>";
 }

 echo "</table>";
 }
 // daca nu sunt inregistrari se afiseaza un rezultat de eroare
 else
 {
 echo "Nu sunt inregistrari in tabela!";
 }
 }
 // eroare in caz de insucces in interogare
 else
 { echo "Error: " . $mysqli->error; }

 // se inchide
 $db->close();
 ?>
 <a href="adaugaremysqli.php">Adaugarea unei noi inregistrari</a>
 </body>
</html>
