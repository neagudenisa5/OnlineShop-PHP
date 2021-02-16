<?php
//se defineste accesul la server, user, baza de date
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'tblproduct');

class DBController {
	private $host='localhost';
	private $user='root';
	private $password='';
	private $database='tblproduct';
	private $conn;

	//se deschide o noua conexiune la server
	function __construct() {
		$this->conn = $this->connectDB();
	}

	function connectDB() {
		//aici se face conexiunea propriu-zisa la baza de date
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		//$conn este variabila resursa a conexiunii la baza de date
		return $conn;
	}
//functia ruleaza interogarea transmisa ca parametru
	function runQuery($query) {
		//in variabila $result se stocheaza rezultatul interogarii
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			//$resultset[] va contine toate rezultatele interogarii
			$resultset[] = $row;
		}
		if(!empty($resultset))
		//daca matricea asociativa contine rezultate, acestea vor fi returnate aici
			return $resultset;
	}
	//functia numara cate randuri au fost returnate in urma rularii interogarii
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;
	}
}
?>
