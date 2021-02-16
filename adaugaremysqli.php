<?php
 include("Conection.php");
 //conexiunea la baza de date
 $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 //functia isset determina daca butonul de submit a fost apasat
 if (isset($_POST['submit']))
 {
 // preluam datele de pe formular
 $name = htmlentities($_POST['name'], ENT_QUOTES);
 $code = htmlentities($_POST['code'], ENT_QUOTES);
 $image= htmlentities($_POST['image'], ENT_QUOTES);
 $price = htmlentities($_POST['price'], ENT_QUOTES);
 // verificam daca sunt completate
 if ($name == '' || $code == ''||$image==''||$price=='')
 {
 // daca sunt goale se afiseaza un mesaj de eroare
 $error = 'ERROR: Campuri goale!';

 } else {
 //se insereaza noul produs in baza de date
 if ($stmt = $db->prepare("INSERT into tblproduct (name, code, image, price) VALUES (?, ?, ?, ?)"))
 {
 $stmt->bind_param("ssss", $name, $code, $image, $price);
 $stmt->execute();
 $stmt->close();
 }
 // daca nu au fost adaugate datele bine va da eroare la inserare
 else
 {
 echo "ERROR: Nu se poate executa insert.";
 }

 }
 }

 // se inchide conexiunea bd
 $db->close();
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head> <title><?php echo "Inserare inregistrare"; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head> <body>
<h1><?php echo "Inserare inregistrare"; ?></h1>
<?php //if ($error != '') {
 //echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error. "</div>";} ?>
<form action="" method="post">
 <div>
<strong>Name: </strong> <input type="text" name="name" value=""/><br/>
<strong>Code: </strong> <input type="text" name="code" value=""/><br/>
<strong>Image: </strong> <input type="text" name="image" value=""/><br/>
<strong>Price: </strong> <input type="text" name="price" value=""/> <br/>
<input type="submit" name="submit" value="Submit" />
<a href="vizualizare.php">Vizualizare produse</a>
</div></form></body></html>
