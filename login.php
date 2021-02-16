<?php
session_start();
include_once 'class.user.php';
//se creeaza un obiect de tipul User definit in class.user.php
$user = new User();
if (isset($_REQUEST['submit'])) {
	//Metoda de extragere transformă perechile valoare din matricea $_REQUEST în variabile separate, dar numai pentru scopul funcției
	extract($_REQUEST);
	//se foloseste funcia din class.user.php pentru a vedea daca userul se regaseste in tabela
 	$login = $user->check_login($emailusername, $password);
 	if ($login) {
 //daca inregistrarea a fost facuta cu succes se va redirectiona spre pahina de home.php
 		header("location:home.php");
	 }
	 else {
 // Inregistrare cu esec
 		echo 'username sau password gresit!';
 		}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style><!--
 #container{width:500px; margin: 0 auto;}
 #v document inseamna tot formularul
--></style>
<script type="text/javascript" language="javascript">
 function submitlogin() {
 var form = document.login;
 if(form.emailusername.value == ""){
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
<td><input onclick="return(submitlogin());" type="submit" name="submit" value="Catre cumparaturi" /></td>
</tr>
<tr>
<td></td>
<td>Esti un client nou al acestui magazin? iti poti face un cont <a href="registration.php">aici</a></td>
</tr>
</tbody>
</table>
</form></div>
