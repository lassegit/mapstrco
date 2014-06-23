<?php

class Like extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'user_id' => 'required',
		'track_id' => 'required',
		'comment_id' => 'required'
	);

	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function track()
	{
		return $this->belongsTo('Track');
	}

	public function comment()
	{
		return $this->belongsTo('Comment');
	}
}
