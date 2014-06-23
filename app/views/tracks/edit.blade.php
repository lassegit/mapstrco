<div id="track-edit-form">
	{{ Form::model($track, array('method' => 'PATCH', 'route' => array('tracks.update', $track->id))) }}
		<div id="popup-preview">
			<img class="preview-thumb" src="http://img.youtube.com/vi/{{ $track->youtubeid }}/default.jpg">
			<p>{{{ $track->title }}}</p>
		</div>

		<div class="error-message"></div>

		{{ Form::text('url', null, ['placeholder' => 'Youtube link, e.g. http://www.youtube.com/watch?v=5u8Xk2MJUGs', 'autocomplete' => 'off', 'required' => 'required']) }}
	    
	    {{ Form::textarea('title', Input::old('body'), ['placeholder' => 'Track title (max 250 charaters)', 'autocomplete' => 'off', 'maxlength' => 255, 'rows' => 5, 'required' => 'required']) }}

	    {{ Track::select('genre', $track->genre) }}
	    
	    {{ Track::select('region', $track->region) }}
	    
	    {{ Track::select('country', $track->country) }}

	    {{ Form::hidden('youtubeid') }}
    	{{ Form::hidden('duration') }}
    	{{ Form::hidden('lat') }}
    	{{ Form::hidden('lng') }}
    	
	    {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
	{{ Form::close() }}
</div>
