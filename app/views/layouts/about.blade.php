
<img src="/img/logo-small.jpg" class="top-image" alt="mapstr.co logo">

<h1>mapstr<span class="blue">.</span>co &mdash; explore the depths of global music</h1>

<p>mapstr<span class="blue">.</span>co enables you to go beyond mainstream music and explore the depths of global music. Here is what we offer:</p>

<ol>
	<li><strong>Free music</strong> exploration: Just enjoy the music</li>
	<li><strong>Easy music</strong> exploration: Just click the map</li>
	<li><strong>Custom music</strong> exploration: Browse by genre, region or country</li>
	<li><strong>Engaging music</strong> exploration: Share your own favorites</li>
</ol>

@if(! Auth::check())
    <div class="sidebar-signup">
		<h2>Sign in with Facebook or Google</h2>
		
		<a href="<?= Social::login('facebook') ?>" title="Sign in with Facebook" class="social-login"><span class="sprite-fblogin"></span></a>

		<a href="<?= Social::login('google') ?>" title="Sign in with Google" class="social-login"><span class="sprite-googlelogin"></span></a>
	</div>
@endif

<h2>HowTo share your music: Add track to map</h2>

<ol>
	<li>Click the <strong>"Enable music adding..."</strong> button in the top left of the map.</li>

	<li>Zoom and scroll to where your music should be added and <strong>click the map</strong>.</li>

	<li>A new music marker will appear with a pop up. <strong>Fill out the pop up</strong>, save and your are done.</li>
</ol>

<p>It is not necessary to be sign up to share music. However it is recommended because it allows you to keep track (pun intended) and edit your shared tracks afterwards.</p>

<p>Besides that it allows you to interact with other music lovers.</p>

<h2>Other</h2>

<p>mapstr<span class="blue">.</span>co is using a fair bit of cutting edge technology and can have some heavy client side computations, therefore is <strong>strongly recommended that you use a modern browser</strong>, like Chrome or Firefox. <a href="http://browsehappy.com/" target="_blank" title="Download a modern browser">You can get a modern browser here</a>.</p>

<p>Hope you enjoy mapstr<span class="blue">.</span>co.</p>
