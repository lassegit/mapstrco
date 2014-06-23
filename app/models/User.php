<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * Gender for enums
	 */
	public static $gender = ['male', 'female', 'other'];

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

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	public $timestamps = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	public static $rules = array(
		'name' 		=> 'required|min:3',
		'password' 	=> 'required|min:3',
		'mail' 		=> 'required|email|unique:users,mail',
		'goaway' 	=> 'max:0'
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function comments()
	{
		return $this->hasMany('Comment')->orderBy('hot', 'DESC');
	}

	public function tracks()
	{
		return $this->hasMany('Track')->orderBy('hot', 'DESC');
	}

	public function likes()
	{
		return $this->hasMany('Like')->orderBy('id', 'DESC');
	}

	public function like()
	{
		return $this->belongsTo('Like');
	}

	/**
	 * Set the array values equal to array keys
	 */
	public static function select($name, $selected = null)
	{
		switch ($name) {
			case 'gender':
				return Form::select($name, array_combine(User::$gender, User::$gender), ($selected ? $selected : ''), [
					'class' => 'chosen-select gender chosen-gender',
					'data-placeholder' => 'Pick the gender',
				]);
				break;
			case 'region':
				return Form::select($name, array_combine(User::$region, User::$region), ($selected ? $selected : ''), [
					'class' => 'chosen-select region chosen-region',
					'data-placeholder' => 'Pick the region',
				]);
				break;
			case 'country':
				return Form::select($name, array_combine(User::$country, User::$country), ($selected ? $selected : ''), [
					'class' => 'chosen-search-select country chosen-country',
					'data-placeholder' => 'Pick the country',
				]);
				break;
		}
	}

}