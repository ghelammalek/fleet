
$( document ).ready(function() {
  $('#map_bloc4').hide();
  $('form').jqTransform({imgPath:'jqtransformplugin/img/'});

  $('tr:odd')
    .css({
      "background-color" : "white", 
      "color" : "#333132",
      "z-index" : "1"
  });
  var plusmoins = 0;
  $('.morecontent_tableau').hide();

  $('.seemore_img').click(function(){
    var that = this;
    $(this).closest("tr").find("div").slideToggle(500, function() {
      if ($(this).is(':visible')) {
        $(that).attr('src',racineimg+'/tpl/img/moins_ico.png');
      } else {
        $(that).attr('src',racineimg+'/tpl/img/plus_ico.png');
      }
    });
      
  })
  $( ".datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
  $(".datepicker").datepicker({
    dateFormat : 'dd/mm/yy',
  });

  $( ".timepicker" ).timepicker( $.timepicker.regional[ "fr" ] );
    $(function(){
      $('.timepicker').timepicker({
        showPeriodLabels: false,
      });
  });

});

function showmap2(){
  $('#map_bloc4').fadeIn(500);
  $('.itinery').replaceWith("<a class='itinery' href=\"javascript:hidemap2()\"><img src='"+racineimg+"/tpl/img/itinerary.gif'></a>")
  google.maps.event.trigger(map,'resize');
  $('html, body').animate({
    scrollTop:$("#map_bloc4").offset().top
  }, 'slow');
  initialize();
 }

function hidemap2(){
  $('#map_bloc4').hide(500);
  $('.itinery').replaceWith("<a class='itinery' href='javascript:showmap2()'><img src='"+racineimg+"/tpl/img/itinerary.gif'></a>")
 }
 /*
function initialize() {
    var a = new google.maps.LatLng(51.50135, -.14184000000000002),
        b = {
            zoom: 15,
            center: a
        },
        c = new google.maps.Map(document.getElementById("map"), b),
        d = (new google.maps.Marker({
            position: a,
            map: c
        }), [new google.maps.LatLng(51.50135, -.14184000000000002), new google.maps.LatLng(51.50161000000001, -.14113), new google.maps.LatLng(51.501400000000004, -.14072), new google.maps.LatLng(51.50150000000001, -.14032), new google.maps.LatLng(51.50175, -.14008), new google.maps.LatLng(51.501990000000006, -.14012000000000002), new google.maps.LatLng(51.50211, -.14004), new google.maps.LatLng(51.505840000000006, -.13083), new google.maps.LatLng(51.50524000000001, -.12946000000000002), new google.maps.LatLng(51.50513, -.12912), new google.maps.LatLng(51.50529, -.12802000000000002)]),
        e = new google.maps.Polyline({
            path: d,
            geodesic: !0,
            strokeColor: "#FF0000",
            strokeOpacity: 1,
            strokeWeight: 2
        });
    e.setMap(c)
}
google.maps.event.addDomListener(window, "load", initialize);

*/

var markers = [];

var Box = [];
var map;
var listCircle;
function initialize() {
    map = new google.maps.Map(document.getElementById("map"));
    var marker_bounds = [];
    /*
    var a = new google.maps.LatLng(51.50135, -.14184000000000002),
        b = {
            zoom: 15,
            center: a
        },
        c = new google.maps.Map(document.getElementById("map"), b),
        d = (new google.maps.Marker({
            position: a,
            map: c
        }), [new google.maps.LatLng(51.50135, -.14184000000000002), new google.maps.LatLng(51.50161000000001, -.14113), new google.maps.LatLng(51.501400000000004, -.14072), new google.maps.LatLng(51.50150000000001, -.14032), new google.maps.LatLng(51.50175, -.14008), new google.maps.LatLng(51.501990000000006, -.14012000000000002), new google.maps.LatLng(51.50211, -.14004), new google.maps.LatLng(51.505840000000006, -.13083), new google.maps.LatLng(51.50524000000001, -.12946000000000002), new google.maps.LatLng(51.50513, -.12912), new google.maps.LatLng(51.50529, -.12802000000000002)]),
        e = new google.maps.Polyline({
            path: d,
            geodesic: !0,
            strokeColor: "#FF0000",
            strokeOpacity: 1,
            strokeWeight: 2
        });
    e.setMap(c)
    */
    /*
    for(i=0;i<tabcoordonnee.length;i++){
    //alert(tabcoordonnee[i][0]);
    myLatLng = new google.maps.LatLng(tabcoordonnee[i][0], tabcoordonnee[i][1]);
    marker_bounds.push(myLatLng);
    } */
    //console.log(marker_bounds);
    var flightPath = new google.maps.Polyline({
      path: tabcoordonnee,
      geodesic: true,
      strokeColor: '#FF0000',
      strokeOpacity: 1.0,
      strokeWeight: 5
    });
    flightPath.setMap(map);
    showlieux(map);
    
    
    
    var latlngbounds = new google.maps.LatLngBounds();
    /*
    for ( var i = 0; i < marker_bounds.length; i++ ) {

    //for ( var i = marker_bounds.length-1; i >0; i--) {
      //console.log("icijc : "+marker_bounds[i])
       latlngbounds.extend(marker_bounds[i]);
    } 
    */
 
    //var marker_bounds2=[]; 
    //new google.maps.LatLng('48.9143973', '2.2813133')
    /*
    alert(tabcoordonnee[0][0])
    alert(tabcoordonnee[0][1])
    */
    //marker_bounds2.push(new google.maps.LatLng(tabcoordonnee[0][0], tabcoordonnee[0][1]));
    //marker_bounds2.push(new google.maps.LatLng('48.9143973', '2.2813133'));
    for ( var i = 0; i < tabcoordonnee.length; i++ ) {
      //console.log("icijc : "+marker_bounds[i])
       latlngbounds.extend(tabcoordonnee[i]);
    } 
    /*
    latlngbounds.extend(marker_bounds[0]);
    latlngbounds.extend(marker_bounds[marker_bounds.length-1]);
    */
    map.setCenter(latlngbounds.getCenter(),6);
    map.fitBounds(latlngbounds);
          1
}
google.maps.event.addDomListener(window, "load", initialize);

function showlieux(map){
  for(i=0;i<tab.length;i++){
    
    var myLatLng = new google.maps.LatLng(tab[i][1], tab[i][2]);
    var image = {
      url: racineimg+'tpl/img/lieux/'+tab[i][0],   
      // This marker is 20 pixels wide by 32 pixels tall.
      size: new google.maps.Size(32, 32),
      // The origin for this image is 0,0.
      origin: new google.maps.Point(0,0),
      // The anchor for this image is the base of the flagpole at 0,32.
      anchor: new google.maps.Point(16, 16)
    };
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image
        //,
        //shape: shape,
        //title: item.nomvehicule
    });
    //alert(tab[i][3])
    var mycircle = {
      strokeColor:  "#FF0000",
      strokeOpacity: 0.4,
      strokeWeight: 2,
      fillColor: "#CACACA",
      fillOpacity: 0.35,
      map: map,
      center: myLatLng,
      radius:  (tab[i][3]*1)
    };
    listCircle = new google.maps.Circle(mycircle);
    //marker_bounds.push(myLatLng);
  }
}