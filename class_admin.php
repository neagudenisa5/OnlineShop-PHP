<?php include "Conection.php";
class Admin{
public $db;
public function __construct(){
    //aici se face conexiunea la baza noastra de date
    $this->db = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    //mysqli_connect_errno - Returnează codul de eroare de la ultimul apel de conectare
    if(mysqli_connect_errno()) {
        echo "Error: Nu se poate conecta la bd.";
        //daca a ajuns aici inseamna ca s-a facut conectarea cu succes
        exit;
    }
}
//aici se face inregistrarea
public function reg_user($username,$password,$fullname,$email){
    //se cripteaza parola
    $password = md5($password);
    //interogarea selecteaza toti adminii din baza de date unde apare uname sau uemail
    $sql="SELECT * FROM admini WHERE aname='$username' OR aemail='$email'";
    //verific daca username or email sunt in baza de date
    $check = $this->db->query($sql) ;
    //numara de cate ori a aparut uname sau uemail in baza de date
    $count_row = $check->num_rows;
    //daca username nu este in baza de date
    if ($count_row == 0){
        //insereaza un nou user cu datele tastate in form
        $sql1="INSERT INTO admini SET
        aname='$username', apass='$password', fullname='$fullname', aemail='$email'";
        //daca nu au fost introduse valori valide nu se poate face inregistrarea
        $result = mysqli_query($this->db,$sql1) or
                    die(mysqli_connect_errno()."Nu pot insera");
        return $result;
        }
    else {
        return false;
    }
}
//aici se face login
public function check_login($emailusername, $password){
    //criptarea parolei
    $password = md5($password);
    //se cauta in baza de date daca exista inregistrare care sa contina numele sau mailul tastat
    $sql2="SELECT aid from admini WHERE
    aemail='$emailusername' or aname='$emailusername' and apass='$password'";
    //verific daca username exista
    $result = mysqli_query($this->db,$sql2);
    //mysqli_fetch_array () este utilizată pentru a prelua rânduri din baza de date și a le stoca ca o matrice.
    $user_data = mysqli_fetch_array($result);
    //se numara randurile matricei resultate
    $count_row = $result->num_rows;
    //daca este doar un rand se poate face login
    if ($count_row == 1) {
    // folosesc sesiune
        $_SESSION['login'] = true;
        $_SESSION['aid'] = $user_data['aid'];
        return true;
    }
    else{
        return false;
    }
 }
  //aici se afiseaza fullname
 public function get_fullname($aid){
 $sql3="SELECT fullname FROM admini WHERE aid = $aid";
 $result = mysqli_query($this->db,$sql3);
 $user_data = mysqli_fetch_array($result);
 echo $user_data['fullname'];
 }
 //aici porneste sesiunea
 public function get_session(){
    return $_SESSION['login'];
 }
 public function user_logout() {
    $_SESSION['login'] = FALSE;
    // se distruge sesiunea
    session_destroy();
    }
}
?>
