/**
 * Compass region js
 */

/**
 * Navigate to region on click
 */
$('#compass-link').click(function(event) {
	event.preventDefault();

	// Hide the others if open
	$('#latest-tracks-selector, #latest-comments-selector').hide();
	$('#latest-comments, #latest-tracks').removeClass('active');
	// Close the add-song if active
	if ($('#add-song').hasClass('active')) {
		$('#add-song').trigger('click');
	}

	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
		$('#region-selector').hide();
	} else {
		$(this).addClass('active');
		$('#region-selector').show();
	}
});

/**
 * Region link click. Pan to lat lng pair.
 */
$('.region-link').click(function(event) {
	event.preventDefault();
	event.stopPropagation();

	// Set the view
	map.setView(
		new L.LatLng($(this).attr('lat'), $(this).attr('lng')), 
		parseInt($(this).attr('zoom')),
		{ animate: true, zoom: { animate: true } }
	);

	// Hide the compass bar
	$('#compass-link').removeClass('active');
	$('#region-selector').hide();
});


/**
 * Expand the latest tracks
 */
$('#latest-tracks').click(function(event) {
	event.preventDefault();

	// Hide the others if open
	$('#latest-comments-selector, #region-selector').hide();
	$('#compass-link, #latest-comments').removeClass('active');
	// Close the add-song if active
	if ($('#add-song').hasClass('active')) {
		$('#add-song').trigger('click');
	}

	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
		$('#latest-tracks-selector').hide();
	} else {
		$(this).addClass('active');
		$('#latest-tracks-selector').show();

		// Display the loading gif & text
		var loadingText = $('#latest-tracks-selector .loading-text');
		loadingText.text('Getting latest tracks');
		
		var loadingGif = $('#latest-tracks-selector .loading img');
		loadingGif.show();

		// Retrive the latest tracks
		$.ajax({
			url: '/latest-tracks',
			cache: false,
		})
		.done(function(data) {
			var latestTracks = '';

			for (var i = 0; i < data.length; i++) {
				var latestTrackMarker = data[i];

				// Get the markup and append to latestTracks
				latestTracks += latestTrackMarkup(latestTrackMarker);
			}
			
			$('#latest-tracks-content').html(latestTracks);

			// Hide loadingGif and change text
			loadingGif.hide();
			loadingText.text('Latest tracks loaded.');

			updateSidebarContent(); // Initiate track links

			// GA push
			ga('send', 'event', 'latest-tracks', 'click');
		})
		.fail(function() {
			$('#latest-tracks-content').html('<p>Whoops, an error occurred. Please try again.</p>');
		});
	}
});

/**
 * Generate the markup for the sidebar track item
 */
function latestTrackMarkup(marker) {
	var item = '';
	
	item += '<article class="item"><h2>';
		item += '<a href="/tracks/' + marker.id + '" class="tracklink" lat="' + marker.lat + '" lng="' + marker.lng + '" title="' + marker.title + '" youtubeid="' + marker.youtubeid + '" zoom="7">';

			item += '<span class="thumbwrapper"><img src="http://img.youtube.com/vi/' + marker.youtubeid + '/default.jpg" class="youtubethumb"></span>';
		
			item += '<span class="text-cutter">' + marker.title + '</span>';
		
		item += '</a></h2>';
		
		item += '<span class="sprite-likes"></span> '+ marker.up + (marker.up != 1 ? ' likes' : ' like') + ' &mdash; <span class="genre">' + marker.genre + '</span>';

	item += '</article>';

	return item;
}

/**
 * Expand the latest tracks
 */
$('#latest-comments').click(function(event) {
	event.preventDefault();

	// Hide the others if open
	$('#latest-tracks-selector, #region-selector').hide();
	$('#compass-link, #latest-tracks').removeClass('active');
	// Close the add-song if active
	if ($('#add-song').hasClass('active')) {
		$('#add-song').trigger('click');
	}

	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
		$('#latest-comments-selector').hide();
	} else {
		$(this).addClass('active');
		$('#latest-comments-selector').show();

		// Display the loading gif & text
		var loadingText = $('#latest-comments-selector .loading-text');
		loadingText.text('Getting latest tracks');
		
		var loadingGif = $('#latest-comments-selector .loading img');
		loadingGif.show();

		// Retrive the latest tracks
		$.ajax({
			url: '/latest-comments',
			cache: false,
		})
		.done(function(data) {
			var latestComments = '';

			for (var i = 0; i < data.length; i++) {
				var latestCommentsMarker = data[i];

				// Get the markup and append to latestComments
				latestComments += latestCommentsMarkup(latestCommentsMarker);
			}
			
			$('#latest-comments-content').html(latestComments);

			// Hide loadingGif and change text
			loadingGif.hide();
			loadingText.text('Latest comments loaded.');

			updateSidebarContent(); // Initiate track links

			// GA push
			ga('send', 'event', 'latest-comments', 'click');
		})
		.fail(function() {
			$('#latest-comments-content').html('<p>Whoops, an error occurred. Please try again.</p>');
		});
	}
});

/**
 * Generate the markup for the sidebar track item
 */
function latestCommentsMarkup(marker) {
	var item = '';
	
	item += '<article class="item"><p class="sidebar-comment">';
		item += '<a href="/tracks/' + marker.track.id + '" class="tracklink" lat="' + marker.track.lat + '" lng="' + marker.track.lng + '" title="' + marker.track.title + '" youtubeid="' + marker.track.youtubeid + '" zoom="7">';

			item += marker.body + '</a></p>';
		
		item += '<span class="sprite-likes"></span> '+ marker.up + (marker.up != 1 ? ' likes' : ' like') + ' &mdash; <span class="genre">' + marker.track.genre + '</span>';

	item += '</article>';

	return item;
}