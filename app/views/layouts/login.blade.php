<a href="#" id="signup" class="menu-buttons">
	<span id="signinbutton"><span class="sprite-user"></span> Sign up or sign in </span>
</a>
<div class="control-addition" id="signups">
	<span class="arrow-up"></span>

	<span href="#" id="signuplink" class="active signup-tabs">Sign up</span>
	<span href="#" id="signinlink" class="signup-tabs">Sign in</span>

	<div id="signupform">
		{{ Form::open(array('route' => 'users.store')) }}
			<div class="error-message"></div>
		    {{ Form::text('name', null, ['placeholder' => 'Name', 'maxlength' => 50, 'required' => 'required']) }}

		    {{ Form::text('mail', null, ['placeholder' => 'Mail', 'required' => 'required']) }}

		    {{ Form::text('goaway', null, ['id' => 'go-away']) }}

		    {{ Form::password('password', ['placeholder'=>'Password', 'required' => 'required']) }}
		    
		    {{ Form::submit('Sign up', array('class' => 'btn submit-btn')) }}
		{{ Form::close() }}
	</div>

	<div id="signinform">
		{{ Form::open(array('url' => 'login')) }}
			<div class="error-message"></div>
		    {{ Form::text('mail', null, ['placeholder' => 'Mail', 'required' => 'required']) }}

			    {{ Form::password('password', ['placeholder' => 'Password', 'required' => 'required']) }}
		    
		    {{ Form::submit('Sign in', array('class' => 'btn submit-btn')) }}
		{{ Form::close() }}
	</div>

	<a href="<?= Social::login('facebook') ?>" title="Sign in with Facebook" class="social-login"><span class="sprite-fblogin"></span></a>

	<a href="<?= Social::login('google') ?>" title="Sign in with Google" class="social-login"><span class="sprite-googlelogin"></span></a>
</div>