@extends('layouts.scaffold')

@section('main')

<h1>Edit Like</h1>
{{ Form::model($like, array('method' => 'PATCH', 'route' => array('likes.update', $like->id))) }}
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
			{{ Form::submit('Update', array('class' => 'btn btn-info')) }}
			{{ link_to_route('likes.show', 'Cancel', $like->id, array('class' => 'btn')) }}
		</li>
	</ul>
{{ Form::close() }}

@if ($errors->any())
	<ul>
		{{ implode('', $errors->all('<li class="error">:message</li>')) }}
	</ul>
@endif

@stop
