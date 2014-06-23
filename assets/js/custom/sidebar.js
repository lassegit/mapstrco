/**
 * Sidebar navigation
 */
$('#sidebartabs a').click(function(event) {
	event.preventDefault();
	event.stopPropagation();

	if ( ! $(this).hasClass('active') ) {
		$('#sidebartabs a').removeClass('active');
		$(this).addClass('active');

		/**
		 * Generate hot and genre pages
		 */
		var type = $(this).attr('show');

		if ( type === 'hot-sidebar') {

			if (hot === null) {
				makeHotOrGenre('hot');
			} else {
				$('#hot-sidebar').html(hot); // Append to sidebar
			}

		} else if ( type === 'genre-sidebar' ) {

			if (genrepage === null) {
				makeHotOrGenre('genre');
			} else {
				$('#genre-sidebar').html(genrepage); // Append to sidebar
			}

			// Expand genres click
			expandGenres();
		}

		$('#sidebar .main-sidebars').hide();
		$('#' + type).slideDown('slow');

		// Active js links
		updateSidebarContent();

		// Push to html5
		url = $(this).attr('href');
		title = $('#' + type + ' h1').text();

		window.history.pushState({
			'url': url,
			'title': title,
			'data': $('#' + type).html()
		}, title, url);

		// Set document title
		document.title = title;

		// Push this to GA
		ga('send', 'event', 'sidebar-tab', 'click', title);
	}
});

/**
 * Generate the genre or hot sidebar pages from the master cluster group.
 * First the vars for optimization
 */
var hot = null;
var genrepage = null;
function makeHotOrGenre(type) {

	var markers_length = mastercluster.length;

	if ( markers_length > 50 ) {
		markers_length = 50;
	}

	/**
	 * Generate the hot list
	 */
	if (type === 'hot') {
		hot = '<h1>Top ' + markers_length + ' tracks</h1>';
		hot += '<p>List created from your likings.</p>';

		// Create a top 100
		for (var i = 0; i < markers_length; i++) {
			marker = mastercluster[i];

			hot += sidebarItemMarkup(marker, i); // Create markup
		}

		$('#hot-sidebar').html(hot);
	}

	/**
	 * Generate the genre list
	 */
	if (type === 'genre') {
		var genres = [
			['pop'],
			['rock'],
			['indie rock'],
			['electronic'],
			['jazz'],
			['blues'],
			['funk'],
			['folk'],
			['raggae'],
			['rap & hip hop'],
			['R&B'],
			['classical'],
			['country'],
			['chillout'],
			['concert'],
			['other']
		];

		for (var i = 0; i < mastercluster.length; i++) {
			marker = mastercluster[i];

			switch (marker.genre) {
				case 'pop':
					var popLength = genres[0].length;
					if (popLength <= 30) {
						genres[0].push(sidebarItemMarkup(marker, popLength - 1));
					}
					break;

				case 'rock':
					var rockLength = genres[1].length;
					if (rockLength <= 30) {
						genres[1].push(sidebarItemMarkup(marker, rockLength - 1));
					}
					break;

				case 'indie rock':
					var indieRockLength = genres[2].length;
					if (indieRockLength <= 30) {
						genres[2].push(sidebarItemMarkup(marker, indieRockLength - 1));
					}
					break;

				case 'electronic':
					var electronicLength = genres[3].length;
					if (electronicLength <= 30) {
						genres[3].push(sidebarItemMarkup(marker, electronicLength - 1));
					}
					break;

				case 'jazz':
					var jazzLength = genres[4].length;
					if (jazzLength <= 30) {
						genres[4].push(sidebarItemMarkup(marker, jazzLength - 1));
					}
					break;

				case 'blues':
					var bluesLength = genres[5].length;
					if (bluesLength <= 30) {
						genres[5].push(sidebarItemMarkup(marker, bluesLength - 1));
					}
					break;

				case 'funk':
					var funkLength = genres[6].length;
					if (funkLength <= 30) {
						genres[6].push(sidebarItemMarkup(marker, funkLength - 1));
					}
					break;

				case 'folk':
					var folkLength = genres[7].length;
					if (folkLength <= 30) {
						genres[7].push(sidebarItemMarkup(marker, folkLength - 1));
					}
					break;

				case 'raggae':
					var raggaeLength = genres[8].length;
					if (raggaeLength <= 30) {
						genres[8].push(sidebarItemMarkup(marker, raggaeLength - 1));
					}
					break;

				case 'rap & hip hop':
					var rapLength = genres[9].length;
					if (rapLength <= 30) {
						genres[9].push(sidebarItemMarkup(marker, rapLength - 1));
					}
					break;

				case 'R&B':
					var rbLength = genres[10].length;
					if (rbLength <= 30) {
						genres[10].push(sidebarItemMarkup(marker, rbLength - 1));
					}
					break;

				case 'classical':
					var classicalLength = genres[11].length;
					if (classicalLength <= 30) {
						genres[11].push(sidebarItemMarkup(marker, classicalLength - 1));
					}
					break;

				case 'country':
					var countryLength = genres[12].length;
					if (countryLength <= 30) {
						genres[12].push(sidebarItemMarkup(marker, countryLength - 1));
					}
					break;

				case 'chillout':
					var chilloutLenght = genres[13].length;
					if (chilloutLenght <= 30) {
						genres[13].push(sidebarItemMarkup(marker, chilloutLenght - 1));
					}
					break;

				case 'concert':
					var concertLenght = genres[14].length;
					if (concertLenght <= 30) {
						genres[14].push(sidebarItemMarkup(marker, concertLenght - 1));
					}
					break;

				case 'other':
					var otherLenght = genres[15].length;
					if (otherLenght <= 30) {
						genres[15].push(sidebarItemMarkup(marker, otherLenght - 1));
					}
					break;
			}
		}

		/**
		 * Sort the array by sub array length
		 */
		genres.sort(function(a,b) {
			if(a.length > b.length) {
				return -1;
			}
			else if(a.length < b.length) {
				return 1;
			}
			else {
				return 0;
			}
		});

		/**
		 * Final for loop to merge everything into one content block
		 */
		genrepage = '<h1>Top tracks by gerne</h1>';
		for (var i = 0; i < genres.length; i++) {

			if (genres[i].length > 1) {
				var genreName = genres[i][0];
				genrepage 	+= '<div class="genre-wrapper">';
				genres[i][0] = '<h2 class="genre-title">Top <b>' + genreName + '</b> tracks</h2>';
				genrepage 	+= genres[i].join(" ");
				genrepage 	+= '</div>';
				genrepage 	+= '<span class="show-more-genre">More ' + genreName + '</span>';
			}
		}

		$('#genre-sidebar').html(genrepage); // Append in sidebar
	}
}

/**
 * Generate the markup for the sidebar track item
 */
function sidebarItemMarkup(marker, number) {
	var item = '';

	item += '<article class="item"><h2>';
		item += '<a href="/tracks/' + marker.id + '" class="tracklink" lat="' + marker.lat + '" lng="' + marker.lng + '" title="' + marker.title + '" youtubeid="' + marker.youtubeid + '" zoom="7">';

			item += '<span class="thumbwrapper"><img src="http://img.youtube.com/vi/' + marker.youtubeid + '/default.jpg" class="youtubethumb"></span>';

			item += '<span class="text-cutter">' + marker.title + '</span>';

		item += '</a></h2>';

		item += '<span class="tracknumber">#' + (number + 1) + '</span> &mdash; <span class="genre">' + marker.genre + '</span>';
	item += '</article>';

	return item;
}

/**
 * Expand genres to show more
 */
function expandGenres() {
	$('.show-more-genre').click(function(event) {
		event.stopPropagation;

		var genreWrapper =  $(this).prev();
		var height 		 = genreWrapper.height();
		var maxHeight    = parseInt(genreWrapper.css('max-height'));

		// Expand div height
		genreWrapper.css('max-height', height + 410);

		if (height < maxHeight) {
			$(this).text('No more tracks.');
			$(this).unbind('click');
		}
	});
}



/**
 * Track like
 */
function likeTrack() {
	$('.tracklike a.liketrack').click(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Stop requesting if already working
		if ($(this).hasClass('requesting')) {
			return false;
		}

		// This is requesting
		$(this).addClass('requesting');

		var url = $(this).attr('href'), type = $(this).attr('like'), trackid = $(this).attr('trackid'), tracklikes = parseInt($('.tracklikes').text()), link = $(this);

		// User liked it
		if ( type == 'like' ) {
			$('.tracklikes').text(tracklikes + 1);

			link.attr('href', '/unliketrack/' + trackid);

			link.attr('like', 'unlike');

			link.find('span').removeClass('sprite-trackunliked');
			link.find('span').addClass('sprite-trackliked');


		} else {
			$('.tracklikes').text(tracklikes - 1);

			link.attr('href', '/liketrack/' + trackid);

			link.attr('like', 'like');

			link.find('span').removeClass('sprite-trackliked');
			link.find('span').addClass('sprite-trackunliked');
		}

		/**
		 * Request the backend
		 */
		$.ajax({
			url: url,
		})
		.done(function(data) {
			$('.tracklike .error-message').html(''); // Remove any error

			if (type === 'like') {
				$('#likesroll').prepend(data);

				$('#showlikes span.number').text(parseInt( $('#showlikes span.number').text()) + 1);
			} else {

				$('#likesroll #track-like-' + data).remove();

				$('#showlikes span.number').text(parseInt( $('#showlikes span.number').text()) - 1);
			}

			if (parseInt( $('#showlikes span.number').text()) != 0) {
				$('.none-likes').hide();
			} else {
				$('.none-likes').show();
			}

			updateSidebarContent(); // Update for userlinks

			// GA push
			ga('send', 'event', 'track-like', 'click', url);
		})
		.fail(function(data) {
			$('.tracklike .error-message').html('');
			$('.tracklike .error-message').html(JSON.parse(data.responseText));

			// Reset the like link
			$('.tracklikes').text(Math.abs(tracklikes));

			link.attr('href', '/liketrack/' + trackid);

			link.attr('like', 'like');

			link.find('span').removeClass('sprite-trackliked');
			link.find('span').addClass('sprite-trackunliked');
		})
		.always(function() {
			link.removeClass('requesting');

			// Update pushstate
			updatePushstate();
		});
	});
}

$(function() {
	likeTrack();
});


/**
 * Show / hide comments & likes
 */
function showHideComments() {
	$('#comment-likes-selector .span-buttons').click(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		$('#comment-likes-selector span').removeClass('active');

		$(this).addClass('active');

		if ($(this).attr('id') == 'showcomments') {
			$('#likesroll').hide();

			$('#commentsroll').show();
		} else {
			$('#commentsroll').hide();

			$('#likesroll').show();
		}
	});
}

$(function() {
	showHideComments();
});

/**
 * Like comments
 */
function likeComment() {
	$('.comment-like a').click(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		// Stop requesting if already working
		if ($(this).hasClass('requesting')) {
			return false;
		}

		// This is requesting
		$(this).addClass('requesting');

		// Variables
		var url 			= $(this).attr('href'),
			type 			= $(this).attr('like'),
			commentid 		= $(this).attr('commentid'),
			commentlikes 	= parseInt($(this).next('.commentvotecount').text()),
			link 			= $(this);

		// User liked it
		if ( type == 'like' ) {
			$(this).next('.commentvotecount').text(commentlikes + 1);

			link.attr('href', '/unlikecomment/' + commentid);

			link.attr('like', 'unlike');

			link.find('span.comment-vote').removeClass('sprite-commentunliked');
			link.find('span.comment-vote').addClass('sprite-commentliked');

		} else {
			$(this).next('.commentvotecount').text(commentlikes - 1);

			link.attr('href', '/likecomment/' + commentid);

			link.attr('like', 'like');

			link.find('span.comment-vote').addClass('sprite-commentunliked');
			link.find('span.comment-vote').removeClass('sprite-commentliked');
		}

		/**
		 * Request the backend
		 */
		$.ajax({
			url: url,
		})
		.done(function() {
			$('#comment-' + commentid + ' .error-message').html('');
			link.removeClass('requesting');

			// Update pushstate
			updatePushstate();

			// GA push
			ga('send', 'event', 'comment-like', 'click', url);
		})
		.fail(function(data) {
			$('#comment-' + commentid + ' .error-message').html(JSON.parse(data.responseText));

			// Alter the like link
			link.next('.commentvotecount').text(Math.abs(commentlikes));

			link.attr('href', '/likecomment/' + commentid);

			link.attr('like', 'like');

			link.find('span.comment-vote').addClass('sprite-commentunliked');
			link.find('span.comment-vote').removeClass('sprite-commentliked');

			link.removeClass('requesting');
		});
	});
}

$(function() {
	likeComment();
});


/**
 * User tracks, comments, likes tabs
 */
function userTabsSwitch() {
	$('#user-likes-selector span').click(function(event) {
		event.preventDefault();

		// Set the active tab
		$('#user-likes-selector span').removeClass('active');
		$(this).addClass('active');

		// Hide all content
		$('#tracksroll, #commentsroll, #likesroll').hide();

		if ($(this).attr('id') == 'showcomments') {
			$('#commentsroll').show();
		} else if ($(this).attr('id') == 'showtracks') {
			$('#tracksroll').show();
		} else {
			$('#likesroll').show();
		}
	});
}

$(function() {
	userTabsSwitch();
});


/**
 * Sidebar navigation tabs
 */
function updateSidebarContent() {

	$('a.tracklink, a.userlink, a.regionlink').click(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		var url = $(this).attr('href');

		/**
		 * Zoom track links to position on map
		 */
		if ($(this).hasClass('tracklink') || $(this).hasClass('regionlink')) {
			var lat = $(this).attr('lat'), lng = $(this).attr('lng'), zoom = $(this).attr('zoom');

			// Zoom to inital marker
			if (typeof lat !== 'undefined' && typeof lng !== 'undefined' && typeof zoom  !== 'undefined') {
				map.setView(
					new L.LatLng(lat, lng),
					zoom,
					{ animate: true, zoom: { animate: true } }
				);
			}

			// Don't request data if region link (only map scroll)
			if ($(this).hasClass('regionlink')) {
				return false;
			}
		}


		/**
		 * Track links
		 */
		if ($(this).hasClass('tracklink')) {
			var youtubeid = $(this).attr('youtubeid'),
				title 	  = $(this).attr('title');

			if (typeof title !== 'undefined') {
				var embed = 'src="//www.youtube.com/embed/' + youtubeid + '?showinfo=0&amp;rel=0&amp;autoplay=1&amp;modestbranding=1&amp;iv_load_policy=3&amp;autohide=1"';

				var content = '<div class="youtube-wrapper"><iframe ' + embed  + ' frameborder="0" allowfullscreen class="youtubeembed"></iframe></div>';
				content += '<h1>' + title + '</h1>';
				content += loading;
			} else {
				var content = loading;
			}

			$('#main').html(content);

			// Change view to current
			$('#sidebar .main-sidebars').hide();
			$('#main').slideDown('slow');
			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.main').addClass('active');

			$.ajax({
				url: url,
			})
			.done(function(data) {
				$('#main .loading').replaceWith(data);

				/**
				 * Rerun sidebar init functions
				 */
				 initiateSidebar();

				// Is title isn't set
				if (typeof title == 'undefined') {
					var title = $('#main h1').text();
				}

				url = url.split("?")[0]; // Remove any url args

				 /**
				 * Add html5 pushstate - Goodbye IE
				 */
				window.history.pushState({
					'url': url,
					'title': title,
					'data': $('#main').html()
				}, title, url);

				// Set document title
				document.title = title;

				// GA push
				ga('send', 'event', 'sidebar-link', 'click', title);
			})
			.fail(function() {
				$('#main .loading').replaceWith('<div class="error-message"><p>Whoops, an error has happend. Try again.</p></div>');
			});
		}

		/**
		 * User links
		 */
		if ($(this).hasClass('userlink')) {
			var userTag   = $(this).next('.user-tag').text(),
				title 	  = $(this).attr('title');

			if (typeof title !== 'undefined') {
				var content = '<h1 class="user-title">' + title + ' <span class="user-tag">' + userTag + '</span></h1>';
					content += loading;
			} else {
				var content = loading;
			}

			$('#main').html(content);

			// Change view to current
			$('#sidebar .main-sidebars').hide();
			$('#main').slideDown('slow');
			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.main').addClass('active');

			$.ajax({
				url: url,
			})
			.done(function(data) {
				$('#main .loading').replaceWith(data);

				/**
				 * Rerun sidebar init functions
				 */
				 initiateSidebar();

				// Is title isn't set
				if (typeof title == 'undefined') {
					var title = $('#main h1').text();
				}

				url = url.split("?")[0]; // Remove any url args

				 /**
				 * Add html5 pushstate - Goodbye IE
				 */
				window.history.pushState({
					'url': url,
					'title': title,
					'data': $('#main').html()
				}, title, url);

				// Set document title
				document.title = title;

				// GA push
				ga('send', 'event', 'sidebar-link', 'click', title);
			})
			.fail(function() {
				$('#main .loading').replaceWith('<div class="error-message"><p>Whoops, an error has happend. Try again.</p></div>');
			});
		}
	});
}

$(function() {
	updateSidebarContent();

	/**
	 * Clear pushstate history on load
	 */
	window.history.length = 0;

	window.history.replaceState({
		'url': document.location.pathname,
		'data': $('#main').html(),
		'title': document.title
	}, document.title, document.location.pathname);

	/**
	 * Add html5 pushstate event motherfuckers
	 */
	window.addEventListener("popstate", function(e) {
		// URL location
		var location = document.location.pathname;

		// state
		var state = e.state;

		/**
		 * On inital load
		 */
		if (!state) {
			window.history.replaceState(state, document.title, window.location.pathname);
			return;
		}

		/**
		 * The various shown div
		 */
		if (state.url === '/genres') {
			$('#sidebar .main-sidebars').hide();

			$('#genre-sidebar').slideDown('slow');

			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.genre-sidebar').addClass('active');
		} else if (state.url === '/hot') {
			$('#sidebar .main-sidebars').hide();

			$('#hot-sidebar').slideDown('slow');

			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.hot-sidebar').addClass('active');
		} else if (state.url === '/about') {
			$('#sidebar .main-sidebars').hide();

			$('#about-sidebar').slideDown('slow');

			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.about-sidebar').addClass('active');
		} else {
			$('#sidebar .main-sidebars').hide();

			$('#main').slideDown('slow');

			$('#sidebartabs a').removeClass('active');
			$('#sidebartabs a.main').addClass('active');

			$('#main').html(state.data); // Add the data

			// Zoom to track on map if lat/lng available
			var trackLat = $('#main #track-lat-lng').attr('lat'),
				trackLng = $('#main #track-lat-lng').attr('lng');

			if (typeof trackLat !== 'undefined' && typeof trackLng !== 'undefined') {
				// Zoom to inital marker
				map.setView(
					new L.LatLng(trackLat, trackLng),
					7,
					{ animate: true, zoom: { animate: true } }
				)
			}
		}

		// Update page title
		document.title = state.title;

		initiateSidebar(); // Initiate various
	});
});


/**
 * Update an exisiting pushstate, e.g. when ajax content has been added like or voting
 */
function updatePushstate() {
	window.history.replaceState({
		'url': document.location.pathname,
		'data': $('#main').html(),
		'title': document.title
	}, document.title, document.location.pathname);
}

/**
 * Show hide share links
 */
function showHideShare() {
	$('#sidebar .share-link').click(function(event) {
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();

		$('.share-links').toggle('fast');
	});
}
$(function() {
	showHideShare();
});

/**
 * Run after new content
 */
function initiateSidebar() {

	updateSidebarContent();
	userTabsSwitch();
 	likeComment();
	showHideComments();
	likeTrack();
	saveComment();

	showHideShare(); // Share toogle

	getUserEditForm(); // User edit link

	getTrackEditForm(); // Track edit link
}