@extends('layouts.scaffold')

@section('main')

<h1>All Likes</h1>

<p>{{ link_to_route('likes.create', 'Add new like') }}</p>

@if ($likes->count())
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>User_id</th>
				<th>Track_id</th>
				<th>Comment_id</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($likes as $like)
				<tr>
					<td>{{{ $like->user_id }}}</td>
					<td>{{{ $like->track_id }}}</td>
					<td>{{{ $like->comment_id }}}</td>
                    <td>{{ link_to_route('likes.edit', 'Edit', array($like->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('likes.destroy', $like->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no likes
@endif

@stop
