<p id="track-like-{{ $like->user_id }}" class="likedby">
	<span class="sprite-commentliked"></span>

	<a href="/users/{{ $like->user->id }}" class="userlink" title="{{{ $like->user->name }}}">
		{{{ $like->user->name }}}
	</a> liked this

	@if($like->user->title)
	    <span class="user-tag hidden"> {{{ $like->user->title }}}</span>
	@endif 

	&mdash;

	<span class="date" title="{{ $like->created_at }}">{{ date("d. M, y", strtotime($like->created_at)) }}.</span>
</p>

