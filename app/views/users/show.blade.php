@extends('layouts.scaffold')

@section('meta')

@if($user->title)
    <meta itemprop="name" content="{{{ $user->name }}} &mdash; {{{ $user->title }}}">
	<meta name="twitter:title" content="{{{ $user->name }}} &mdash; {{{ $user->title }}}">
	<meta property="og:title" content="{{{ $user->name }}} &mdash; {{{ $user->title }}}">
	<meta name="twitter:card" content="summary">
@else
	<meta itemprop="name" content="{{{ $user->name }}}">
	<meta name="twitter:title" content="{{{ $user->name }}}">
	<meta property="og:title" content="{{{ $user->name }}}">
	<meta name="twitter:card" content="summary">
@endif

@if($user->body)
    <meta name="description" content="{{{ $user->body }}}">
    <meta itemprop="description" content="{{{ $user->body }}}">
    <meta property="og:description" content="{{{ $user->body }}}">
    <meta name="twitter:description" content="{{{ $user->body }}}">
@else
 	<meta name="description" content="{{{ $user->name }}}">
 	<meta itemprop="description" content="{{{ $user->name }}}">
 	<meta property="og:description" content="{{{ $user->name }}}">
 	<meta name="twitter:description" content="{{{ $user->name }}}">
@endif
	<meta itemprop="image" content="http://mapstr.co/img/logo.jpg">
	<meta name="twitter:image" content="http://mapstr.co/img/logo.jpg">
	<meta property="og:image" content="http://mapstr.co/img/logo.jpg">	
	<meta property="og:site_name" content="mapstr.co" />
	<meta property="og:url" content="http://mapstr.co/users/{{ $user->id }}">
@stop

@if($user->title && $user->country)
    @section('title') {{ $user->name }} | {{ $user->title }} | {{ $user->country }} | @stop
@elseif ($user->country)
	@section('title') {{ $user->name }} | {{ $user->country }} | @stop
@elseif ($user->title)
	 @section('title') {{ $user->name }} | {{ $user->title }} | @stop
@else
	@section('title') {{ $user->name }} | @stop
@endif

@section('main')

<div itemscope itemtype="http://schema.org/Person" class="hidden">
	<meta itemprop="name" content="{{{ $user->name }}}">
	@if($user->title)
	    <meta itemprop="jobTitle" content="{{{ $user->title }}}">
	@endif

	@if($user->gender)
	    <meta itemprop="gender" content="{{ $user->gender }}">
	@endif

	@if($user->country)
		<meta itemprop="nationality" content="{{ $user->country }}">
	    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
	    	<meta itemprop="name" content="{{ $user->country }}">
			<meta itemprop="addressCountry" content="{{ $user->country }}">

			@if($user->region)
			    <meta itemprop="addressRegion" content="{{ $user->region }}">
			@endif
		</div>
	@endif
</div>

@if($user->title)
    <h1 class="user-title">{{{ $user->name }}} <span class="user-tag">{{{ $user->title }}}</span></h1>
@else
	<h1 class="user-title">{{{ $user->name }}}</h1>
@endif

@if($user->region && $user->country && $user->gender)
	<footer class="user-info">
		@if($user->gender && $user->gender != 'other')
		    A {{ $user->gender }}
		@else 
			A user
		@endif

		from <span class="country">{{ $user->country }}</span>

		<span>in {{ HTML::regions($user->region) }}</span>
	</footer>
@endif

@if($user->body)
	<div class="user-body">
		<p>{{ Misc::markup($user->body) }}</p>
	</div>
@endif

<div class="user-meta">
	<div class="user-error"></div>
	
	Member since: <span title="{{ $user->created_at }}">{{ date("j M, Y", strtotime($user->created_at)) }}</span>

	@if( Auth::check() && Auth::user()->id == $user->id)
	    &mdash;

	    <a href="/users/{{ $user->id }}/edit" title="Edit your profile" id="edit-user">edit</a>

		&mdash;
	
		<a href="/logout" title="Log out">log out</a>
	@endif

	{{ Misc::share('users/' . $user->id) }}
</div>

<div id="user-likes-selector">
	<span id="showtracks" class="active span-tabs"><span class="sprite-tracks"></span> ({{ count($user->tracks) }})</span>

	<span id="showcomments" class="span-tabs"><span class="sprite-comments"></span> ({{ count($user->comments) }})</span>

	<span id="showlikes" class="span-tabs"><span class="sprite-likes"></span> ({{ count($user->likes) }})</span>
</div>


<div id="tracksroll">
	@if( isset($user->tracks[0]) )

	    @foreach($user->tracks as $track)

		    <article class="item">
		    	<h2>
		    		<a href="/tracks/{{ $track->id }}" class="tracklink" lat="{{ $track->lat }}" lng="{{ $track->lng }}" title="{{{ $track->title }}}" youtubeid="{{{ $track->youtubeid }}}" zoom="7">
		    			<span class="thumbwrapper">
		    				<img src="http://img.youtube.com/vi/{{ $track->youtubeid }}/default.jpg" class="youtubethumb" >
		    			</span>

		    			<span class="text-cutter">{{{ $track->title }}}</span>
		    		</a>
		    	</h2>

		    	@if( $track->up != 1 )
		    		<span class="sprite-likes"></span> {{ $track->up }} likes
		    	@else
		    		<span class="sprite-likes"></span> {{ $track->up }} like
		    	@endif

		    	&mdash;

		    	<span class="genre">{{ $track->genre }}</span>

		    	<div itemprop="track" itemscope itemtype="http://schema.org/MusicRecording" class="hidden">
					<meta itemprop="name" content="{{{ $track->title }}}">
					<meta itemprop="url" content="{{ URL::to('tracks/' . $track->id) }}">
					<meta itemprop="duration" content="PT{{ floor($track->duration / 60) }}M{{ ( $track->duration - (floor($track->duration / 60) * 60) ) }}S">
					<meta itemprop="isFamilyFriendly" content="true">
					<meta itemprop="contentLocation" content="{{ $track->country }}">
					<meta itemprop="genre" content="{{ $track->genre }}">
					<meta thumbnailUrl="name" content="http://img.youtube.com/vi/{{ $track->youtubeid }}/default.jpg">

					<div itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating" class="hidden">
						<meta itemprop="name" content="{{{ $track->title }}}">
						<meta itemprop="ratingValue" content="{{ $track->up }}">
						<meta itemprop="ratingCount" content="{{ $track->up }}">
						<meta itemprop="reviewCount" content="{{ count($track->comments) }}">
					</div>
				</div>
		    </article>
		
	    @endforeach
	
	@else
		
		<p class="none-tracks">No tracks yet...</p>
	
	@endif

	{{ HTML::adsense('track') }}
</div>

<div id="commentsroll" class="hidden">

	@if( isset($user->comments[0]) )

	    @foreach($user->comments as $comment)
	    	<article class="item" itemprop="review" itemscope itemtype="http://schema.org/Review">
	    		<span itemprop="reviewBody">
	    			{{ Misc::markup($comment->body) }}
	    		</span>

	    		&mdash;

	    		<a href="/tracks/{{ $comment->track_id }}" class="tracklink" lat="{{ $comment->track->lat }}" lng="{{ $comment->track->lng }}" title="{{{ $comment->track->title }}}" youtubeid="{{{ $comment->track->youtubeid }}}" zoom="7">View</a> 

	    		<div class="comment-listing-meta">
	    			@if( $comment->up != 1 )
			    		<span class="sprite-likes"></span> {{ $comment->up }} likes
			    	@else
			    		<span class="sprite-likes"></span> {{ $comment->up }} like
			    	@endif

				    &mdash;

					<span class="date" title="{{ $comment->created_at }}" itemprop="datePublished">
						{{ date("j M, Y", strtotime($comment->created_at)) }}
					</span>
	    		</div>

	    		<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="hidden">
					<meta itemprop="ratingValue" content="{{ $comment->up }}">
					<meta itemprop="bestRating" content="{{ $comment->up }}">
			    </div>

	    	</article>
	    
	    @endforeach
	
	@else
		
		<p class="none-comments">No notes yet... be the first...</p>
	
	@endif

	{{ HTML::adsense('comment') }}
</div>

<div id="likesroll">
	@if( isset($user->likes[0]) )

	    @foreach($user->likes as $like)
	    	<article class="item">

		    	@if( $like->track_id )
		    	   <h2>
			    		<a href="/tracks/{{ $like->track->id }}" class="tracklink" lat="{{ $like->track->lat }}" lng="{{ $like->track->lng }}" title="{{{ $like->track->title }}}" youtubeid="{{{ $like->track->youtubeid }}}" zoom="7">
			    			<span class="thumbwrapper">
			    				<img src="http://img.youtube.com/vi/{{ $like->track->youtubeid }}/default.jpg" class="youtubethumb">
			    			</span>
			    			
			    			<span class="text-cutter">{{{ $like->track->title }}}</span>
			    		</a>
			    	</h2>

			    	<div class="item-meta">
			    		@if( $like->track->up != 1 )
				    		<span class="sprite-likes"></span> {{ $like->track->up }} likes
				    	@else
				    		<span class="sprite-likes"></span> {{ $like->track->up }} like
				    	@endif

				    	&mdash;

						<span class="date" title="{{ $like->track->created_at }}">{{ date("j M, Y", strtotime($like->track->created_at)) }}</span>
			    	</div>

		    	@elseif ( $like->comment_id )
		    		{{ Misc::markup($like->comment->body) }}

		    		&mdash;

		    		<a href="/tracks/{{ $like->comment->track_id }}" class="tracklink" lat="{{ $like->comment->track->lat }}" lng="{{ $like->comment->track->lng }}" title="{{{ $like->comment->track->title }}}" youtubeid="{{{ $like->comment->track->youtubeid }}}" zoom="7">View</a>
		    		
		    		<div class="comment-listing-meta">

			    		@if( $like->comment->up != 1 )
				    		<span class="sprite-likes"></span> {{ $like->comment->up }} likes
				    	@else
				    		<span class="sprite-likes"></span> {{ $like->comment->up }} like
				    	@endif

				    	&mdash;

						<span class="date" title="{{ $like->comment->created_at }}">{{ date("j M, Y", strtotime($like->comment->created_at)) }}</span>
					</div>
		    	@endif
		    </article>
	    
	    @endforeach

	@else

		<p class="none-likes">No likes yet...</p>	    
	
	@endif

	{{ HTML::adsense('like') }}
</div>

@stop
