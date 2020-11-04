<?php include "sections/header.php"; ?>
		<div class="row google-form text-center">
			<form action="search.php" method="get">
				<div class="form-group">

      <input id="txtKelime" min="3" placeholder="Herhangi bir kelime yazabilirsiniz." type="text" class="form-control google-search" name="q">
      <div class="help-block">Aramak için min. 3 karakter</div>
	  <div class="btn-group">
  <input type="submit" name="action" value="Kelimeyi Ara" text="Kelimeyi Ara" class="btn btn-default"/>
  <input style="color:#fedd01; background-color:black;" type="submit" name="action" value="Şanslı Hissediyorum"  class="btn btn-default"/>
  
</div>
    </div>
			</form>
			
		</div>
		
		
	</div>
	</div>
	<div class="col-md-6 col-lg-6 col-sm-12">
	<h2>Son Listelemeler</h2>

				
				<div class="table-responsive">
				<table class="table" style="color: yellow">
				<thead>
				<tr>
				<th scope="col">İlan ID</th>
				<th scope="col">Tarih</th>
				<th scope="col">Onaylayan</th>
				</tr>
				</thead>
				<tbody>
				<?php
				include "config/db.php";
				include("api/v1/lastActives.php");
				foreach($lastActives as $ilan){

					?>
					<tr>
					<?
					echo "<td><a href='ilan.php?q=".$ilan['id']."'>".$ilan['id']."</a></td>";

					echo "<td>". date("Y-m-d H:i:s", substr($ilan['date'], 0, 10))."</td>";
					echo "<td><a href='adminLookup.php?adminID=".$ilan['adminID']."'>".$ilan['adminID']."</a></td>";
				?>
				</tr>
				<?}?>
				
			</tbody>
			</table>
			</div>
			</div>
		
	<div class="col-md-6 col-lg-6 col-sm-12">
	<h2>Son Onaylanmayanlar</h2>
	
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
				include("api/v1/lastRejects.php");
				foreach($lastRejects as $ilan){

					?>
					<tr>
					<?
					echo "<td><a href='ilan.php?q=".$ilan['id']."'>".$ilan['id']."</td>";

					echo "<td>". date("Y-m-d H:i:s", substr($ilan['date'], 0, 10))."</td>";
					echo "<td><a href='adminLookup.php?adminID=".$ilan['adminID']."'>".$ilan['adminID']."</a></td>";
				?>
				</tr>
				<?}?>
				
			</tbody>
			</table>
			</div>
	
	</div>
</div>

<script>
 /*$(document).ready(function () {
        $('#txtKelime').typeahead({
            source: function (query, result) {
				console.log(query);
                $.ajax({
                    url: "http://34.107.92.181:5000/autocomplete",
					data: 'word=' + query,            
                    dataType: "json",
                    type: "GET",
                    success: function (data) {
						result($.map(data, function (item) {
							return item;
                        }));
                    }
                });
            }
        });
    });*/
	/*$(function() {
		$( "#txtKelime" ).change(function() {
			if($( "#txtKelime" ).val().length < 3) return;
    $.ajax({
        url: 'http://34.107.92.181:5000/autocomplete',
		data: 'word=' + $('#txtKelime').val(),            
        dataType: "json",
        type: "GET", 
        }).done(function (data) {
			console.log(data);
            $('.autocomplete').autocomplete({
                source: data.json_list,
                minLength: 3
            });
        });
		
});
    });*/
</script>
</body>

</html>