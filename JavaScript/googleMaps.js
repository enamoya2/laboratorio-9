function mapa(ip){
  URL ='http://freegeoip.net/json/'+ip;
  	$.ajax({
  		url: URL,
  		success:function(response){
        $('#map').show();
        initMap(response.latitude, response.longitude);
      },
  		error:function(){alert("error");}
  	});
}



function initMap(latitude, longitude) {

  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: latitude, lng: longitude},
    zoom: 6
  });



  var latlon = {lat: latitude, lng: longitude};
  new google.maps.Marker({
    position: latlon,
    map: map,
    title: 'Suiiiiiiiiiii'
  });

  var infoWindow = new google.maps.InfoWindow({map: map});
}
