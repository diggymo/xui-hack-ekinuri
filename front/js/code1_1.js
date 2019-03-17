function initialize() {
    if (GBrowserIsCompatible()) {
      var map = new GMap2(document.getElementById("map_canvas"));
      map.setCenter(new GLatLng(34.42,135.30),13);
  
      var points1 = [
        new GLatLng(34.991261,135.730076),
        new GLatLng(34.997976,135.759945),
        new GLatLng(34.965979,135.772219)
      ];
  
      var points2 = [
        new GLatLng(35.003355,135.742607),
        new GLatLng(35.009014,135.770159),
        new GLatLng(34.98604,135.779815),
        new GLatLng(34.963834,135.755997),
        new GLatLng(35.003355,135.742607)
      ];
  
      var polygon1 = new GPolygon(points1);
      var polygon2 = new GPolygon(points2);
  
      map.addOverlay(polygon1);
      map.addOverlay(polygon2);
    }
  }