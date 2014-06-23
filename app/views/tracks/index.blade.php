@extends('layouts.scaffold')

@if(Request::path() == '/')
    @section('title') Discover Music You Didn't Know Yet | @stop

@elseif (Request::path() == 'hot')
	@section('title') Hottest Tracks from Around the World | @stop

@elseif (Request::path() == 'genres')
	@section('title') Hottest Tracks from Each Genre | @stop

@elseif (Request::path() == 'about')
	@section('title') Go Beyond Mainstream Music and Explore the Depths of Global Music | @stop

@endif


@section('meta')

<meta itemprop="name" content="Discover the Unknown Music of the World">
<meta name="twitter:title" content="Discover the Unknown Music of the World">
<meta property="og:title" content="Discover the Unknown Music of the World">
<meta name="twitter:card" content="summary">

<meta name="description" content="Go beyond mainstream music and explore the true depths of global music. mapstr.co is a free and easy tool for discovering new global music.
">
<meta itemprop="description" content="Go beyond mainstream music and explore the true depths of global music. mapstr.co is a free and easy tool for discovering new global music.
">
<meta property="og:description" content="Go beyond mainstream music and explore the true depths of global music. mapstr.co is a free and easy tool for discovering new global music.
">
<meta name="twitter:description" content="Go beyond mainstream music and explore the true depths of global music. mapstr.co is a free and easy tool for discovering new global music.
">

<meta itemprop="image" content="http://mapstr.co/img/logo.jpg">
<meta name="twitter:image" content="http://mapstr.co/img/logo.jpg">
<meta property="og:image" content="http://mapstr.co/img/logo.jpg">

<meta property="og:site_name" content="mapstr.co">
<meta property="og:url" content="{{ Request::url() }}">

@stop

@section('main')
	
<h1 class="frontpage-box">
	Latest track from <span class="country">{{ $track->country }}</span> in {{ HTML::regions($track->region) }} shared by 
	@if( isset($track->user->name) )
	    <a href="/users/{{ $track->user->id }}" class="userlink" title="{{{ $track->user->name }}}">{{{ $track->user->name }}}</a>

	    @if($track->user->title)
	        <span class="user-tag hidden">{{{ $track->user->title }}}</span>
	    @endif
	@else
		Anonymous
	@endif
</h1>

<div class="youtube-wrapper">
	<iframe src="//www.youtube.com/embed/{{ $track->youtubeid }}?showinfo=0&amp;rel=0&amp;modestbranding=1&amp;iv_load_policy=3&amp;autohide=1" frameborder="0" allowfullscreen></iframe>
</div>


<h1>{{{ $track->title }}}</h1>

<footer class="author">
	@if( isset($track->user->name) )
	    <a href="/users/{{ $track->user->id }}" class="userlink" title="{{{ $track->user->name }}}">{{{ $track->user->name }}}</a>
	    
	    @if($track->user->title)
	        <span class="user-tag">{{{ $track->user->title }}}</span>
	    @endif
	@else
		Anonymous
	@endif

	&mdash;

	<span class="date" title="{{ $track->created_at }}">{{ date("M, Y", strtotime($track->created_at)) }}</span>
	
	&mdash;

	{{ $track->genre }} from <span class="country">{{ $track->country }}</span> in {{ HTML::regions($track->region) }}

	@if(Auth::check() && Auth::user()->id == $track->user_id)
	    &mdash;

		<a href="/tracks/{{ $track->id }}/edit" title="Edit track" id="edit-track">Edit</a>
	@endif
</footer>

<div class="tracklike">
	<div class="error-message"></div>
	
	@if( ! $liked  )
	    <a href="/liketrack/{{ $track->id }}" like="like" trackid="{{ $track->id }}" class="liketrack">
	    	<span class="sprite-trackunliked"></span>
	    </a>
	@else
		<a href="/unliketrack/{{ $track->id }}" like="unlike" trackid="{{ $track->id }}" class="liketrack">
			<span class="sprite-trackliked"></span>
		</a>
	@endif

	@if( $track->up != 1)
	    <span class="tracklikes">{{ $track->up }}</span> likes
	@else
		<span class="tracklikes">{{ $track->up }}</span> like    
	@endif

	{{ Misc::share('tracks/' . $track->id) }}
</div>


	
<div id="commentsform">
	{{ Form::open(array('route' => 'comments.store')) }}
		<div class="error-message"></div>
		
		{{ Form::textarea('body', null, ['placeholder' => 'Add a note (max 200 characters)', 'rows' => 2, 'maxlength' => 200]) }}

		{{ Form::text('track_id', $track->id, ['hidden' => 'hidden']) }}
		
		{{ Form::submit('Save', array('class' => 'btn btn-info')) }}
	{{ Form::close() }}
</div>

<div id="comment-likes-selector">
	<span id="showcomments" class="active span-buttons"><span class="sprite-comments"></span> (<span class="number">{{ count($track->comments) }}</span>)</span>

	<span id="showlikes" class="span-buttons"><span class="sprite-likes"></span> (<span class="number">{{ count($track->likes) }}</span>)</span>
</div>


<div id="commentsroll">
	@if( isset($track->comments[0]) )
		
	    @foreach($track->comments as $comment)

	       	@include ('comments.show', compact('comment'))
	    
	    @endforeach
	
	@else
		
		<p class="none-comments">No notes yet... be the first...</p>
	
	@endif

	{{ HTML::adsense('comment') }}

</div>

<div id="likesroll">
	@if( isset($track->likes[0]) )

	    @foreach($track->likes as $like)

	       	@include ('likes.show', compact('like'))
	    
	    @endforeach

	@else

		<p class="none-likes">No likes yet... be the first...</p>	    
	
	@endif

	{{ HTML::adsense('like') }}
</div>

<div id="track-lat-lng" class="hidden" lat="{{ $track->lat }}" lng="{{ $track->lng }}" zoom="7"></div>

@stop
