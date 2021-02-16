<?php
include("Conection.php");
//se face conexiunea la baza de date
$db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
// se preia id din pagina vizualizare
 if (!empty($_POST['id']))
 //functia isset determina daca butonul de submit a fost apasat
 {
	 if (isset($_POST['submit']))
 	{ // verificam daca id-ul din URL este unul valid
 		if (is_numeric($_POST['id']))
		 { // preluam variabilele din form
		   //htmlentities converteste caracterele aplicabile in entitati html
		$id = $_POST['id'];
		$name = htmlentities($_POST['name'], ENT_QUOTES);
		$code = htmlentities($_POST['code'], ENT_QUOTES);
		$image = htmlentities($_POST['image'], ENT_QUOTES);
		$price = htmlentities($_POST['price'], ENT_QUOTES);
 // se verifica daca toate campurile sunt completate
 if ($name == '' || $code == ''||$image=='' || $price=='')
 { // daca nu sunt complete se va afisa un mesaj de eroare
	echo "<div> ERROR: Completati campurile obligatorii!</div>";
 }else { // daca sunt se va face modificarea
	$query1="UPDATE tblproduct SET name=?,code=?,image=?, price=? WHERE id='".$id."'";
	//prepare($query1) pregateste interogarea SQL pentru a fi utilizata in viitor
	if ($stmt = $db->prepare($query1))
 {
	 //bind_param() leaga parametrii de interogarea SQL si ii spune bazei de date care sunt parametrii
	 //"ssss" arata faptul ca urmeaza 4 parametrii care sunt de tipul string
 $stmt->bind_param("ssss",$name,$code,$image,$price);
 //se executa statamentul
 $stmt->execute();
 //se inchide
 $stmt->close();
 }// mesaj de eroare in caz ca nu se poate face modificarea
 else
 {
	 echo "ERROR: nu se poate executa update.";}
 }
 }
 // daca variabila 'id' nu este valida, se afiseaza un mesaj de eroare
 else
 {
	 echo "id incorect!";}
 }}?>
<html> <head><title> <?php if ($_GET['id'] != '') { echo "Modificare inregistrare"; } ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<body>
<h1><?php if ($_GET['id'] != '') { echo "Modificare Inregistrare"; }?></h1>
<?php //if ($error != '') {
 //echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error. "</div>";} ?>
<form action="" method="post">
 <div>
 <?php if ($_GET['id'] != '') { ?>
 <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
 <p>ID: <?php echo $_GET['id'];
 $query="SELECT * FROM tblproduct where id='".$_GET['id']."'";
if ($result = mysqli_query($db,$query))
 {
if ($result->num_rows > 0)
{ $row = $result->fetch_object();?></p>
<strong>Nume: </strong> <input type="text" name="name" value="<?php echo $row->name;
?>"/><br/>
 <strong>Code: </strong> <input type="text" name="code" value="<?php echo $row->code; ?>"/><br/>
<strong>Image: </strong> <input type="text" name="image" value="<?php echo $row->image; ?>"/><br/>
<strong>Price: </strong> <input type="text" name="price" value="<?php echo $row->price;}}}?>"/>
<br/>
<input type="submit" name="submit" value="Submit" />
<a href="vizualizare.php">Inapoi la vizualizare produse</a>
</div></form></body> </html>
