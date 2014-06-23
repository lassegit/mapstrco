{{ Form::open(array('route' => 'tracks.store')) }}
    <div id="popup-preview"></div>
    {{ Form::text('url', null, ['placeholder' => 'Youtube link: http://www.youtube.com/watch?v=5u8Xk2MJUGs', 'autocomplete' => 'off']) }}
    
    {{ Form::textarea('title', null, ['placeholder' => 'Short track title (max 250 charaters)', 'autocomplete' => 'off', 'maxlength' => 255, 'rows' => 1]) }}
    
    {{ Track::select('genre') }}
    
    {{ Track::select('region') }}
    
    {{ Track::select('country') }}

    {{ Form::hidden('lat') }}
    {{ Form::hidden('lng') }}
    {{ Form::hidden('youtubeid') }}
    {{ Form::hidden('duration') }}
    <div class="error-message"></div>

    {{ Form::submit('Save', ['class' => 'btn btn-info', 'disabled' => 'disabled']) }}
{{ Form::close() }}
