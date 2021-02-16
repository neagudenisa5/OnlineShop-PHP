<?php
session_start();
include_once 'class.user.php';
require_once("Conection.php");
$db_handle = new DBController();
$user = new User();
$uid = $_SESSION['uid'];
//daca persoana nu e logata ne redirectioneaza catre login.php
//get_session e functia din class.user.php
if (!$user->get_session()){
	header("location:login.php");
	}
if (isset($_GET['q'])){
	//user_logout e o functie din class.user.php ce distruge sesiunea si initiaza sesiunea de login cu false
	$user->user_logout();
	header("location:login.php");
	}
?>

<style><!--
body{
font-family:Arial, Helvetica, sans-serif;
}
h1{
font-family:'Georgia', Times New Roman, Times, serif;
}

--></style>
<div id="container">
<div id="header" align="left"><a href="index.php">LOGOUT</a>
<img align="right" src="product-images/logo.jpg">
</div>
<div id="main-body">
<h3>Bun venit la magazinul nostru online, <?php $user->get_fullname($uid); ?>. Spor la cumparaturi! Sa nu strici prea multi bani. </h3>
</div>
<div id="footer"></div>
</div>
<?php
//daca se intampla una din actiunile urmatoare: adaugare de produse, stergere de produse, golirea cosului, finalizarea cumparaturilor
if(!empty($_GET["action"])) {
switch($_GET["action"]) {
	//cazul in care se adauga un produs in cos
	case "add":
		//daca cantitatea aleasa nu este nula
		if(!empty($_POST["quantity"])) {
			//se selecteaza din baza de date produsul cu codul ales
			$productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
			//si se creeaza un array care contine toate datele produsului
			$itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"], 'image'=>$productByCode[0]["image"]));
			//daca sesiunea nu e goala
			if(!empty($_SESSION["cart_item"])) {
				//verifica daca produsul selectat exista deja in sesiunea creata
				if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
					//daca nu exista produsul
					foreach($_SESSION["cart_item"] as $k => $v) {
							if($productByCode[0]["code"] == $k) {
								if(empty($_SESSION["cart_item"][$k]["quantity"])) {
									$_SESSION["cart_item"][$k]["quantity"] = 0;
								}
								//creste cosul cu cantitatea selectata de produs
								$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
							}
					}
				} else {
					//se adauga la sesiunea cosului array-ul creat mai sus care contine datele produsului pe care dorim sa il adaugam
					$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
				}
			} else {
				//in cos raman valorile produsului selectat
				$_SESSION["cart_item"] = $itemArray;
			}
		}
	break;
	//cazul in care se sterge un produs din cos
	case "remove":
		if(!empty($_SESSION["cart_item"])) {
			foreach($_SESSION["cart_item"] as $k => $v) {
					if($_GET["code"] == $k)
						//se elimina tot cate un produs selectat
						unset($_SESSION["cart_item"][$k]);
					//daca cantitatea produsului a ajuns la 0 se elimina produsul din cos
					if(empty($_SESSION["cart_item"]))
						unset($_SESSION["cart_item"]);
			}
		}
	break;
	//cazul in care se goleste cosul
	case "empty":
		unset($_SESSION["cart_item"]);
		header("location:dc.php");
	//cazul in care se finalizeaza comanda
	case "finalizare":
		unset($_SESSION["cart_item"]);
		header("location:finalizare.php");
	break;
}
}
?>
<HTML>
<HEAD>
<TITLE>Mini LIDL</TITLE>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<div id="shopping-cart">
<div class="txt-heading">Cosul meu</div>

<a id="btnEmpty" href="home.php?action=finalizare"> Finalizare comanda</a>
<?php
//la inceputul cumparaturilor cosul este gol, cantitatile de produse sunt goale iar totalul este si el gol
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>
<table class="tbl-cart" cellpadding="10" cellspacing="1">
<tbody>
<tr>
<th style="text-align:left;">Name</th>
<th style="text-align:left;">Code</th>
<th style="text-align:right;" width="5%">Quantity</th>
<th style="text-align:right;" width="10%">Unit Price</th>
<th style="text-align:right;" width="10%">Price</th>
<th style="text-align:center;" width="5%">Remove</th>
</tr>
<?php
	//pentru fiecare produs in parte se calculeaza pretul raportat la ce cantitate exista in cos
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><img src="<?php echo $item["image"]; ?>" class="cart-item-image" /><?php echo $item["name"]; ?></td>
				<td><?php echo $item["code"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ".$item["price"]; ?></td>
				<td  style="text-align:right;"><?php echo "$ ". number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="home.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="delete.jpg" alt="Remove Item" /></a></td>
				</tr>
				<?php
				//totalul cantitatilor se modifica
				$total_quantity += $item["quantity"];
				//pretul creste sau scade in raport cu modificarile cantitatilor
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong><?php echo "$ ".number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>
  <?php
} else {
?>
<div class="no-records">Cosul este gol</div>
<?php
}
?>
</div>

<div id="product-grid">
	<div class="txt-heading">Produse</div>
	<?php
	//afisarea produselor din baza de date in functie de id
	$product_array = $db_handle->runQuery("SELECT * FROM tblproduct ORDER BY id ASC");
	//daca exista produse in magazin
	if (!empty($product_array)) {
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="post" action="home.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
			<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
			<div class="product-tile-footer">
			<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
			<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
			<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Adauga-ma in cos" class="btnAddAction" /></div>
			</div>
			</form>
		</div>
	<?php
		}
	}
	?>
</div>
</BODY>
</HTML>
