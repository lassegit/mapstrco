<?php

class TracksController extends BaseController {

	/**
	 * Track Repository
	 *
	 * @var Track
	 */
	protected $track;

	public function __construct(Track $track)
	{
		$this->track = $track;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$track = Cache::get('front');

		if ( empty($track) ) 
		{
			$track = Track::with('user', 'comments', 'likes', 'likes.user')->orderBy('hot', 'DESC')->first();

			Cache::put('front', $track, 5);
		}

		// User liked it?
		$liked = $track->liked();

		$this->track = $track->commentsLike();

		return View::make('tracks.index', ['track' => $track, 'liked' => $liked]);
	}

	/**
	 * Serve up the master cluster fuck of tracks
	 */
	public function masterCluster()
	{
		if (Request::ajax()) 
		{
			$tracks = Cache::get('mastercluster');

			if ( empty($tracks) ) 
			{
				$tracks = DB::table('tracks')->select('id', 'lat', 'lng', 'youtubeid', 'genre', 'title')->orderBy('hot', 'DESC')->take(15000)->whereNull('deleted_at')->get();

				$tracks = json_encode($tracks);

				Cache::put('mastercluster', $tracks, 5);
			}

			return Response::json( $tracks );
		}

		return Response::view('errors.404', [], 404);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Request::ajax()) 
		{
			return View::make('tracks.create');
		}

		return Response::view('errors.404', [], 404);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if ( Request::ajax() ) 
		{
			$input = Input::all();
			$validation = Validator::make($input, Track::$rules);

			if ($validation->passes())
			{
				// Default hotness
				$input['hot'] = round( ( date('U') - 1134028003 ) / 45000, 7 );
				
				$input['user_id'] = ( Auth::check() ) ? Auth::user()->id : null;

				$track = Track::create($input);

				$track->save();

				// Clear mastercluster
				Cache::forget('mastercluster');
				Cache::forget('latest-tracks');

				return Response::json($track->id); // Send the id so it can be binded to marker
			}

			else
			{
				$errors = $validation->errors()->getMessages();

				return Response::view('errors.form', ['errors' => $errors], 500);
			}
		}
		
		return Response::view('errors.404', [], 404);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$track = Cache::get('track' . $id);

		if ( empty($track) ) 
		{
			$track = Track::with('user', 'comments', 'likes', 'likes.user')->findOrFail($id);

			Cache::put('track' . $id, $track, 5);
		}

		// User liked it?
		$liked = $track->liked();

		$this->track = $track->commentsLike();
		
		/**
		 * Return sidebar content if ajax
		 */
		if (Request::ajax()) 
		{
			return View::make('tracks.show-sidebar', ['track' => $track, 'liked' => $liked]);
		}

		return View::make('tracks.show', ['track' => $track, 'liked' => $liked]);
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
				$track = $this->track->find($id);

				if (is_null($track))
				{
					return Response::json('<p>An error occurred.. We did not find it.</p>', 404);
				}

				if (Auth::user()->id == $track->user_id || Auth::user()->id == 1) 
				{
					return View::make('tracks.edit', compact('track'));
				}

				else
				{
					return Response::json('<p>Your user does not own this track.</p>', 403);
				}
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
				$validation = Validator::make($input, Track::$rules);

				if ($validation->passes())
				{
					$track = $this->track->find($id);

					if ($track->user_id == Auth::user()->id || Auth::user()->id == 1) 
					{
						$track->update($input); // Update track

						// Clear cache
						Cache::forget('track' . $id);
						Cache::forget('latest-tracks');
						Cache::forget('mastercluster');

						$track = Track::with('user', 'comments', 'likes', 'likes.user')->findOrFail($id);
						
						Cache::put('track' . $id, $track, 5);

						// User liked it?
						$liked = $track->liked();

						$this->track = $track->commentsLike();

						return View::make('tracks.show-sidebar', ['track' => $track, 'liked' => $liked]);
					}

					return Response::json('This track does not belong to your user.', 403);
				}

				else
				{
					$errors = $validation->errors()->getMessages();

					return Response::view('errors.form', ['errors' => $errors], 500);
				}
			}

			return Response::json('<p>Must be logged in to save.</p>', 403);
		}

		return Response::view('errors.403', [], 403);
	}

	/**
	 * Get the latest tracks to display in left sidebar
	 */
	public function latestTracks()
	{
		if (Request::ajax()) 
		{
			$tracks = Cache::get('latest-tracks');

			if (! $tracks) 
			{
				$tracks = Track::orderBy('id', 'DESC')->take(20)->get();

				Cache::put('latest-tracks', $tracks, 5);
			}

			return Response::json($tracks);
		}

		return Response::view('errors.404', [], 404);
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
