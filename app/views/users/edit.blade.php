<div id="user-edit-form">
    {{ Form::model($user, array('method' => 'PATCH', 'route' => array('users.update', $user->id))) }}
        <div class="error-message"></div>
        {{ Form::text('name', Input::old('name'), ['placeholder' => 'Your user name', 'required' => 'required', 'maxlength' => 50]) }}

        {{ Form::text('title', Input::old('title'), ['placeholder' => 'Title or what you do (max 25 charaters)', 'maxlength' => 25]) }}
        
        {{ Form::textarea('body', Input::old('body'), ['placeholder' => 'About you text (max 250 charaters)', 'autocomplete' => 'off', 'maxlength' => 255, 'rows' => 3]) }}

        {{ User::select('gender', $user->gender) }}
        
        {{ User::select('region', $user->region) }}
        
        {{ User::select('country', $user->country) }}

        {{ Form::password('password', ['placeholder' => 'Fill only if you want to change password (min 3 charaters)']) }}

        {{ Form::submit('Save', array('class' => 'btn btn-info')) }}
    {{ Form::close() }}
</div>