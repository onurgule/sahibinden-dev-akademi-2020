<?php
header('Content-Type: text/html; charset=utf-8');
try {
     $db = new PDO("mysql:host=localhost;dbname=onurguletr_devdb", "onurguletr_devuser", "t^%&Tog%Qr7d");
	 $db->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
} catch ( PDOException $e ){
     print $e->getMessage();
}
?>