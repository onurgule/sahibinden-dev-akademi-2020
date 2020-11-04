<?php
if(!isset($_GET["q"])){
	header('Location: index.php');
}
include 'sections/header.php';
?>

		<div class="row text-center">
		<h2><?=$_GET["q"]?> ID'li İlan Özellikleri</h2>
		<div class="table-responsive">

       
			<?php
				$list_id = $_GET["q"];
				
				$ch = curl_init(); 
				curl_setopt($ch,CURLOPT_URL,"https://devakademi.sahibinden.com/api/classified/load?id=".$list_id); 
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
				$output=curl_exec($ch); 
				curl_close($ch); 
				$ilan_json = json_decode($output);
				?>
				<div class="table-responsive">
				<table id="myTable">
				<thead>
					<tr>
						<th style="color:yellow;">Özellik</th>
						<th style="color:yellow;">Değer</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			</div>
			<script>
			var json = <?=$output?>;
			$tbody = $('#myTable').find('tbody');
			for(var k in json) {
			if(k == 'adminID'){
				$tbody.append('<tr><td style="color:yellow;">'+k+'</td><td style="color:white;"><a href="adminLookup.php?adminID='+json[k]+'">'+json[k]+'</a></td></tr>');
				continue;
			}
			else if(k == 'categories'){
				let cats = '';
				for(var c in json[k]){
					if(json[k][c]['id'] == 0) break;
					cats+=json[k][c]['title'] + " > ";
				}
				$tbody.append('<tr><td style="color:yellow;">category</td><td style="color:white;">'+cats.slice(0,-3)+'</td></tr>');
				continue;
			}
			$tbody.append('<tr><td style="color:yellow;">'+k+'</td><td id="'+k+'" style="color:white;">'+json[k]+'</td></tr>');
}

			</script>
		</div>
		
		
	</div>
	</div>
	<script>
	$(document).ready(function(){
		 $.get("<?=$python_endpoint_ip?>/detectWords?content="+$('#title').text(), function(data, status){
			$('#title').html(data);
  });
  $.get("<?=$python_endpoint_ip?>/detectWords?content="+$('#description').text(), function(data, status){
			$('#description').html(data);
  });
	});
	
	</script>
