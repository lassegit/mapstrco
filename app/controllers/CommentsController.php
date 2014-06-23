<?php

class CommentsController extends BaseController {

	/**
	 * Comment Repository
	 *
	 * @var Comment
	 */
	protected $comment;

	public function __construct(Comment $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Request::ajax() && Auth::check()) 
		{
			$input = Input::all();
			$validation = Validator::make($input, Comment::$rules);
		
			if ($validation->passes())
			{
				$input['user_id'] = Auth::user()->id;

				$input['hot'] = round( ( date('U') - 1134028003 ) / 45000, 7 );

				$comment = $this->comment->create($input);

				$comment = Comment::with('user')->findOrFail($comment->id);

				// Clear track cache
				Cache::forget('track'. $input['track_id']);

				// Clear user cache
				Cache::forget('user' . Auth::user()->id);

				// Clear master front cache
				Cache::forget('front');

				// Clear sidebar cache
				Cache::forget('latest-comments');
				
				return View::make('comments.show', compact('comment'));
			}

			else
			{
				return Response::json('Whoops, you must be logged in to comment.', 403); // Error
			}
		}

		return Response::view('errors.404', [], 404);
	}

	/**
	 * Show the latest comments for the left sidebar
	 */
	public function latestComments()
	{
		if (Request::ajax()) 
		{
			$comments = Cache::get('latest-comments');

			if (! $comments) 
			{
				$comments = Comment::with('track')->orderBy('id', 'DESC')->take(30)->get();

				Cache::put('latest-comments', $comments, 5);
			}

			return Response::json($comments);
		}

		return Response::view('errors.404', [], 404);
	}
}
