<?php 
session_start();
include('../config.php'); 
error_reporting(E_ALL);
?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
BODY {
    width: 90%;
}

#chart-container {
    width: 100%;
    height: auto;
}
</style>


<script type="text/javascript" src="../js/jquery.min.js"></script>
<!--
<script   src="https://code.jquery.com/jquery-3.4.0.min.js"   integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="   crossorigin="anonymous"></script>
-->

<!-- <script type="text/javascript" src="js/Chart.min.js"></script> -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

<!-- plugin datalabel necesita charts minim 2.7 -->

</head>


<script type="text/javascript">		
function printpage() {

    //Get the print button and put it into a variable
    var printButton = document.getElementById("printpagebutton");
   //var btninchidere = document.getElementById("btninchidere");
   // var reenterButton = document.getElementById("reenterthenews");

    //Set the button visibility to 'hidden' 
    printButton.style.visibility = 'hidden';
   // btninchidere.style.visibility = 'hidden';
    //reenterButton.style.visibility = 'hidden';

    //Print the page content
    window.print()

    //Restore button visibility
    printButton.style.visibility = 'visible';
   // btninchidere.style.visibility = 'visible';
   // reenterButton.style.visibility = 'visible';

}
</script>
<input style= "position:fixed;left:0;top:0;" id="printpagebutton" type="button" value="Print" onclick="printpage()"/>


<?php
 if(!isset($_SESSION['buletine_IDA']) )
	 {
		 
		echo "<br><br><h1 style='color:red;'>Filtrați mai întâi pe o analiză!</h1>";
		exit();
	 }
?>

<body>











<?php
//extrag perioada salvata de butonul filtrare in tabelul tblperioada
$sirp="SELECT * from tblperioada "; 
$rsp=mysqli_query($link,$sirp) ;
$rowp = mysqli_fetch_assoc($rsp) ;

$DataI =  date('d.m.Y', strtotime(str_replace('/', '-', $rowp['DataI'])));
$DataF =  date('d.m.Y', strtotime(str_replace('/', '-', $rowp['DataF'])));


$sira="SELECT * from nom_analize where IDA=" . $_SESSION['buletine_IDA'] . ""; 
$rsa=mysqli_query($link,$sira) ;
$rowa = mysqli_fetch_assoc($rsa) ;



$sqluser="select   Concat(nume, ' ', prenume) as NumePrenume , cnp, if(left(cnp,1) =1 or left(cnp,1) =5 , 'Masculin', 'Feminin') as Sex 
		from cfg_useri 
		where id_user= " .  $_SESSION['SESS_ID_USER'];
///echo	$sqluser;	
$rsuser=mysqli_query($link,$sqluser) ;
$rowuser = mysqli_fetch_assoc($rsuser) ;
			
			
			
?>
<h2><span style="color:blue">Perioada : </span><?php echo $DataI;?> - <?php echo $DataF;?>
<br>
<?php echo $rowuser['NumePrenume'];?><br>
Sex: <?php echo $rowuser['Sex'];?> <br><br>
 <span style="color:blue">Analiza : </span> <?php echo $rowa['DenumireA']; ?> 
</h2>
    <div id="chart-container">
	
	
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>

        $(document).ready(function () {
			//alert("jq ok");
		   showGraph();
        });

		   function showGraph()
        {
              $.post("rptGraficDate.php",  function (data)
                {
                    //alert(data);
					//alert(data);
                    var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].DataRecoltare);
                        marks.push(data[i].Rezultat);
                    }

                    var chartdata = {
                        labels: name,
						
						
                        datasets: [
							
							
								{
                                label: 'Rezultat',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
								//data se poate obtine ca vector prin sir generat din php inclus in js sau din vector js obtinut din apel ajx php post cu returnare tip fisier json
								// data: [22, 35, 69, 74,90],
                                data: marks,
								backgroundColor: 'transparent',
								type: 'line',
								datalabels: {
									anchor: 'end',
									align: 'top',
									display: true
								}
                            }
							
							 
							
						]
											
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
						options: {
							scaleShowValues: true,
							tooltips: {
								enabled: true
							},
							hover: {
								animationDuration: 0
							},
							legend: {
								display: true,
								position: 'right'
							},
							title: {
								display: true,
								text: 'Evoluție rezultate analiză pe date de recoltare ',
								position: 'top',
								fontSize: 24,
								padding: 60
							},
							
							scales: {
								yAxes: [{
									ticks: {
										min: 0
									}
								}]
								,
								xAxes: [{
								  ticks: {
									autoSkip: false
								  }
								}]
							},
							
							plugins: {
								datalabels: {
									color: '#000',
									display: function(context) {
										return context.dataset.data[context.dataIndex] > 15;
									},
									font: {
										weight: 'bold'
									},
									formatter: Math.round(2)
								}
							}
							
							
						}
						
                    });
                });
            
        }
		
		
        </script>

</body>
</html>