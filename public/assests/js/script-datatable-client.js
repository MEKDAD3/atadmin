$(document).ready(function () {
    var Driversdata, grid, dialog,RowIndex;
  var user_name,password;
  var operation = "";
  var s = "";
  var filter = false;
  var isDone = true;
  user_name = $.cookie("user_name");
  password = $.cookie("password");
    Driversdata = new Array();
	function getData(string) {
		if(isDone) {
				Driversdata = [];
				if(filter) {
						operation = "find_client";
						s = string;
					}
				else  {
					operation = "getAllClients";
					s = string;
				}
				$.ajax({
				   url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
				   type : 'POST',
				   data : 'operation='+operation+'&user_name='+user_name+'&Apassword='+password+'&type=admin&s='+s,
				   dataType : 'json',
				   success : function(data, statut){
					  $.each(data["data"], function(idx, obj) {
					  Driversdata.push(obj);
					});
					if(grid != null) grid.destroy(true, true);
					grid = $("#grid").grid({
					dataSource: Driversdata,
					columns: [
					  { field: "id" ,width: 0},
					  { field: "nom", title: "Nom" },
					  { field: "prenom" , title: "Pr\xE9nom" },
					  { field: "num1" , title: "Num\xE9ro de T\xE9l\xE9phone (1)" },
					  { field: "num2", title: "Num\xE9ro de T\xE9l\xE9phone (2)" },
					  { field: "password" , title: "Mot de passe" },
					  { field: "email", title: "Email" },
					  { field: "sexe", title: "Sexe" },
					  { title: "", width: 20, type: "icon", icon: "ui-icon-pencil", tooltip: "Modifier", events: { "click": Edit } },
					  { title: "", width: 20, type: "icon", icon: "ui-icon-close", tooltip: "Supprimer", events: { "click": Delete } }
						]
						});
				   },

				   error : function(resultat, statut, erreur){
					   console.log(resultat);
				   },

				   complete : function(resultat, statut){
					   isDone = true;
				   }
			});
		}
	}
	
	getData("");
	
    dialog = $("#dialog").dialog({
        title: "Ajouter Ou Modifier un Client",
        autoOpen: false,
        resizable: false,
        modal: true,
		width: "480px",
        buttons: {
            "Sauvgarder": Save,
            "Annuler": function () { $(this).dialog("close"); }
        }
    }).prev(".ui-dialog-titlebar").css("background","#D3222A");
    function Edit(e) {
    //$("#id").css("display","none");
    RowIndex = $(this).closest("tr").index()+1;
    $("#id").val(e.data.record.id);
    $("#nom").val(e.data.record.nom);
    $("#prenom").val(e.data.record.prenom);
    $("#num1").val(e.data.record.num1);
    $("#num2").val(e.data.record.num2);
    $("#password").val(e.data.record.password);
    $("#email").val(e.data.record.email);
	if(e.data.record.sexe == "F")
		$("#f").prop("checked", true);
	else if(e.data.record.sexe == "M")
		$("#m").prop("checked", true);
    $("#dialog").dialog("open");
    }
    function Delete(e) {
        if (confirm(" Êtes-vous sûr ?"+e.data.record.id)) {
        $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=deleteClient&id='+e.data.record.id+'&user_name='+user_name+'&Apassword='+password+'&type=admin',
               success : function(data, statut){
				   alert("Client supprimé !!")
               },
               error : function(resultat, statut, erreur){
				   console.log(erreur);
               },
               complete : function(resultat, statut){
				   console.log(resultat);
               }
        });
            grid.removeRow(e.data.id);
        }
    }
    function Save() {
		var sexe_="";
			if(document.getElementById('m').checked) {
			  sexe_ = "M";
			}else if(document.getElementById('f').checked) {
			  sexe_ = "F";
			}
			
        if ($("#id").val()) {
            var id = parseInt($("#id").val());
			  $.ajax({
					   url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
					   type : 'POST',
					   data : 'operation=modifyClient&nom='+$("#nom").val()+'&prenom='+$("#prenom").val()+'&num1='+$("#num1").val()+'&num2='+$("#num2").val()+'&password='+$("#password").val()+'&email='+$("#email").val()+'&sexe='+sexe_+'&id='+id+'&user_name='+user_name+'&Apassword='+password+'&type=admin',
					   success : function(data, statut){
								  grid.updateRow(RowIndex, {"id": id,"nom": $("#nom").val(), "prenom": $("#prenom").val(), "num1": $("#num1").val(), "num2": $("#num2").val(), "password": $("#password").val(), "email": $("#email").val(),"sexe": sexe_});
								  RowIndex = null;
								  alert("Client modifié !!")
					   },
					   error : function(resultat, statut, erreur){
					   console.log(erreur);
					   },
					   complete : function(resultat, statut){
						   console.log(resultat);
					   }
					});
    } else {
          $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=addClient&nom='+$("#nom").val()+'&prenom='+$("#prenom").val()+'&num1='+$("#num1").val()+'&num2='+$("#num2").val()+'&password='+$("#password").val()+'&email='+$("#email").val()+'&sexe='+sexe_+'&user_name='+user_name+'&Apassword='+password+'&type=admin',
               dataType : "text",
               success : function(data, statut){
                  grid.addRow({ "id": parseInt(data),"nom": $("#nom").val(), "prenom": $("#prenom").val(), "num1": $("#num1").val(), "num2": $("#num2").val(), "password": $("#password").val(), "email": $("#email").val(),"sexe": sexe_});
				  alert("Client Ajouté !!");
			   },
               error : function(resultat, statut, erreur){
               console.log(erreur);
               },
               complete : function(resultat, statut){
				   console.log(resultat);
               }
            });
        }
        $(this).dialog("close");
    }
    
    $("#btnAdd").on("click", function () {
    $("#id").val("");
    $("#nom").val("");
    $("#prenom").val("");
    $("#num1").val("");
    $("#num2").val("");
    $("#password").val("");
    $("#email").val("");
    $("#dialog").dialog("open");
    });
	
	$('#btn_find').keyup(function () { 
			//alert($(this).val());
			if($(this).val()) {
				filter = true;
				getData($(this).val());
				isDone = false;
				//alert($(this).val());
			} else {
				filter = false;
				getData("");
			}
			//grid.reload({ searchString: $(this).val() });
	});
});