<div id="usercontrol" class="menu-buttons" user-id="{{ $user->id }}">
	<a href="/users/{{ $user->id }}" title="{{{ $user->name }}}" class="userlink">
		<span class="sprite-user"></span>
		{{{ $user->name }}}
	</a>

	@if($user->title)
	    <span class="user-tag hidden"> {{{ $user->title }}}</span>
	@endif
</div>