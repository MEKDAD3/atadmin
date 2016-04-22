jQuery(function($)  {
	var user_name = $.cookie("user_name");
    var password = $.cookie("password");
	
	$("#done").click(function() {
		$.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=updateUser&user_name='+user_name+'&Apassword='+password+'&type=admin&nom='+$("#txt_nom").val()+'&prenom='+$("#txt_prenom").val()+'&newUsername='+$("#txt_user_name").val()+'&password='+$("#txt_pass").val(),
               dataType : 'text',
               success : function(data, statut){
				   alert("okk");
				   $.cookie("user_name",$("#txt_user_name").val());
                   $.cookie("password",$("#txt_pass").val());				
			   },

               error : function(resultat, statut, erreur){
				   alert(erreur);
               },

               complete : function(resultat, statut){

               }

        });
	});
});