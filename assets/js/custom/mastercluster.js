/**
 * Add the master cluster to map
 */
var mastercluster = null; // The master cluster array of markers
$(function() {

	// Get the master cluster fuck
	$.get('/mastercluster', function(data) {

		mastercluster = JSON.parse(data); // Parse the fuckers

		/**
		 * Lets add some motherfucking markers
		 */
		var markers = new L.MarkerClusterGroup({
			chunkedLoading: true,
			chunkProgress: updateProgressBar,
			polygonOptions: {
				color: '#1c91f5',
				stroke: true,
				weight: 1,
				opacity: 0.4,
				fillOpacity: 0.3,
				fill: true,
			}
		});

		// Add markers leaflet_id to body
		$('body').attr('cluster_id', markers._leaflet_id);

		for (var i = 0; i < mastercluster.length; i++) {

			var entry = mastercluster[i]; // Entry

			var marker = L.marker(
				new L.LatLng(entry.lat, entry.lng),{
					riseOnHover: true,
					icon: trackMarker
				}
			).bindLabel('<span class="thumb-label-wrapper"><span class="thumb-label"><img src="http://img.youtube.com/vi/' + entry.youtubeid + '/default.jpg"></span></span> <span class="inner-title">' + entry.title + '</span><span class="label-genre">' + entry.genre + '</span>');

			marker.trackid = entry.id;

			marker.youtubeid = entry.youtubeid;

			marker.genre = entry.genre;

			marker.title = entry.title;

			markers.addLayer(marker);
		}

		map.addLayer(markers);

		/**
	 	* Add the default maker functionality
	 	*/
		markers.on('click', function (a) {
			var layer = a.layer;

			// Zoom to marker
			map.setView(
				new L.LatLng(layer.getLatLng().lat, layer.getLatLng().lng),
				map.getZoom() <= 6 ? 6 : map.getZoom(),
				{ animate: true, zoom: { animate: true } }
			);

			var genre = layer.genre, trackid = layer.trackid, youtubeid = layer.youtubeid;

			// Load track to sidebar
			addTrackSidebar(layer);

			// Change view to current
			$('#sidebar .main-sidebars').hide();
			$('#main').slideDown('slow');
			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.main').addClass('active');

			// Push this to GA
			ga('send', 'event', 'map-marker-clicked', 'click', layer.title);
		});
	})
	.done(function() {
		// Done
	})
	.fail(function() {
		alert('Whoops, an error has occurred loading the tracks. Please try again.')
	})
	.always(function() {
		// Run specific tasks depending on user landing page
		runStartupTask();
	});;
});

/**
 * Posistion the progress bar on center
 */
var progress = $('#progress');
progress.css('top', $('#map-wrapper').height() / 2);
progress.css('left', $('#map-wrapper').width() / 2);


/**
 * Progress bar loading
 */
function updateProgressBar(processed, total, elapsed, layersArray) {
	/**
	 * Progress bar loading variables
	 */
	var progress 	= document.getElementById('progress');
	var progressBar = document.getElementById('progress-bar');

	progress.style.display = 'block';
	progressBar.style.width = Math.round(processed/total*100) + '%';

	if (processed === total) {
		progress.style.display = 'none'; // all markers processed - hide the progress bar:
	}
}


/**
 * Add track to sidebar on marker click
 */
function addTrackSidebar(layer) {
	/**
	 * Instantly add video and title
	 */
	var url = 'src="//www.youtube.com/embed/' + layer.youtubeid + '?showinfo=0&amp;rel=0&amp;autoplay=1&amp;modestbranding=1&amp;iv_load_policy=3&amp;autohide=1"';

	var content = '<div class="youtube-wrapper"><iframe ' + url  + ' frameborder="0" allowfullscreen class="youtubeembed"></iframe></div>';
		content += '<h1>' + layer.title + '</h1>';
		content += loading;

	$('#main').html(content);

	$.ajax({
		url: '/tracks/' + layer.trackid,
	})
	.done(function(data) {
		$('#main .loading').replaceWith(data);

		/**
		 * Rerun sidebar init functions
		 */
		initiateSidebar();

		/**
		 * Add html5 pushstate
		 */
		var title = $("#main h1").text();

		window.history.pushState({
			'url': '/tracks/' + layer.trackid,
			'title': title,
			'data': $('#main').html()
		}, title, '/tracks/' + layer.trackid);

		document.title = title; // Set document title
	})
	.fail(function() {
		$('#main .loading').replaceWith('<div class="error-message"><p>Whoops, an error has happend. Try again.</p></div>');
	});
}

/**
 * Run specific tasks depending on url landing page
 */
function runStartupTask() {
	var url = document.location.pathname.split('/')[1];

	/**
	 * Landing on /genres
	 */
	if (url == 'genres') {
		makeHotOrGenre('genre');

		updateSidebarContent();

		// Expand genres
		expandGenres();
	}

	/**
	 * Landing on /hot
	 */
	if (url == 'hot') {
		makeHotOrGenre('hot');

		updateSidebarContent();
	}

	/**
	 * Track url /tracks/{id} or frontpage because we embed the latest shared track
	 */
	if (url === 'tracks') {
		var initLat = $('#main #track-lat-lng').attr('lat'),
			initLng = $('#main #track-lat-lng').attr('lng');

		// Zoom to inital marker
		map.setView(
			new L.LatLng(initLat, initLng),
			7,
			{ animate: true, zoom: { animate: true } }
		);
	}
}