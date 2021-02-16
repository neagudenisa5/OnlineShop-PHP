<?php
include_once 'class.user.php';
$user = new User();
// Verific daca user este login sau nu
if (isset($_REQUEST['submit'])){
extract($_REQUEST);
$register = $user->reg_user($username,$password,$fullname,$email);
if ($register) {
// Inregistrare Success
echo 'Registration successful <a href="login.php">Click here</a> pt login';
}
else {
# Inregistrare esec
echo 'Inregistrare esec. Username exita';
}
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style><!--
#container{width:400px; margin: 0 auto;}
--></style>
<script type="text/javascript" language="javascript">
function submitreg() {
var form = document.reg;
if(form.username.value == ""){
alert( " Introdu username." );
return false;
}
else if(form.password.value == ""){
alert( " Introdu parola." );
return false;
}
else if(form.fullname.value == ""){
alert( " Introdu fullname." );
return false;
}
else if(form.email.value == ""){
alert( " Introdu email." );
return false;
}
}
</script>
<div id="container">
<h1>Inregistrare client nou</h1>
<form action="" method="post" name="reg">
<table>
<tbody>
<tr>
<th>Username:</th>
<td><input type="text" name="username" required="" /></td>
</tr>
<tr>
<th>Password:</th>
<td><input type="password" name="password" required="" /></td>
</tr>
<tr>
<th>Fullname:</th>
<td><input type="text" name="fullname" required="" /></td>
</tr>
<tr>
<th>Email:</th>
<td><input type="text" name="email" required="" /></td>
</tr>
<tr>

<tr>
<td></td>
<td><input onclick="return(submitreg());" type="submit" name="submit" value="Register" /></td>
</tr>
<tr>
<td></td>
<td>Ai deja un cont? Apasa <a href="login.php">aici</a></td>
</tr>
</tbody>
</table>
</form></div>
