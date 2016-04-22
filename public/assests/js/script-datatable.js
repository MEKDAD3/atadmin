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
						operation = "find_driver";
						s = string;
					}
				else  {
					operation = "getAllchauffeur";
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
						//alert(Driversdata);
						if(grid != null) grid.destroy(true, true);
						grid = $("#grid").grid({
						dataSource: Driversdata,
						responsive: true,
						columns: [
						  { field: "id" ,width: 0},
						  { field: "numero", title: "Num\xE9ro" },
						  { field: "nom", title: "Nom" },
						  { field: "prenom" , title: "Pr\xE9nom" },
						  { field: "num1" , title: "Num\xE9ro de T\xE9l\xE9phone (1)" },
						  { field: "num2", title: "Num\xE9ro de T\xE9l\xE9phone (2)" },
						  { field: "numTaxi" , title: "Num\xE9ro Taxi" },
						  { field: "matTaxi" , title: "Matricule Taxi" },
						  { field: "marTaxi", title: "Marque Taxi" },
						  { field: "password", title: "Mot de pass" },
						  { title: "", width: 20, type: "icon", icon: "ui-icon-pencil", tooltip: "Modifier", events: { "click": Edit } },
						  { title: "", width: 20, type: "icon", icon: "ui-icon-close", tooltip: "Supprimer", events: { "click": Delete } }
							]
							});
					   },

					   error : function(resultat, statut, erreur){
					   },

					   complete : function(resultat, statut){
							isDone = true;
					   }
				});
		}
	}
            
	getData("");
    dialog = $("#dialog").dialog({
        title: "Ajouter Ou Modifier un Chauffeur",
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
        $("#numero").val(e.data.record.numero);
        $("#nom").val(e.data.record.nom);
        $("#prenom").val(e.data.record.prenom);
    $("#num1").val(e.data.record.num1);
    $("#num2").val(e.data.record.num2);
    $("#numTaxi").val(e.data.record.numTaxi);
    $("#matTaxi").val(e.data.record.matTaxi);
    $("#marTaxi").val(e.data.record.marTaxi);
    $("#password").val(e.data.record.password);
        $("#dialog").dialog("open");
    }
    function Delete(e) {
        if (confirm(" Êtes-vous sûr ?"+e.data.record.id)) {
        $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=deleteDriver&id='+e.data.record.id+'&user_name='+user_name+'&Apassword='+password+'&type=admin',
               success : function(data, statut){
               },
               error : function(resultat, statut, erreur){
               console.log(erreur);
               },
               complete : function(resultat, statut){
               }
        });
            grid.removeRow(e.data.id);
        }
    }
    function Save() {
        if ($("#id").val()) {
            var id = parseInt($("#id").val());
      $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=modifyDriver&numero='+$("#numero").val()+'&nom='+$("#nom").val()+'&prenom='+$("#prenom").val()+'&num1='+$("#num1").val()+'&num2='+$("#num2").val()+'&numTaxi='+$("#numTaxi").val()+'&matTaxi='+$("#matTaxi").val()+'&marTaxi='+$("#marTaxi").val()+'&password='+$("#password").val()+'&id='+id+'&user_name='+user_name+'&Apassword='+password+'&type=admin',
               success : function(data, statut){
                          grid.updateRow(RowIndex, {"id": id,"numero": $("#numero").val(), "nom": $("#nom").val(), "prenom": $("#prenom").val(), "num1": $("#num1").val(), "num2": $("#num2").val(), "numTaxi": $("#numTaxi").val(), "matTaxi": $("#matTaxi").val(), "marTaxi": $("#marTaxi").val(), "password": $("#password").val() });
                    RowIndex = null;
               },
               error : function(resultat, statut, erreur){
               console.log(erreur);
               },
               complete : function(resultat, statut){
               }
            });
    } else {
          $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=addDriver&numero='+$("#numero").val()+'&nom='+$("#nom").val()+'&prenom='+$("#prenom").val()+'&num1='+$("#num1").val()+'&num2='+$("#num2").val()+'&numTaxi='+$("#numTaxi").val()+'&matTaxi='+$("#matTaxi").val()+'&marTaxi='+$("#marTaxi").val()+'&password='+$("#password").val()+'&user_name='+user_name+'&Apassword='+password+'&type=admin',
               dataType : "text",
               success : function(data, statut){
                  grid.addRow({ "id": parseInt(data),"numero": $("#numero").val(), "nom": $("#nom").val(), "prenom": $("#prenom").val(), "num1": $("#num1").val(), "num2": $("#num2").val(), "numTaxi": $("#numTaxi").val(), "matTaxi": $("#matTaxi").val(), "marTaxi": $("#marTaxi").val(), "password": $("#password").val() });
               },
               error : function(resultat, statut, erreur){
               console.log(erreur);
               },
               complete : function(resultat, statut){
               }
            });
        }
        $(this).dialog("close");
    }
    
    $("#btnAdd").on("click", function () {
    $("#id").val("");
        $("#numero").val("");
        $("#nom").val("");
        $("#prenom").val("");
    $("#num1").val("");
    $("#num2").val("");
    $("#numTaxi").val("");
    $("#matTaxi").val("");
    $("#marTaxi").val("");
    $("#password").val("");
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