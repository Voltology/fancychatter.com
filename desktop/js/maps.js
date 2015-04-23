var maps = {
  infowindow : new google.maps.InfoWindow(),
  data : null,
  map : null,
  latitude : null,
  longitude : null,
  markersarray : [],
  mygeo : [],
  initialize : function() {
    var mapOptions = {
      zoom: 12,
      center: new google.maps.LatLng(maps.latitude, maps.longitude),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    maps.map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  },
  addmarker : function(location) {
    var marker = new google.maps.Marker({
      position: location,
      optimized: false,
      map: maps.map,
      icon:'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=' + (maps.markersarray.length + 1) + '|FF776B|000000',
      zoom:7
    });
    maps.markersarray.push(marker);
    maps.createinfowindow(marker);
  },
  createinfowindow : function(marker, data) {
    var html = '<table cellpadding="2" cellspacing="2" border="0"><tr><td valign="top">';
    html += '<div style="margin-top: 5px; max-height: 65px; overflow: hidden; width: 65px;"><img src="/uploads/logos/' + maps.data.logo + '" style="width:100%;" /></div>';
    html += '</td><td valign="top">';
    html += '<strong>' + maps.data.name + '</strong><br />';
    html += maps.data.address1 + '<br />';
    if (maps.data.address2 !== '') { html += maps.data.address2 + '<br />'; }
    html += maps.data.city + ', ' + maps.data.state + ' ' + maps.data.zipcode + '<br />';
    html += maps.data.phone;
    html += '</td></tr></table>';
    var infowindow = new google.maps.InfoWindow();
    maps.infowindow = infowindow;
    maps.infowindow.setContent(html);
    maps.infowindow.open(maps.map, marker);
  },
  populatemarkers : function() {
    maps.mygeo = new google.maps.LatLng(parseFloat(maps.latitude), parseFloat(maps.longitude));
    maps.addmarker(maps.mygeo);
  },
};
