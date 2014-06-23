@extends('layouts.scaffold')

@section('main')

<h1>Create Like</h1>

{{ Form::open(array('route' => 'likes.store')) }}
	<ul>
        <li>
            {{ Form::label('user_id', 'User_id:') }}
            {{ Form::input('number', 'user_id') }}
        </li>

        <li>
            {{ Form::label('track_id', 'Track_id:') }}
            {{ Form::input('number', 'track_id') }}
        </li>

        <li>
            {{ Form::label('comment_id', 'Comment_id:') }}
            {{ Form::input('number', 'comment_id') }}
        </li>

		<li>
			{{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop


