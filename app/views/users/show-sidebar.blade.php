
@if(Input::get('type') === 'full' || Request::isMethod('patch'))
	@if($user->title)
	    <h1 class="user-title">{{{ $user->name }}} <span class="user-tag"> {{{ $user->title }}}</span></h1>
	@else
		<h1 class="user-title">{{{ $user->name }}}</h1>
	@endif
@endif

@if($user->region && $user->country && $user->gender)
	<footer class="user-info">
		@if($user->gender && $user->gender != 'other')
		    A {{ $user->gender }}
		@else 
			A user
		@endif

		<span class="country">from {{ $user->country }}</span>

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
				<!-- <span class="date" title="{{ $track->created_at }}">{{ date("j M, Y", strtotime($track->created_at)) }}</span> -->
		    </article>
		
	    @endforeach
	
	@else
		
		<p>No tracks yet...</p>
	
	@endif

	{{ HTML::adsense('track') }}
</div>

<div id="commentsroll" class="hidden">
	@if( isset($user->comments[0]) )

	    @foreach($user->comments as $comment)
	    	<article class="item">
	    		{{ Misc::markup($comment->body) }}

	    		&mdash;

	    		<a href="/tracks/{{ $comment->track_id }}" class="tracklink" lat="{{ $comment->track->lat }}" lng="{{ $comment->track->lng }}" title="{{{ $comment->track->title }}}" youtubeid="{{{ $comment->track->youtubeid }}}" zoom="7">View</a> 

	    		<div class="comment-listing-meta">
	    			@if( $comment->up != 1 )
			    		<span class="sprite-likes"></span> {{ $comment->up }} likes
			    	@else
			    		<span class="sprite-likes"></span> {{ $comment->up }} like
			    	@endif

				    &mdash;

					<span class="date" title="{{ $comment->created_at }}">{{ date("j M, Y", strtotime($comment->created_at)) }}</span>
				
	    		</div>

	    	</article>
	    
	    @endforeach
	
	@else
		
		<p class="none-comments">No notes yet...</p>
	
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
			    			<img src="http://img.youtube.com/vi/{{ $like->track->youtubeid }}/default.jpg" class="youtubethumb" >

			    			<span class="text-cutter">{{{ $like->track->title }}}</span>
			    		</a>
			    	</h2>

			    	@if( $like->track->up != 1 )
			    		<span class="sprite-likes"></span> {{ $like->track->up }} likes
			    	@else
			    		<span class="sprite-likes"></span> {{ $like->track->up }} like
			    	@endif

			    	&mdash;

					<span class="date" title="{{ $like->track->created_at }}">{{ date("j M, Y", strtotime($like->track->created_at)) }}</span>

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