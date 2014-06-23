<article id="comment-{{ $comment->id }}" class="comment" itemprop="review" itemscope itemtype="http://schema.org/Review">
	<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="hidden">
		<meta itemprop="ratingValue" content="{{ $comment->up }}">
		<meta itemprop="bestRating" content="{{ $comment->up }}">
    </div>

	<p class="comment-author">

		<a href="/users/{{ $comment->user_id }}" class="userlink" title="{{{ $comment->user['name'] }}}" itemprop="author">
			<span class="sprite-user"></span> 
			{{{ $comment->user['name'] }}}
		</a>

		@if($comment->user->title)
		    <span class="user-tag">{{{ $comment->user->title }}}</span>
		@endif

		&mdash;

		<span class="date" title="{{ $comment->created_at }}" itemprop="datePublished">
			{{ date("d. M, Y", strtotime($comment->created_at)) }}
		</span>
	</p>

	<p class="comment-body" itemprop="reviewBody">{{ Misc::markup($comment->body) }}</p>

	<div class="error-message"></div>

	<footer class="comment-like">
		@if(Auth::check())
		    @if( $comment->like )
				<a href="/unlikecomment/{{ $comment->id }}" like="unlike" commentid="{{ $comment->id }}">
					<span class="sprite-commentliked comment-vote"></span>
				</a>
			@else
				<a href="/likecomment/{{ $comment->id }}" like="like" commentid="{{ $comment->id }}">
					<span class="sprite-commentunliked comment-vote"></span>
				</a>
			@endif
		@else
			<a href="/likecomment/{{ $comment->id }}" like="like" commentid="{{ $comment->id }}">
				<span class="sprite-commentunliked comment-vote"></span>
			</a>
		@endif
		
		
		@if( $comment->up != 1 )
		    <span class="commentvotecount">{{ $comment->up }}</span> likes
		@else
			<span class="commentvotecount">{{ $comment->up }}</span> like
		@endif
		
	</footer>
</article>

