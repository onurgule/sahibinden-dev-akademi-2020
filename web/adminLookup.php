<?php
if(isset($_GET['token']))
{
	setcookie('token', $_GET['token']);
}
include "sections/header.php";
echo $_COOKIE['sToken'];
if(isset($_POST["id"]) && isset($_POST["pw"])){

$params = array( 
    "username" => $_POST["id"], 
    "password" => $_POST["pw"]
);
print_r(json_encode($params));
 $postData = json_encode($params);
$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL,"https://devakademi.sahibinden.com/api/authorization/token"); 
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch,CURLOPT_HEADER, false); 
curl_setopt($ch, CURLOPT_POST, count($postData));
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 

$output=curl_exec($ch); 

curl_close($ch); 
$msg = json_decode($output);
if($msg->status == 'Valid'){
	$cookieok = setcookie('token', $msg->token, '/'); 
	echo '<script>document.location.href += "&token='.$msg->token.'&co='.$cookieok.'";</script>';
	}
else{
	echo "<h2>Girişte bir problem oluştu.</h2>";
} 

} 	
else if(!isset($_GET["token"]) && !isset($_COOKIE["token"])){
	?>
	<link rel="stylesheet" href="assets/css/login.css"/>
	<div class="wrapper fadeInDown">
  <div id="formContent">
    <div class="fadeIn first">
      <img src="https://devakademi.sahibinden.com/assets/images/dev_akademi_logo@2x.png" id="icon" alt="User Icon" />
    </div>
    <form method="POST">
      <input type="text" id="login" class="fadeIn second" name="id" placeholder="Kullanıcı Adı">
      <input type="password" id="password" class="fadeIn third" name="pw" placeholder="Şifre">
      <input type="hidden" name="adminID" value="<?=$_GET['adminID']?>"/>
	  <input type="submit" class="fadeIn fourth" value="Giriş">
    </form>
    <div id="formFooter">
      <p>Admin verilerini görmek için giriş yapmalısınız!</p>
    </div>

  </div>
</div>
	
	<?	
	return;
}
?>
<div>
<h2><?=$_GET["adminID"]?> ID'li Admin'in incelediği son ilanlar</h2>
<div class="row text-center">
		<div class="table-responsive">
				<table class="table" style="color: yellow">
				<thead>
				<tr>
				<th scope="col">İlan ID</th>
				<th scope="col">Tarih</th>
				<th scope="col">Reddeden</th>
				</tr>
				</thead>
				<tbody>
				<?php
				include "config/db.php";
				$adminID = $_GET["adminID"];
				include("api/v1/adminListings.php");
				
				foreach($lastAdminListings as $ilan){

					?>
					<tr>
					<?
					echo "<td><a href='ilan.php?q=".$ilan['id']."'>".$ilan['id']."</a></td>";

					echo "<td>". date("Y-m-d H:i:s", substr($ilan['date'], 0, 10))."</td>";
					echo "<td>".$ilan['adminID']."</td>";
				?>
				</tr>
				<?}?>
				
			</tbody>
			</table>
			</div>
		
		
	</div>
</div>
