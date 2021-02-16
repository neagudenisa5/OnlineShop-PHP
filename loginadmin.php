<?php
session_start();
include_once 'class_admin.php';
$admin = new Admin();
if (isset($_REQUEST['submit'])) {
//Metoda de extragere transformă perechile valoare din matricea $_REQUEST în variabile separate, dar numai pentru scopul funcției
	extract($_REQUEST);
//se foloseste funcia din class_admin.php pentru a vedea daca adminul se regaseste in tabela
 	$login = $admin->check_login($emailusername, $password);
 	if ($login) {
 // Daca inregistrarea e cu succes se va redirectiona spre pagina de vizualizare date
 		header("location:vizualizare.php");
 	} else {
 // Inregistrare cu esec
 	echo 'username sau password gresit!';
 }
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" language="javascript">
 function submitlogin() {
	 //se foloseste formularul pentru login
 	var form = document.login;
	 //daca nu s-a introdus nimic in campul de name
 	if(form.emailusername.value == ""){
		 //se va afisa un mesaj de alerta
		alert( "Introdu email sau username.");
		return false;
	}
	else if(form.password.value == ""){
		alert( "Introdu password." );
		return false;
	}
}

</script>
<span style="font-family: 'Courier 12, Courier, monospace; font-size: 12px; font-style: normal; line-height: 1;"><div id="container"></span>
<h1>Logheaza-te aici</h1>

<form action="" method="post" name="login">
<table>
<tbody>
<tr>
<th>Username:</th>
<td><input type="text" name="emailusername" required="" /></td>
</tr>
<tr>
<th>Parola:</th>
<td><input type="password" name="password" required="" /></td>
</tr>
<tr>
<td></td>
<td><input onclick="return(submitlogin());" type="submit" name="submit" value="Login" /></td>
</tr>
<tr>
<td></td>

</tbody>
</table>
</form></div>
