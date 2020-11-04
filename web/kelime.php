<?php include "sections/header.php"; ?>
		<div class="row google-form text-center">
			<h2>"<?=$_GET['word']?>" Kelimesinin Detayları</h2>
			<hr>
			<?php
				$word = strtoupper($_GET["word"]);
				$ch = curl_init(); 
				curl_setopt($ch,CURLOPT_URL,$python_endpoint_ip."/search?word=".$word); 
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
				$output=curl_exec($ch); 
				curl_close($ch); 
				$word_statistics_js = json_decode($output);
				$word_statistics = $word_statistics_js->matching_results;
				$all = $word_statistics[0];
				if($all < 0 || $all == ""){
					echo "<b style='color:yellow;'>Bu kelime kullanılmamış!</b>";
					return;
				}
				$approved = $word_statistics[1];
				$rejected = $word_statistics[2];
				$ratio = 15; // Güvenilebilecek rakamlara ulaşıncaya kadar belirsiz.
				$approve_rate = $approved/$all;
				$kelime_durumu = "";
				if(($approve_rate < 0.7 && $approve_rate > 0.5) || $all <= $ratio) $kelime_durumu = "<b style='color:orange'>Kontrol Edilmeli!</b>";
				else if($approve_rate >= 0.7) $kelime_durumu = "<b style='color:green'>Güvenli!</b>"; 
				else $kelime_durumu = "<b style='color:red'>Güvensiz!</b>"
				
				
				?>
				<canvas id="pieChart"></canvas><br>
				
				<div style="text-align:center;color: yellow; padding-top:25px; padding-bottom:25px; ">
				<div class="card border-warning mb-3" style=" margin:0 auto;">
				  <div class="card-header">Kelime Durumu</div><hr>
				  <div class="card-body ">
					<h5 class="card-title">Bu Kelime <?=$kelime_durumu?></h5>
					<p class="card-text">Bu kelimenin geçtiği ilanlar <?=sprintf("%.1f%%", (1-$approve_rate)*100)?> oranında reddedilmiş!</p>
				  </div>
				</div>
				</div>
				<div style="display:block;">
				<div class="card text-white bg-primary mb-3">
				  <div class="card-header">Kelime Kullanımı</div>
				  <div class="card-body">
					<h5 class="card-title"><?=$all?> kez kullanıldı.</h5>
					<p class="card-text"><?=$word?> kelimesi başlık ve ayrıntılarda toplam <b><?=$all?></b> kez kullanıldı.</p>
				  </div>
				</div>
				<div class="card text-white bg-success mb-3">
				  <div class="card-header">Onaylanma Oranı</div>
				  <div class="card-body">
					<h5 class="card-title"><?=$approved?> kez onaylandı.</h5>
					<p class="card-text"><?=$word?> kelimesinin geçtiği ilanlar toplam <b><?=$approved?></b> kez onaylandı.</p>
				  </div>
				</div>
				<div class="card text-white bg-danger mb-3">
				  <div class="card-header">Reddedilme Oranı</div>
				  <div class="card-body">
					<h5 class="card-title"><?=$rejected?> kez onaylandı.</h5>
					<p class="card-text"><?=$word?> kelimesinin geçtiği ilanlar toplam <b><?=$rejected?></b> kez reddedildi.</p>
				  </div>
				</div>
				</div>
		
		
	</div>
	</div>
	<script src="assets/js/Chart.min.js"></script>
	<script>
	//pie
	$(document).ready(function(){
		
		
    var ctxP = document.getElementById("pieChart").getContext('2d');
    var myPieChart = new Chart(ctxP, {
      type: 'pie',
      data: {
        labels: ["Reddedilmiş","Onaylanmış"],
        datasets: [{
          data: [<?=$rejected?>, <?=$approved?>],
          backgroundColor: ["#F7464A", "#46BFBD"],
          hoverBackgroundColor: ["#FF5A5E", "#5AD3D1"]
        }]
      },
      options: {
        responsive: true,
        legend: {
          position: 'right',
          labels: {
            padding: 20,
            boxWidth: 10
          }
        },
        plugins: {
          datalabels: {
            formatter: (value, ctx) => {
              let sum = 0;
              let dataArr = ctx.chart.data.datasets[0].data;
              dataArr.map(data => {
                sum += data;
              });
              let percentage = (value * 100 / sum).toFixed(2) + "%";
              return percentage;
            },
            color: 'white',
            labels: {
              title: {
                font: {
                  size: '20'
                }
              }
            }
          }
        }
      }
    });
	});
	</script>
	