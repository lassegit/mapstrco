<!DOCTYPE html>
<html>
<head lang="en">
	<meta name="MobileOptimized" content="width">
	<meta name="HandheldFriendly" content="true">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="cleartype" content="on">
	<meta charset="utf-8">
	@yield('meta')
	<title> @yield('title') Easiest Way to Explore New Global Music | mapstr.co</title>

	{{ HTML::style('style.min.css?v=15') }}
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

<section id="map-wrapper">
	<div id="controls">

		<a href="" id="add-song" class="menu-buttons">
			<img src="/img/newmarker.png"> 
			<!-- <span class="text">Enable music adding...</span> -->
			<span class="text">Add favorite local song</span>
			<div class="control-addition" id="add-song-help">
				<span class="arrow-up"></span>
				<ul>
					<li>Click the map where the song is from.</li>
					<li>Fill in the popup form.</li>
					<li>Save.</li>
				</ul>
			</div>
		</a>

		@if( Auth::check() )
			@include ('users.loggedin')
		@else
			@include ('layouts.login')
		@endif
	</div>

	<?php 
		$url = Request::path(); // Set hidden classes depending on url 
		$non_current = ['hot', 'genres', 'about'];
	?>

	<div id="sidebartabs">
		<a href="/" title="" class="sidebartabs-link main {{ ! in_array($url, $non_current) ? 'active' : ''; }}" show="main">Current</a>

		<a href="/hot" title="" class="sidebartabs-link hot-sidebar{{ $url === 'hot' ? ' active ' : ''; }}" show="hot-sidebar">Hot</a>
		
		<a href="/genres" title="" class="sidebartabs-link genre-sidebar{{ $url === 'genres' ? ' active' : ''; }}" show="genre-sidebar">Genre</a>
		
		<a href="/about" title="" class="sidebartabs-link about-sidebar{{ $url === 'about' ? ' active' : ''; }}" show="about-sidebar">About</a>
	</div>

	<div id="map"></div>

	<a href="#" title="Find a specific region" id="compass-link">
		<span class="sprite-compass"></span>
	</a>

	<div id="region-selector">
		<span class="compass-arrow"></span>
		<a href="#" class="region-link" lat="40.0850925" lng="-96.9514821" zoom="4">North America</a>
		<a href="#" class="region-link" lat="-4.1089732" lng="-78.8460133" zoom="4">Latin America &amp; Carribean</a>
		<a href="#" class="region-link" lat="54.6267983" lng="12.9407135" zoom="4">Europe</a>
		<a href="#" class="region-link" lat="32.700419"  lng="16.1926666" zoom="4">Mid East &amp; North Africa</a>
		<a href="#" class="region-link" lat="-8.1397107" lng="24.1028229" zoom="4">Sub-saharan Africa</a>
		<a href="#" class="region-link" lat="18.5900301" lng="77.979776" zoom="4">South Asia</a>
		<a href="#" class="region-link" lat="18.6108551" lng="118.8049713" zoom="4">East Asia &amp; Pacific</a>
	</div>

	<a href="#" title="Latest shared tracks" id="latest-tracks">
		<span class="sprite-star"></span>
	</a>

	<div id="latest-tracks-selector">
		<span class="compass-arrow"></span>
		<div class="inner-selector">
			<h4>Latest shared tracks</h4>

			<div class="loading"><span class="loading-text">Getting latest tracks</span> <img src="/img/loading.gif"></div>

			<div id="latest-tracks-content"></div>
		</div>

	</div>

	<a href="#" title="Latest comments" id="latest-comments">
		<span class="sprite-latecomment"></span>
	</a>

	<div id="latest-comments-selector">
		<span class="compass-arrow"></span>
		<div class="inner-selector">
			<h4>Latest comments</h4>

			<div class="loading"><span class="loading-text">Getting latest comments</span> <img src="/img/loading.gif"></div>

			<div id="latest-comments-content"></div>
		</div>
	</div>


	<div id="progress"><div id="progress-bar"></div></div>

	<div id="total-tracks">
		<a href="/" title="Reload the page to get the latest tracks">Refresh tracks</a>
	</div>

</section>

<section id="sidebar">
	<article id="main" class="main-sidebars {{ in_array($url, $non_current) ? 'hidden' : ''; }}">
		@yield('main')
	</article>

	<article id="hot-sidebar" class="main-sidebars {{ $url !== 'hot' ? 'hidden' : ''; }}"></article>

	<article id="genre-sidebar" class="main-sidebars {{ $url !== 'genres' ? 'hidden' : ''; }}"></article>

	<article id="about-sidebar" class="main-sidebars {{ $url !== 'about' ? 'hidden' : ''; }}">
		@include ('layouts.about')
	</article>

</section>

{{ HTML::script('script.min.js?v=15') }}

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48577075-1', 'mapstr.co');
  ga('send', 'pageview');

</script>
</body>
</html>