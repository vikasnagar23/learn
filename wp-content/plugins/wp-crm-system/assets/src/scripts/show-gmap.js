function init_map() {
  var myOptions = {
    zoom: 14,
    center: new google.maps.LatLng(wcs_gmap_vars.latitude, wcs_gmap_vars.longitude),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
  marker = new google.maps.Marker({
    map: map,
    position: new google.maps.LatLng(wcs_gmap_vars.latitude, wcs_gmap_vars.longitude)
  });
  infowindow = new google.maps.InfoWindow({
    content: wcs_gmap_vars.address
  });
  google.maps.event.addListener(marker, "click", function () {
    infowindow.open(map, marker);
  });
  infowindow.open(map, marker);
}
google.maps.event.addDomListener(window, 'load', init_map);
