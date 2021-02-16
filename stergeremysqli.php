<?php
 // conectare la baza de date
 include("Conection.php");
 $db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 // se verifica daca id a fost primit si este numar valid
 if (isset($_GET['id']) && is_numeric($_GET['id']))
 {
 // preluam variabila 'id'
 $id = $_GET['id'];

 // stergem inregistrarea cu id=$id
 if ($stmt = $db->prepare("DELETE FROM tblproduct WHERE id = ? LIMIT 1"))
 {
 $stmt->bind_param("i",$id);
 $stmt->execute();
 $stmt->close();
 }
 else
 {
 echo "ERROR: Nu se poate executa delete.";
 }
 $db->close();
 echo "<div>Inregistrarea a fost stearsa!!!!</div>";
}
echo "<p><a href=\"vizualizare.php\">Inapoi la vizualizare produse</a></p>";
?>
