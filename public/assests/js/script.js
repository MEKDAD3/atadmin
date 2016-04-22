jQuery(function($)  {
       var map = new google.maps.Map(document.getElementById('map'), {
                      center: {lat: 34.694124, lng: -1.913236},
                      scrollwheel: true,
                      zoom: 13
                      });
       var markers = [];
	   var markersClients = [];
       var user_name = $.cookie("user_name");
       var password = $.cookie("password");
    function getLocations() {     
      $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=getchauffeurs&user_name='+user_name+'&Apassword='+password+'&type=admin',
               dataType : 'json',
               success : function(data, statut){
                        markers.forEach(function(entry) { // check if a marker exist in the map and not in result , so i will remove it from the map
									var trv = false;
									$.each(data["data"], function(idx, obj) {
										if(parseInt(entry.get("id")) == parseInt(obj.numero_chauffeur)) {
											trv = true;
											return;
										}
									});
									if(!trv) 
									{
										entry.setMap(null);
										markers.splice(markers.indexOf(entry),1);
									}
									trv = false;
								});
								
							    $.each(data["data"], function(idx, obj) {// check if a marker exist in the result and not in the map , so i will either add it or just change is position !!
									var trv = false;
									var marker;
									markers.forEach(function(entry) {
														if(parseInt(entry.get("id")) == parseInt(obj.numero_chauffeur)) {
															marker = entry;
															trv = true;
															return;}
													});
									if(trv) { //if the marker is exist ,we will just change his position !!
										if(parseInt(obj.statu) == 1) marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/taxi_dis.png"); 
											else marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/taxi_indisp.png");
										marker.setPosition(new google.maps.LatLng(obj.latitude, obj.longitude));
									}
									else { // if not we will add it to markers list !!
										    marker = new google.maps.Marker({
											position: new google.maps.LatLng(obj.latitude, obj.longitude),
											map: map,
										});
										if(parseInt(obj.statu) == 1) marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/taxi_dis.png"); 
											else marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/taxi_indisp.png");
										marker.set("id",obj.numero_chauffeur);
										markers.push(marker);
										var infowindow = new google.maps.InfoWindow({
										  content: obj.numero_chauffeur,
										  maxWidth: 160
										});
										infowindow.open(map, marker);
									}
									trv = false;	
								});
               },

               error : function(resultat, statut, erreur){
               },

               complete : function(resultat, statut){
               }

        });
    }
    
	
      setInterval(getLocations, 1500);
	  
	  
	  function getClientsLocations() {     
      $.ajax({
               url : window.location.protocol + "//" + window.location.host + "/"+'data/webservice_v2.php',
               type : 'POST',
               data : 'operation=getclientsAdmin&user_name='+user_name+'&Apassword='+password+'&type=admin',
               dataType : 'json',
               success : function(data, statut){
                        markersClients.forEach(function(entry) { // check if a marker exist in the map and not in result , so i will remove it from the map
									var trv = false;
									$.each(data["data"], function(idx, obj) {
										if(parseInt(entry.get("id")) == parseInt(obj.id)) {
											trv = true;
											return;
										}
									});
									if(!trv) 
									{
										entry.setMap(null);
										markersClients.splice(markersClients.indexOf(entry),1);
									}
									trv = false;
								});
								
							    $.each(data["data"], function(idx, obj) {// check if a marker exist in the result and not in the map , so i will either add it or just change is position !!
									var trv = false;
									var marker;
									markersClients.forEach(function(entry) {
														if(parseInt(entry.get("id")) == parseInt(obj.id)) {
															marker = entry;
															trv = true;
															return;}
													});
									if(trv) { //if the marker is exist ,we will just change his position !!
										if(obj.sexe == 'M') marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/markers_man.png"); 
											else marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/markers_women.png");
										marker.setPosition(new google.maps.LatLng(obj.latitude, obj.longitude));
									}
									else { // if not we will add it to markersClients list !!
										    marker = new google.maps.Marker({
											position: new google.maps.LatLng(obj.latitude, obj.longitude),
											map: map,
										});
										if(obj.sexe == 'M') marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/markers_man.png"); 
											else marker.setIcon(window.location.protocol + "//" + window.location.host +"/images/markers_women.png");
										marker.set("id",obj.id);
										markersClients.push(marker);
										var infowindow = new google.maps.InfoWindow({
										  content: obj.name,
										  maxWidth: 160
										});
										infowindow.open(map, marker);
									}
									trv = false;	
								});
               },

               error : function(resultat, statut, erreur){
               },

               complete : function(resultat, statut){
               }

        });
    }
	setInterval(getClientsLocations, 3000);
	
	var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	map.addListener('bounds_changed', function() {
		searchBox.setBounds(map.getBounds());
	});
	
	  var markers_ = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
    searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Clear out the old markers_.
    markers_.forEach(function(marker) {
      marker.setMap(null);
    });
    markers_ = [];
	
	var infos = [];
	var lastcount = 0;
    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers_.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);

	markers.forEach(function(entry) { 
		var p1 = new google.maps.LatLng(entry.position.lat(), entry.position.lng());
		var p2 = new google.maps.LatLng(searchBox.getPlaces()[0].geometry.location.lat(), searchBox.getPlaces()[0].geometry.location.lng());

		var _status = "";
		if(entry.icon.substring(entry.icon.lastIndexOf('/')+1,entry.icon.lastIndexOf('.')) == "taxi_dis")
			_status = "Libre"
		else _status = "Occupé"
		
		var object = {
			Code:entry.get("id"),
			Distance:(google.maps.geometry.spherical.computeDistanceBetween(p1, p2)/ 1000).toFixed(2)+" KM",
			Status : _status
		};
		infos.push(object);
		//$(".modal-body").append("<p><span class='bold'>Code </span><span class='driverCode'> "+entry.get("id")+" </span> : <span class='distance'> "+(google.maps.geometry.spherical.computeDistanceBetween(p1, p2)/ 1000).toFixed(2)+" </span>  KM</p>");
	});
	$("#modal-container").html('<div id="myModal" class="modal fade" role="dialog"> <div class="modal-dialog"><!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Les Taxi plus proche de ce Quartier</h4> </div> <div class="modal-body"><div id="infos"></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button></div></div></div></div>')
	$('#infos').columns({
				data:infos, 
				}); 
	$('#myModal').modal('toggle');
	infos = [];
  });
  
  $("#pac-input").keyup(function () { 
			if(!$(this).val()) {
				 markers_.forEach(function(marker) {
				  marker.setMap(null);
				});
				markers_ = [];
			}else  {
				// get address compare it with the adresse wet get from web service;
				
			}
	});
	//$('#myModal_full').modal('toggle');
	$("#full-screen-btn").click(function() {
		
	});
	
	
	
	/**/
	
	google.maps.event.addListener(map, "rightclick", function(event) {
		var lat = event.latLng.lat();
		var lng = event.latLng.lng();
		getClosetDriverByLanLon(lat,lng);
		// populate yor box/field with lat, lng
	});
		
		function getClosetDriverByLanLon(lat,lng) {
				var infos = [];
				markers.forEach(function(entry) { 
					var p1 = new google.maps.LatLng(entry.position.lat(), entry.position.lng());
					var p2 = new google.maps.LatLng(lat, lng);

					var _status = "";
					if(entry.icon.substring(entry.icon.lastIndexOf('/')+1,entry.icon.lastIndexOf('.')) == "taxi_dis")
						_status = "Libre"
					else _status = "Occupé"
					
					var object = {
						Code:entry.get("id"),
						Distance:(google.maps.geometry.spherical.computeDistanceBetween(p1, p2)/ 1000).toFixed(2)+" KM",
						Status : _status
					};
					infos.push(object);
				});
			$("#modal-container").html('<div id="myModal" class="modal fade" role="dialog"> <div class="modal-dialog"><!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Les Taxi plus proche de ce Quartier</h4> </div> <div class="modal-body"><div id="infos"></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button></div></div></div></div>')
			$('#infos').columns({
						data:infos, 
						}); 
			$('#myModal').modal('toggle');
			console.log(infos);
				
		}

		$('body').on('hidden.bs.modal', '.modal', function () {
			//alert("ok");
			//$(this).removeData('bs.modal');
			//$("#myModal").remove();
			$("#modal-container").html('');
			
		});
});
		