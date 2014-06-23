<?php

class UsersController extends BaseController {

	/**
	 * User Repository
	 *
	 * @var User
	 */
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Response::view('errors.404', [], 404);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return Response::view('errors.404', [], 404);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( Request::ajax() && ! Auth::check() )
		{
			$input = Input::all();
			$validation = Validator::make($input, User::$rules);

			if ($validation->passes())
			{
				$user = new User();
				$user->name = $input['name'];
				$user->mail = $input['mail'];
				$user->password = Hash::make( $input['password'] );
				$user->save();

				/**
				 * Login user
				 */
				if (Auth::attempt(['mail' => $input['mail'], 'password' => $input['password']], true))
				{
					return View::make('users.loggedin');
				}
			}

			else
			{
				$errors = $validation->errors()->getMessages();

				return Response::view('errors.form', ['errors' => $errors], 500);
			}
		}

		return Response::json('Already logged in.', 500);
	}

	/**
	 * Login the user
	 */
	public function login()
	{
		if ( Request::ajax() && ! Auth::check() )
		{
			if (Auth::attempt(['mail' => Input::get('mail'), 'password' => Input::get('password')], true))
			{
				return View::make('users.loggedin');
			}

			return Response::json('<p>Your email or password is incorrect. Try again.</p>', 403);
		}

		return Response::view('errors.403', [], 403);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = Cache::get('user' . $id);

		if ( ! $user )
		{
			$user = User::with('comments', 'likes', 'tracks', 'comments.track', 'likes.track', 'likes.comment')->findOrFail($id);

			Cache::put('user' . $id, $user, 5);
		}

		/**
		 * Return sidebar html if ajax
		 */
		if (Request::ajax())
		{
			return View::make('users.show-sidebar', compact('user'));
		}

		return View::make('users.show', compact('user'));
	}

	/**
	 * Logout the user.
	 */
	public function logout()
	{
		if (Auth::check())
		{
			// Clear user block from cache
			Cache::forget('userblock' . Auth::user()->id);

			Auth::logout();
		}

		return Redirect::to('/');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Request::ajax())
		{
			if (Auth::check())
			{
				$user = $this->user->find($id);

				if (is_null($user))
				{
					return Response::json('<p>Whoops, we did not find anything...</p>', 403);
				}

				if (Auth::user()->id == $user->id)
				{
					return View::make('users.edit', compact('user'));
				}

				return Response::json('<p>You are not this user.</p>', 403);
			}

			return Response::json('<p>Must be logged in to edit.</p>', 403);
		}

		return Response::view('errors.403', [], 403);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Request::ajax())
		{
			if (Auth::check())
			{

				$input = array_except(Input::all(), '_method');

				$rules = [
					'name' => 'required',
					'title' => 'max:25'
				];

				$validation = Validator::make($input, $rules);

				if ($validation->passes())
				{
					$user = User::find($id);

					if (Auth::user()->id == $user->id)
					{
						$user->name    = $input['name'];
						$user->title   = $input['title'];
						$user->body    = $input['body'];
						$user->gender  = $input['gender'];
						$user->region  = $input['region'];
						$user->country = $input['country'];

						// Update password if it is larger than 3 char
						if (isset($input['password']) && strlen($input['password']) > 3)
						{
							$user->password = Hash::make($input['password']);
						}
						$user->save();

						// Clear user cache
						Cache::forget('user' . $user->id);
						Cache::forget('userblock' . $user->id); // The user block

						$user = User::with('comments', 'likes', 'tracks', 'comments.track', 'likes.track', 'likes.comment')->findOrFail($id);

						Cache::put('user' . $id, $user, 5);

						return View::make('users.show-sidebar', compact('user'));
					}

					return Response::json('You are not this user.', 403);
				}

				else
				{
					$errors = $validation->errors()->getMessages();

					return Response::view('errors.form', ['errors' => $errors], 500);
				}
			}

			return Response::json('Must be logged in to save.', 403);
		}

		return Response::view('errors.403', [], 403);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return Response::view('errors.404', [], 404);
	}
}
