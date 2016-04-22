$(document).ready(function () {
	var date_regex = /^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/;
	var user_name,password;
	var cdata;
	var lastcount = 0;
	$("#search_btn").click( function() {
		if(date_regex.test($("#datepck").val())) {
			user_name = $.cookie("user_name");
			password = $.cookie("password");
			cdata = [];
			$.ajax({
					   url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
					   type : 'POST',
					   data : 'operation=getCoursesParDate&user_name='+user_name+'&Apassword='+password+'&type=admin&date='+$("#datepck").val()+'&day='+$("#s_depart").val()+'&night='+$("#s_fini").val(),
					   dataType : 'json',
					   success : function(data, statut){
						  $.each(data["data"], function(idx, obj) {
						  cdata.push(obj);
							});
						if(lastcount>0)
							$('#courses').columns('destroy');	
						$('#courses').columns({
										data:cdata, 
									}); 
						lastcount= cdata.length;
						},

					   error : function(resultat, statut, erreur){
					   },

					   complete : function(resultat, statut){

					   }
				});
		}
	});
});