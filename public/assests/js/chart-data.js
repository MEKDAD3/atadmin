  var randomScalingFactor = function(){ return Math.round(Math.random()*1000)};
  var user_name,password;
  user_name = $.cookie("user_name");
  password = $.cookie("password");
  //metadata = new Array();
  days = [];
  counts = [];
  days_a = [];
  counts_a = [];
  months = [];
  counts_months_con =[];
  counts_months_ann =[];
	 $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=getCoursesParJour&user_name='+user_name+'&Apassword='+password+'&type=admin&etat=2',
               dataType : 'json',
               success : function(data, statut){
				   var arr =  $.map(data, function(el) { return el });
				   arr.sort();
				   //arr.reverse();
				   console.log(arr);
				   var mydays = [];
				   var mycounts = [];
				   var a = new Date().getDay();
				   console.log(a);
					for(var i=a ; i>=0 ; i--) {
						console.log(arr[i].day);
						mydays.push(arr[i].day);
						mycounts.push(arr[i].count);
					}
					for(var i=6 ; i>a ; i--) {
						mydays.push(arr[i].day);
						mycounts.push(arr[i].count);
					}
					for	(index = 0; index < mydays.length; index++) {
						switch(parseInt(mydays[index])) {
							case 0:
								days.push("Dimanche");
								counts.push(mycounts[index]);
								break;
							case 1:
								days.push("Lundi");
								counts.push(mycounts[index]);
						        break;
							case 2:
								days.push("Mardi");
								counts.push(mycounts[index]);
								break;
							case 3:
								days.push("Mercredi");
								counts.push(mycounts[index]);
								break;
							case 4:
								days.push("Jeudi");
								counts.push(mycounts[index]);
								break;
							case 5:
								days.push("Vendredi");
								counts.push(mycounts[index]);
								break;
							case 6:
								days.push("Samedi");
								counts.push(mycounts[index]);
								break;
						}
					}
                
				getannuler();
				console.log(days);
				console.log(counts);
               },

               error : function(resultat, statut, erreur){
               },

               complete : function(resultat, statut){
               }
        });
		//console.log(days[0]);
	var lineChartData,barChartData,pieData,doughnutData;

	function getannuler() {
		$.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=getCoursesParJour&user_name='+user_name+'&Apassword='+password+'&type=admin&etat=3',
               dataType : 'json',
               success : function(data, statut){
				  var arr =  $.map(data, function(el) { return el });
				   arr.sort();
				   //arr.reverse();
				   console.log(arr);
				   var mydays = [];
				   var mycounts = [];
				   var a = new Date().getDay();
					for(var i=a ; i>=0 ; i--) {
						mydays.push(arr[i].day);
						mycounts.push(arr[i].count);
					}
					for(var i=6 ; i>a ; i--) {
						mydays.push(arr[i].day);
						mycounts.push(arr[i].count);
					}
					for	(index = 0; index < mydays.length; index++) {
						switch(parseInt(mydays[index])) {
							case 0:
								days_a.push("Dimanche");
								counts_a.push(mycounts[index]);
								break;
							case 1:
								days_a.push("Lundi");
								counts_a.push(mycounts[index]);
						        break;
							case 2:
								days_a.push("Mardi");
								counts_a.push(mycounts[index]);
								break;
							case 3:
								days_a.push("Mercredi");
								counts_a.push(mycounts[index]);
								break;
							case 4:
								days_a.push("Jeudi");
								counts_a.push(mycounts[index]);
								break;
							case 5:
								days_a.push("Vendredi");
								counts_a.push(mycounts[index]);
								break;
							case 6:
								days_a.push("Samedi");
								counts_a.push(mycounts[index]);
								break;
						}
					}
				getparmois_con();
				//console.log(days_a);
				//console.log(counts_a); 
               },

               error : function(resultat, statut, erreur){
               },

               complete : function(resultat, statut){
               }
        });
	}
	function getparmois_con() {
		$.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=getCoursesParMois&user_name='+user_name+'&Apassword='+password+'&type=admin&etat=2',
               dataType : 'json',
               success : function(data, statut){
				  var arr =  $.map(data, function(el) { return el });
				   arr.sort();
				   //arr.reverse();
				   console.log(arr);
				   for	(index = 0; index < arr.length; index++) {
								months.push(arr[index].month);
								counts_months_con.push(arr[index].count);
					}
				getparmois_ann();
				console.log(months);
				console.log(counts_months_con); 
               },

               error : function(resultat, statut, erreur){
				   console.log(erreur);
               },

               complete : function(resultat, statut){
               }
        });
	}
	function getparmois_ann() {
		$.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=getCoursesParMois&user_name='+user_name+'&Apassword='+password+'&type=admin&etat=3',
               dataType : 'json',
               success : function(data, statut){
				  var arr =  $.map(data, function(el) { return el });
				   arr.sort();
				   //arr.reverse();
				   console.log(arr);
				   for	(index = 0; index < arr.length; index++) {
								counts_months_ann.push(arr[index].count);
					}
				okGoAhead();
				//console.log(days_a);
				console.log(counts_months_ann); 
               },

               error : function(resultat, statut, erreur){
				   console.log(erreur);
               },

               complete : function(resultat, statut){
               }
        });
	}
	function okGoAhead() {
		lineChartData = {
			labels : days.reverse(),
			datasets : [
				{
					label: "Confimé",
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 1)",
					pointColor : "rgba(48, 164, 255, 1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(48, 164, 255, 1)",
					data : counts.reverse()
				},
				{
					labels : days_a.reverse(), 
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : counts_a.reverse()
				}
			]

		}
		
	 barChartData = {
			labels : months,
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,0.8)",
					highlightFill: "rgba(220,220,220,0.75)",
					highlightStroke: "rgba(220,220,220,1)",
					data : counts_months_con
				},
				{
					fillColor : "rgba(48, 164, 255, 0.2)",
					strokeColor : "rgba(48, 164, 255, 0.8)",
					highlightFill : "rgba(48, 164, 255, 0.75)",
					highlightStroke : "rgba(48, 164, 255, 1)",
					data : counts_months_ann
				}
			]
	
		}

	/*pieData = [
				{
					value: 300,
					color:"#30a5ff",
					highlight: "#62b9fb",
					label: "Blue"
				},
				{
					value: 50,
					color: "#ffb53e",
					highlight: "#fac878",
					label: "Orange"
				},
				{
					value: 100,
					color: "#1ebfae",
					highlight: "#3cdfce",
					label: "Teal"
				},
				{
					value: 120,
					color: "#f9243f",
					highlight: "#f6495f",
					label: "Red"
				}

			];
			
	doughnutData = [
					{
						value: 300,
						color:"#30a5ff",
						highlight: "#62b9fb",
						label: "Blue"
					},
					{
						value: 50,
						color: "#ffb53e",
						highlight: "#fac878",
						label: "Orange"
					},
					{
						value: 100,
						color: "#1ebfae",
						highlight: "#3cdfce",
						label: "Teal"
					},
					{
						value: 120,
						color: "#f9243f",
						highlight: "#f6495f",
						label: "Red"
					}
	
				];*/
				var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
		responsive: true
	});
	var chart2 = document.getElementById("bar-chart").getContext("2d");
	window.myBar = new Chart(chart2).Bar(barChartData, {
		responsive : true
	});
	//var chart3 = document.getElementById("doughnut-chart").getContext("2d");
	//window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {responsive : true
	//});
	//var chart4 = document.getElementById("pie-chart").getContext("2d");
	//window.myPie = new Chart(chart4).Pie(pieData, {responsive : true
	//});
	}
