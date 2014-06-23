<?php
/**
 * Social site authentification
 */
class SocialAuthController extends BaseController {

	/**
	 * Facebook login.
	 */
	public function facebookLogin() 
	{
		if ( Social::check('facebook') && ! Auth::check()) 
		{
			$facebook_user = Social::facebook('user');

			/**
			 * See if the email/user already exists
			 */
			$user = User::where('mail', '=', $facebook_user->email)->first();

			if ( ! empty( $user ) ) 
			{
				/**
				 * Login user
				 */
				Auth::login($user, true);

				return Redirect::to('/');
			}

			else
			{
				/**
				 * Just set a random password
				 */
				$pass = Str::random(10);

				/**
				 * Create new user
				 */
				$user 			= new User();
				$user->name 	= $facebook_user->name;
				$user->mail 	= $facebook_user->email;
				$user->gender 	= in_array($facebook_user->gender, User::$gender) ? $facebook_user->gender : null;
				$user->password = Hash::make( $pass ); // Generate random password string
				$user->save();

				if (Auth::attempt(['mail' => $facebook_user->email, 'password' => $pass], true)) {
					return Redirect::to('/');				
				}
			}
		}

		return Response::view('errors.404', [], 404);
	}

	/**
	 * Google login.
	 */
	public function googleLogin()
	{
		if ( Social::check('google') && ! Auth::check())
		{
			$google_user = Social::google('user');

			/**
			 * See if the email/user already exists
			 */
			$user = User::where('mail', '=', $google_user->email)->first();
			
			if ( ! empty( $user ) ) 
			{
				/**
				 * Login user
				 */
				Auth::login($user, true);

				return Redirect::to('/');
			}

			else
			{
				/**
				 * Explode the username out of Google
				 */
				if (isset($google_user->name) && ! empty($google_user->name)) {
					$name = $google_user->name;
				} else {
					$name_email = explode('@', $google_user->email);

					$name = $name_email[0];
				}
				

				/**
				 * Just set a random password
				 */
				$pass = Str::random(10);

				/**
				 * Create new user
				 */
				$user 			= new User();
				$user->name 	= $name;
				$user->gender 	= in_array($google_user->gender, User::$gender) ? $google_user->gender : null;
				$user->mail 	= $google_user->email;
				$user->password = Hash::make( $pass ); // Generate random password string
				$user->save();

				if (Auth::attempt(['mail' => $google_user->email, 'password' => $pass], true)) {
					return Redirect::to('/');
				}
			}
		}

		return Response::view('errors.404', [], 404);
	}
}