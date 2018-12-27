<?php

/* @var $this ApCode\Template\Template */

$elementId = $this->argument(0);

$latitude  = $this->param('latitude', 0);
$longitude = $this->param('longitude', 0);
$title     = $this->param('title', '');
$zoom      = $this->param('zoom', 17);

Layout()->appendOnce('body.js.links', 'https://maps.googleapis.com/maps/api/js?key='. Config()->get('googlemap.key'));
Layout()->append('body.js.code', '
    $().ready(function(){
        var myLatlng = new google.maps.LatLng('. json_encode($latitude) .', '. json_encode($longitude) .');
        var mapOptions = {
          zoom: '. $zoom .',
          center: myLatlng,
          scrollwheel: false //we disable de scroll over the map, it is a really annoing when you scroll through page
          
        };
        var map = new google.maps.Map(document.getElementById('. json_encode($elementId) .'), mapOptions);

        var marker = new google.maps.Marker({
            position: myLatlng,
            title: '. json_encode($title) .'
        });

        // To add the marker to the map, call setMap();
        marker.setMap(map);
    });
');