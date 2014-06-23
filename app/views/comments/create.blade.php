@extends('layouts.scaffold')

@section('main')

<h1>Create Comment</h1>

{{ Form::open(array('route' => 'comments.store')) }}
	<ul>
        <li>
            {{ Form::label('body', 'Body:') }}
            {{ Form::textarea('body') }}
        </li>

        <li>
            {{ Form::label('track_id', 'Track_id:') }}
            {{ Form::input('number', 'track_id') }}
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


