<?php

class Comment extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'body' => 'required',
		'track_id' => 'required'
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

	public function likes()
	{
		return $this->hasMany('Like')->orderBy('id', 'ASC');
	}

	public function like()
	{
		return $this->hasOne('Like')->where('user_id', Auth::user()->id);
	}

	/**
	 * Calculate hotness
	 * @return [float] [The recalculated hotness]
	 */
	public function hotness()
	{
		// Calculate the new hotness
		$order = log(max(abs( $this->up ), 1), 10);

		$sign = ($this->up > 0) ? 1.001 : 1;
		
		$seconds = date('U', strtotime($this->created_at)) - 1134028003;

		return round($order + (($sign * $seconds)/45000), 7);
		// return round( ($sign * $order + $seconds) / 45000, 7);
	}
}
