<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.min.js'></script>
<script language="javascript">


    var centerCoordinates;
    var map;
    var marker;
    var lngLat;
    var geocoder;
                                    
    $(document).ready(function(){

        initialize(<?php echo $coordenada; ?>);

        mapboxgl.accessToken = 'pk.eyJ1IjoicmFmYWVsZHR4IiwiYSI6ImNsNWptM2JwcTAxZnEzYnFpbW54bjVpengifQ.N_eL-NtWqLcC9lqL4ZVeWg';
        
        map = new mapboxgl.Map({
            container: 'map',
            //style  : 'mapbox://styles/mapbox/dark-v10',
            style    : 'mapbox://styles/mapbox/streets-v11',
            center   : centerCoordinates,
            zoom     : <?php echo $zoom; ?> // starting zoom
        });

        if($("div#map").attr('meta') == "marker"){
            map.on('click', addMarker);
        }

        marker = new mapboxgl.Marker({

            draggable: true

        }).setLngLat(centerCoordinates).addTo(map);

        marker.on('dragend', onDragEnd);

        geocoder = new MapboxGeocoder({
            accessToken   : mapboxgl.accessToken,
            marker        : false,
            mapboxgl      : mapboxgl
        });

        if($("div#map").attr('meta') == "marker"){

            $("#geocoder").append(geocoder.onAdd(map));
            $(".mapboxgl-ctrl-geocoder").find('svg').remove();
            $(".mapboxgl-ctrl-geocoder").find('input').attr('id','form_endereco_mapbox').attr('placeholder','').attr('meta','PELOTAS , ');

            $(".mapboxgl-ctrl-geocoder").find('input').on('focus',function(e){ 
                $(this).val($(this).attr('meta')); 
                $(this).off('focus');
                $('#info_coord').html('');
            });
        }

        geocoder.on('result' , function(e){

            markerGeocoder(e.result.geometry.coordinates);
            $("#form_endereco").val($(".mapboxgl-ctrl-geocoder--input").val());

        });
        
    });

    function addMarker(e){

        lngLat = marker.getLngLat();

        marker.setLngLat([e.lngLat.lng, e.lngLat.lat]);
        $('#form_coordenada').val(e.lngLat.lat + ',' + e.lngLat.lng);

    }

    function onDragEnd() {
        lngLat = marker.getLngLat();
        $('#form_coordenada').val(lngLat.lat + ',' + lngLat.lng);
    }

    function markerGeocoder(coordinates) { console.log(coordinates);

        marker.setLngLat(coordinates).addTo(map);
        lngLat = marker.getLngLat();
        $('#form_coordenada').val(lngLat.lat + ',' + lngLat.lng);
    }

    function markerSetExterno(){
        marker.setLngLat(centerCoordinates).addTo(map.flyTo({center:centerCoordinates}));
    }

    function initialize(x,y){

        centerCoordinates = [y,x];

    }

// $('#pesquisar-map').click(function(event) {
//   address = $("#address").val();
//   var test = map.geocodeForward(address, function(err, data, res){
//     var coordinates = data.features[0].center;
//     console.log(coordinates[0]+" - "+coordinates[1]); 
//   });
// });

</script>