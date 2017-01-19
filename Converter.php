<?php
include "koneksi/koneksi.php";
function anti_injection($data){
	$filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
}

$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

$login  = mysql_query("SELECT * FROM tuser WHERE username = '$username' AND password = '$pass'");
$ketemu = mysql_num_rows($login);
$r		= mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
	session_start();
	
	$_SESSION[id_user]		= $r[id_user];
	$_SESSION[username]     = $r[username];
	$_SESSION[nama_lengkap] = $r[nama_lengkap];
	$_SESSION[passwordd]	= $r[password];
	
	$date = date('Y-m-d H:i:s');
	mysql_query("UPDATE tuser SET last_login = '$date' WHERE id_user = '$r[id_user]'");
	header('location:adminweb/asfa.php?module=home');
}
else{
	echo "<link href=css/login.css rel=stylesheet type=text/css>";
	echo "<center>LOGIN GAGAL! <br> 
			Username atau Password Anda tidak benar.<br>
			Atau account Anda sedang diblokir.<br>";
			echo "<a href=index.php><b>ULANGI LAGI</b></a></center>";
}
?>
