<?php

class Track extends Eloquent {

	/**
	 * Genre enum list for tracks
	 */
	public static $genre = [
		'pop',
		'rock',
		'indie rock',
		'electronic',
		'jazz',
		'funk',
		'blues',
		'chillout',
		'folk',
		'R&B',
		'raggae',
		'rap & hip hop',
		'classical',
		'country',
		'concert',
		'other'
	];

	/**
	 * Region enum list for users
	 */
	public static $region = [
		'north america',
		'latin america & carribean',
		'europe',
		'mid east & north africa',
		'sub-saharan africa',
		'south asia',
		'east asia & pacific',
	];

	/**
	 * Country enum list for users
	 */
	public static $country = ['afghanistan','albania','algeria','andorra','angola','antigua & deps','argentina','armenia','australia','austria','azerbaijan','bahamas','bahrain','bangladesh','barbados','belarus','belgium','belize','benin','bhutan','bolivia','bosnia herzegovina','botswana','brazil','brunei','bulgaria','burkina','burundi','cambodia','cameroon','canada','cape verde','central african rep','chad','chile','china','colombia','comoros','congo','congo','costa rica','croatia','cuba','cyprus','czech republic','denmark','djibouti','dominica','dominican republic','east timor','ecuador','egypt','el salvador','equatorial guinea','eritrea','estonia','ethiopia','fiji','finland','france','gabon','gambia','georgia','germany','ghana','greece','grenada','guatemala','guinea','guinea-bissau','guyana','haiti','honduras','hungary','iceland','india','indonesia','iran','iraq','ireland','israel','italy','ivory coast','jamaica','japan','jordan','kazakhstan','kenya','kiribati','korea north','korea south','kosovo','kuwait','kyrgyzstan','laos','latvia','lebanon','lesotho','liberia','libya','liechtenstein','lithuania','luxembourg','macedonia','madagascar','malawi','malaysia','maldives','mali','malta','marshall islands','mauritania','mauritius','mexico','micronesia','moldova','monaco','mongolia','montenegro','morocco','mozambique','myanmar','namibia','nauru','nepal','netherlands','new zealand','nicaragua','niger','nigeria','norway','oman','pakistan','palau','palestine','panama','papua new guinea','paraguay','peru','philippines','poland','portugal','qatar','romania','russian federation','rwanda','st kitts & nevis','st lucia','saint vincent & the grenadines','samoa','san marino','sao tome & principe','saudi arabia','senegal','serbia','seychelles','sierra leone','singapore','slovakia','slovenia','solomon islands','somalia','south africa','south sudan','spain','sri lanka','sudan','suriname','swaziland','sweden','switzerland','syria','taiwan','tajikistan','tanzania','thailand','togo','tonga','trinidad & tobago','tunisia','turkey','turkmenistan','tuvalu','uganda','ukraine','united arab emirates','united kingdom','united states','uruguay','uzbekistan','vanuatu','vatican city','venezuela','vietnam','yemen','zambia','zimbabwe',
	];

	protected $softDelete = true;

	protected $guarded = array();

	public static $rules = array(
		'title' => 'required|max:255',
		'url' => 'required',
	);

	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function comments()
	{
		return $this->hasMany('Comment')->orderBy('hot', 'DESC')->with('user');
	}

	public function likes()
	{
		return $this->hasMany('Like')->orderBy('id', 'DESC');
	}

	public function liked()
	{
		if (Auth::check())
		{
			return $this->hasOne('Like')->where('user_id', Auth::user()->id)->first();
		}
		else
		{
			return null;
		}
	}

	/**
	 * Calculate hotness
	 * @return [float] [The recalculated hotness]
	 * See: https://gist.github.com/argakon/5244943
	 */
	public function hotness()
	{
		// Calculate the new hotness
		$order = log(max(abs( $this->up ), 1), 10);

		$sign = ($this->up > 0) ? 1.001 : 1;
		// $sign = ($this->up > 0) ? 1 : 0;

		$seconds = date('U', strtotime($this->created_at)) - 1134028003;

		return round($order + (($sign * $seconds)/45000), 7);
		// return round( ( $sign + $order * $seconds) / 45000, 7);
	}

	/**
	 * Set the array values equal to array keys
	 */
	public static function select($name, $selected = null)
	{
		switch ($name) {
			case 'genre':
				return Form::select($name, array_combine(Track::$genre, Track::$genre), ($selected ? $selected : ''), [
					'class' => 'chosen-select genre chosen-genre',
					'data-placeholder' => 'Pick the genre',
				]);
				break;
			case 'region':
				return Form::select($name, array_combine(Track::$region, Track::$region), ($selected ? $selected : ''), [
					'class' => 'chosen-select region chosen-region',
					'data-placeholder' => 'Pick the region',
				]);
				break;
			case 'country':
				return Form::select($name, array_combine(Track::$country, Track::$country), ($selected ? $selected : ''), [
					'class' => 'chosen-search-select country chosen-country',
					'data-placeholder' => 'Pick the country',
				]);
				break;
		}
	}

	/**
	 * Logged in users like status on comments
	 */
	public function commentsLike()
	{
		if (Auth::check() && ! $this->comments->isEmpty())
		{
			return $this->comments->load('Like');
		}
	}
}
