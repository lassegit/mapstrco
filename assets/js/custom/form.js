/**
 * Save the a new track
 */
function saveTrack() {
	/**
	 * Load youtube meta data
	 */
	$('.leaflet-popup-content form input[name=url]').change(function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();
		$('.leaflet-popup-content #popup-preview').show();
		// Clear the preview area
		$('.leaflet-popup-content #popup-preview').html(loading);

		var youtube_id = youtube_parser($(this).val());

		if (youtube_id != false) {
			$.ajax({
				url: 'http://gdata.youtube.com/feeds/api/videos/'+youtube_id+'?v=2&alt=jsonc',
				type: 'GET',
				dataType: 'jsonp',
				crossDomain: true,
				cache: false
			})
			.done(function(data) {
			    $('.leaflet-popup-content form textarea[name=title]').val(data.data.title);

			    $('.leaflet-popup-content form input[name=duration]').val(data.data.duration);

			    $('.leaflet-popup-content form input[name=youtubeid]').val(data.data.id);

			    // Enable submit button
			    $('.leaflet-popup-content input[type=submit]').removeAttr('disabled');

			    // $('.leaflet-popup-content #popup-preview .loading').remove();
			    $('.leaflet-popup-content #popup-preview').html('<img class="preview-thumb" src="' + data.data.thumbnail.sqDefault + '"><p>' + data.data.title + '</p>');

			})
			.fail(function(data) {
				$('.leaflet-popup-content #popup-preview').html('<p>Whoops, something when wrong. Make sure your youtube url is correct.</p>');

				// Enable submit button - some browsers will block cross domain request
			    $('.leaflet-popup-content input[type=submit]').removeAttr('disabled');
			});

		} else {
			$('.leaflet-popup-content #popup-preview').html('<p>Whoops, something when wrong. Make sure your youtube url is correct.</p>');
		}
	});


	/**
	 * Alter preveiw title
	 */
	$('.leaflet-popup-content form textarea[name=title]').change(function(event) {
		 var preview_text = $('.leaflet-popup-content #popup-preview p');

		 if (preview_text[0]) {
		 	preview_text.text($(this).val());
		 }
	});


	/**
	 * Sub form
	 */
	$('.leaflet-popup-content form').bind('submit', function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Attach lat/lng info
		$(this).find('input[name=lat]').attr('value', map._layers[$(this).attr('leaflet_id')]._latlng['lat']);
		$(this).find('input[name=lng]').attr('value', map._layers[$(this).attr('leaflet_id')]._latlng['lng']);

		// Get lenght of polyline
		var formData 	= $(this).serialize();
		var url			= $(this).attr('action');
		var method 		= $(this).attr('method');
		var button 		= $(this).find('input[type=submit]');
		var error 		= $(this).find('.error-message');
		var leafletid 	= $(this).attr('leaflet_id');
		var title 		= $(this).find('textarea[name=title]').val();
		var mar_genre	= $(this).find('.chosen-genre a.chosen-single span').text();
		var youtubeid 	= $(this).find('input[name=youtubeid]').val();

		button.attr('disabled', 'disabled');
		button.val('Saving...');

		// Ajax post
		$.ajax({
			url: url,
			type: method,
			dataType: 'html',
			data: formData
		})
		.done(function(data) {
			error.html('');
			/**
			 * Add new clustermarker and remove the old
			 */
			var marker = L.marker(
				new L.LatLng(map._layers[leafletid].getLatLng().lat, map._layers[leafletid].getLatLng().lng), {
					riseOnHover: true,
					icon: trackMarker
				}
			).bindLabel('<span class="thumb-label-wrapper"><span class="thumb-label"><img src="http://img.youtube.com/vi/' + youtubeid + '/default.jpg"></span></span> <span class="inner-title">' + title + '</span><span class="label-genre">' + mar_genre + '</span>');
			marker.trackid = data;

			marker.youtubeid = youtubeid;

			marker.genre = mar_genre;

			marker.title = title;
			/**
			 * Add this to master cluster
			 */
			map._layers[$('body').attr('cluster_id')].addLayer(marker);

			/**
			 * Remove form marker
			 */
			map._layers[leafletid].closePopup();
			map.removeLayer(map._layers[leafletid]);

			/**
			 * Zoom to marker and trigger click
			 */
			map._layers[$('body').attr('cluster_id')].zoomToShowLayer(marker, function () {
				marker.fire('click'); // Fire the click
			});

			// Push this to main mastercluster
			mastercluster.unshift({
				'id': data,
				'youtubeid': youtubeid,
				'genre': mar_genre,
				'title': title,
				'lat': marker._latlng.lat,
				'lng': marker._latlng.lng
			});

			hot = null;
			genrepage = null;
		})
		.fail(function(data) {
			error.html('');
			error.html(data.responseText);
		})
		.always(function() {
			button.removeAttr('disabled');
			button.val('Save');
		});
	});
}

/**
 * Parse the youtube url and get id or false.
 */
function youtube_parser(url){
	try {
		var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
		var match = url.match(regExp);

		if (match && match[7].length==11) {
			var b=match[7];
			return b;
		} else {
			return false;
		}
	}
	catch (err) {
		return false;
	}
}


/**
 * The login form
 */
$(function() {
	$('#signup #signinbutton').click(function(event) {
		event.preventDefault();
		var signup = $('#signup');

		if ( signup.hasClass('active') ) {
			signup.removeClass('active');
			$('#signups').hide();
		} else {
			signup.addClass('active');
			$('#signups').show();
		}
	});


	/**
	 * Sign up form tabs
	 */
	$('#signuplink, #signinlink').click(function(event) {
		event.preventDefault();

		if ($(this).attr('id') === 'signuplink') {
			$('#signinform').hide();
			$('#signinlink').removeClass('active');
			$(this).addClass('active');
			$('#signupform').show();
		}

		if ($(this).attr('id') === 'signinlink') {
			$('#signupform').hide();
			$('#signuplink').removeClass('active');
			$(this).addClass('active');
			$('#signinform').show();
		}
	});
});

/**
 * User login or sign up form
 */
function login() {
	$('#signupform form, #signinform form').submit(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Get lenght of polyline
		var formData 	= $(this).serialize();
		var url			= $(this).attr('action');
		var method 		= $(this).attr('method');
		var button 		= $(this).find('input[type=submit]');
		var error 		= $(this).find('.error-message');

		button.attr('disabled', 'disabled');
		button.val('Working...');

		// Ajax post
		$.ajax({
			url: url,
			type: method,
			dataType: 'html',
			data: formData
		})
		.done(function(data) {
			$('#signups').remove();

			$('#signup').replaceWith(data);
		})
		.fail(function(data) {
			error.html('');

			try {
				error.append(JSON.parse(data.responseText));
			} catch ($err) {
				error.append(data.responseText);
			}
		})
		.always(function() {
			button.removeAttr('disabled');
			button.val('Save');

			initiateSidebar();
		});
	});
}

$(function() {
	login();
});


/**
 * Save comments form on tracks
 */
function saveComment() {
	$('#commentsform form').submit(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Get lenght of polyline
		var formData 	= $(this).serialize();
		var url			= $(this).attr('action');
		var method 		= $(this).attr('method');
		var button 		= $(this).find('input[type=submit]');
		var error 		= $(this).find('.error-message');
		var body 		= $(this).find('textarea');

		button.attr('disabled', 'disabled');
		button.val('Saving...');

		// Ajax post
		$.ajax({
			url: url,
			type: method,
			dataType: 'html',
			data: formData
		})
		.done(function(data) {
			error.html('');

			$('#commentsroll').prepend(data); // Append data to comments roll

			body.val(''); // Clear textarea

			// Initate user link
			updateSidebarContent();
			likeComment();

			// Remove 'no comment yet'
			$('.none-comments').remove();

			// Add comment count
			$('#showcomments span.number').text(parseInt( $('#showcomments span.number').text()) + 1);
		})
		.fail(function(data) {
			error.html('');
			error.append('<p>Whoops, something went wrong. Make sure you are logged in.</p>');
		})
		.always(function() {
			button.removeAttr('disabled');
			button.val('Save');

			// Update pushstate
			updatePushstate();
		});
	});
}

$(function() {
	saveComment();
});


/**
 * Edit user form
 */
function getUserEditForm() {
	$('#edit-user').click(function(event) {
		event.preventDefault();
		event.stopPropagation();

		url = $(this).attr('href');

		$.ajax({
			url: url,
		})
		.done(function(data) {
			$('#main').html(data);

			// Initiate the ajax form & chosen
			$("#user-edit-form .chosen-select").chosen({disable_search: true, inherit_select_classes: true});

			$("#user-edit-form .chosen-search-select").chosen({inherit_select_classes: true});

			updateUserForm();

		})
		.fail(function(data) {
			user_error = $('.user-error');
			user_error.html('');
			user_error.append(JSON.parse(data.responseText));
		});
	});
}

$(function() {
	getUserEditForm();
});

/**
 * Update user form
 */
function updateUserForm() {
	$('#user-edit-form form').submit(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Get lenght of polyline
		var formData 	= $(this).serialize();
		var url			= $(this).attr('action');
		var method 		= $(this).attr('method');
		var button 		= $(this).find('input[type=submit]');
		var error 		= $(this).find('.error-message');

		button.attr('disabled', 'disabled');
		button.val('Saving...');

		// Ajax post
		$.ajax({
			url: url,
			type: method,
			dataType: 'html',
			data: formData
		})
		.done(function(data) {
			$('#main').html(data);

			initiateSidebar();

			// Update pushstate
			updatePushstate();
		})
		.fail(function(data) {
			error.html('');
			error.append(data.responseText);
		})
		.always(function() {
			button.removeAttr('disabled');
			button.val('Save');
		});
	});
}


/**
 * Edit user form
 */
function getTrackEditForm() {
	$('#edit-track').click(function(event) {
		event.preventDefault();
		event.stopPropagation();

		url = $(this).attr('href');

		$.ajax({
			url: url,
		})
		.done(function(data) {
			$('#sidebar #main').html(data);

			// Initiate the ajax form & chosen
			$("#track-edit-form .chosen-select").chosen({disable_search: true, inherit_select_classes: true});

			$("#track-edit-form .chosen-search-select").chosen({inherit_select_classes: true});

			updateTrackForm();

		})
		.fail(function(data) {
			track_error = $('.track-error');
			track_error.html('');
			track_error.append(JSON.parse(data.responseText));
		});
	});
}

$(function() {
	getTrackEditForm();
});

function updateTrackForm() {

	/**
	 * Load youtube meta data
	 */
	$('#track-edit-form form input[name=url]').change(function(event) {
		event.stopPropagation();
		event.stopImmediatePropagation();
		$('#track-edit-form #popup-preview').show();
		// Clear the preview area
		$('#track-edit-form #popup-preview').html(loading);

		var youtube_id = youtube_parser($(this).val());

		if (youtube_id != false) {
			$.ajax({
				url: 'http://gdata.youtube.com/feeds/api/videos/'+youtube_id+'?v=2&alt=jsonc',
				type: 'GET',
				dataType: 'jsonp',
				crossDomain: true,
				cache: false
			})
			.done(function(data) {
			    $('#track-edit-form form input[name=duration]').val(data.data.duration);

			    $('#track-edit-form form input[name=youtubeid]').val(data.data.id);

			    $('#track-edit-form #popup-preview .loading').remove();
			    $('#track-edit-form #popup-preview').append('<img class="preview-thumb" src="' + data.data.thumbnail.sqDefault + '"><p>' + data.data.title + '</p>');

			})
			.fail(function(data) {
				$('#track-edit-form #popup-preview').html('<p>Whoops, something when wrong. Make sure your youtube url is correct.</p>');
			});

		} else {
			$('#track-edit-form #popup-preview').html('<p>Whoops, something when wrong. Make sure your youtube url is correct.</p>');
		}
	});


	/**
	 * Alter preveiw title
	 */
	$('#track-edit-form form textarea[name=title]').change(function(event) {
		 var preview_text = $('#track-edit-form #popup-preview p');

		 if (preview_text[0]) {
		 	preview_text.text($(this).val());
		 }
	});

	$('#track-edit-form form').submit(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Get lenght of polyline
		var formData 	= $(this).serialize();
		var url			= $(this).attr('action');
		var method 		= $(this).attr('method');
		var button 		= $(this).find('input[type=submit]');
		var error 		= $(this).find('.error-message');

		button.attr('disabled', 'disabled');
		button.val('Saving...');

		// Ajax post
		$.ajax({
			url: url,
			type: method,
			dataType: 'html',
			data: formData
		})
		.done(function(data) {
			$('#main').html(data);

			initiateSidebar();

			// Update pushstate
			updatePushstate();
		})
		.fail(function(data) {
			error.html('');
			error.html(data.responseText);
		})
		.always(function() {
			button.removeAttr('disabled');
			button.val('Save');
		});
	});
}
