<?php
if ($_GET['action'] == 'Şanslı Hissediyorum') {
    header('Location: kelime.php?word='.$_GET['q']);
}
include 'sections/header.php';
?>

		<div class="row text-center">
		<div class="table-responsive">

       
			<?php
				$word = $_GET["q"];
				if(strlen($word) < 3)
				{
					echo "<h3 style='color:yellow;'>3 harf ve üstü kelime arayabilirsiniz!</h3>";
					return;
				}
				$ch = curl_init(); 
				curl_setopt($ch,CURLOPT_URL,$python_endpoint_ip."/autocomplete?word=".$word); 
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
			 // curl_setopt($ch,CURLOPT_HEADER, false); 
				
				$output=curl_exec($ch); 
				curl_close($ch); 
				$js_kelimeler = json_decode($output);
				$kelimeler = $js_kelimeler->matching_results;
				?>
				<div class="table-responsive">
				<table class="table" style="color: yellow">
				<thead>
				<tr>
				<th scope="col">Kelime</th>
				<th scope="col">#</th>
				</tr>
				</thead>
				<tbody>
				<?
				foreach($kelimeler as $kelime){
					?>
					<tr>
					<?
					echo "<td>".$kelime."</td>";
					echo "<td><a href='kelime.php?word=".$kelime."'>İncele</a></td>";;
				?>
				</tr>
				<?}?>
				
			</tbody>
			</table>
			</div>
			
		</div>
		
		
	</div>
	</div>
