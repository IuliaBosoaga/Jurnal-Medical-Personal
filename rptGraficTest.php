<?php 
session_start();
//include('head.php'); 
error_reporting(E_ALL);
?>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
BODY {
    width: 550PX;
}

#chart-container {
    width: 100%;
    height: auto;
}
</style>

<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- <script type="text/javascript" src="js/Chart.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

<!-- plugin datalabel necesita charts minim 2.7 -->

</head>




<body>
<h1>Grafic de test in PHP</h1>
    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>

        $(document).ready(function () {
			
		   showGraph();
        });


        function showGraph()
        {
            
                $.post("rptGraficTestDate.php",
                function (data)
                {
                    console.log(data);
					//alert(data);
                     var name = [];
                    var marks = [];

                    for (var i in data) {
                        name.push(data[i].student_name);
                        marks.push(data[i].marks);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
							  label: 'Linie medie',
							  backgroundColor: 'transparent',
							  borderColor: 'red',
							 
							  data: [50, 50, 50, 50,50],
							  // Changes this dataset to become a line
							  type: 'line',
							  datalabels: {
									anchor: 'end',
									align: 'top',
									display: false
								}
							},
							{
                                label: 'ConsumTotal',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
								//data se poate obtine ca vector prin sir generat din php inclus in js sau din vector js obtinut din apel ajx php post cu returnare tip fisier json
								// data: [22, 35, 69, 74,90],
                                data: marks,
								datalabels: {
									anchor: 'end',
									align: 'top',
								}
                            }
							 
							
						]
											
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata,
						options: {
							tooltips: {
								enabled: true
							},
							hover: {
								animationDuration: 0
							},
							legend: {
								display: true
							},
							title: {
								display: true,
								text: 'titlu',
								position: 'top',
								fontSize: 16,
								padding: 20
							},
							/*
							scales: {
								yAxes: [{
									ticks: {
										min: 75
									}
								}]
							},
							*/
							plugins: {
								datalabels: {
									color: '#000',
									display: function(context) {
										return context.dataset.data[context.dataIndex] > 15;
									},
									font: {
										weight: 'bold'
									},
									formatter: Math.round
								}
							}
							
							
						}
						
                    });
                });
            
        }
        </script>

</body>
</html>