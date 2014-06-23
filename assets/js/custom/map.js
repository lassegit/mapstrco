/**
 * Initiate the main map
 */
var layer = new L.StamenTileLayer("toner-lite"); // Custom tiles layer
map = new L.Map('map', {
	center: new L.LatLng(27.396949, -1.914063),
	zoom: 2,
	minZoom: 2,
	maxZoom: 13
});

// Set the bounds so we don't overflow
var southWest = L.latLng(-81.62135170283737, -198.6328125),
	northEast = L.latLng(100.19783846972054, 192.65625),
    bounds    = L.latLngBounds(southWest, northEast);

map.setMaxBounds(bounds);
map.addLayer(layer); // Add the tiles layer

/**
 * Add your song button
 */
$('#add-song').click(function(event) {
	event.preventDefault();

	// Hide the sidebar options if open
	$('#latest-tracks-selector, #region-selector, #latest-comments-selector').hide();
	$('#compass-link, #latest-tracks, #latest-comments').removeClass('active');

	if ($(this).hasClass('active')) {
		$(this).find('span.text').text('Add favorite local song');

		$(this).removeClass('active');

		// Hide help
		$('#add-song-help').hide();

		// Add cursor class
		$('#map').removeClass('add-song-cursor');
	} else {
		$(this).find('span.text').text('Disable song adding');

		$(this).addClass('active');

		// Show help
		$('#add-song-help').show();

		// Remove cursor class
		$('#map').addClass('add-song-cursor');
	}
});


map.on('click', function(e) {
	if ($('#add-song').hasClass('active')) {

		/**
		 * Fit the map round the marker
		 */
		map.setView(new L.LatLng(e.latlng.lat, e.latlng.lng), map.getZoom() <= 7 ? 7 : map.getZoom(), { animate: true, zoom: { animate: true } });

		/**
		 * Add a new marker
		 */
		var marker = new L.Marker(e.latlng, {
			'icon':  newMarker,
			draggable: true
		}).bindPopup(loading, formPopup).addTo(map).openPopup();

		/**
		 * Get request the form
		 */
		$.ajax({url: '/tracks/create',})
		.done(function(data) {
			marker.setPopupContent(data);

			saveTrack(); // Initiate form

			$('.leaflet-popup-content form').attr('leaflet_id', marker._leaflet_id); // Add leaflet id to form

			/**
			 * Initiate the chosen select forms
			 */
			$(".leaflet-popup-content .chosen-select").chosen({disable_search: true, inherit_select_classes: true});

			$(".leaflet-popup-content .chosen-search-select").chosen({inherit_select_classes: true});

			// Push this to GA
			ga('send', 'event', 'map-marker-added', 'click', 'New marker added');
		})
		.fail(function() {
			alert('Whoops, an error has occurred. Please try again.');

			map._layers[marker._leaflet_id].closePopup();

			map.removeLayer(map._layers[marker._leaflet_id]);
		});
	}
});

/**
 * On popupopen
 */
map.on('popupopen', function(e) {
	var marker = e.popup._source; // Make sure form has leaflet id
	$('.leaflet-popup-content form').attr('leaflet_id', marker._leaflet_id);

	saveTrack();
});

/**
 * Update popup content when save
 */
map.on('popupclose', function(e) {
	e.popup.setContent($('.leaflet-popup-content').html());
});

/**
 * MAP DEFAULTS - easy change of tiles provider ~ just in case
 */
// var osmUrl = 'http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png';
// var osmSub = ['otile1','otile2','otile3','otile4'];
// var osmAttrib = 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png">';

/**
 * ICON PATH
 */
L.Icon.Default.imagePath = '/img/';

///////////////
// Gray icon //
///////////////
var newMarker = L.icon({
    iconUrl: '/img/newmarker.png',
    // iconRetinaUrl: 'my-icon@2x.png',
    iconSize: [30, 37],
    iconAnchor: [16, 37],
    popupAnchor: [0, -37],
    shadowUrl: '/img/marker-shadow.png',
    shadowUrl: '/img/marker-shadow.png',
    shadowRetinaUrl: '/img/marker-shadow.png',
    shadowSize: [30, 37],
    shadowAnchor: [9, 37],
    // Label
    labelAnchor: [10, -22]
});

var trackMarker = L.icon({
    iconUrl: '/img/trackmarker.png',
    iconRetinaUrl: '/img/trackmarker-2x.png',
    iconSize: [30, 37],
    iconAnchor: [16, 37],
    popupAnchor: [0, -37],
    shadowUrl: '/img/marker-shadow.png',
    shadowRetinaUrl: '/img/marker-shadow.png',
    shadowSize: [30, 37],
    shadowAnchor: [9, 37],
    // Label
    labelAnchor: [10, -22]
});

/**
 * Loading div
 */
var loading = '<div class="loading"><img src="/img/loading.gif"> Loading... </div>';

/**
 * Form popup
 */
var formPopup = {
	minWidth: 310,
	maxWidth: 310,
	maxHeight: 450,
	keepInView: true,
	closeOnClick: true
}
