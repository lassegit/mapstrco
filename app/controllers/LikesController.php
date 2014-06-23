<?php

class LikesController extends BaseController {

	/**
	 * Like Repository
	 *
	 * @var Like
	 */
	protected $like;

	public function __construct(Like $like)
	{
		$this->like = $like;
	}

	/**
	 * Like a track
	 */
	public function likeTrack($id)
	{
		if ( Request::ajax() ) 
		{
			if ( Auth::check() ) 
			{
				// See if user vote alread exists
				$vote = Like::where('user_id', Auth::user()->id)->where('track_id', $id)->first();

				if ($vote)
				{
					return Response::json('<p>Looks like you already liked this track.</p>', 500);
				}


				$like = Like::create([
					'user_id'  => Auth::user()->id,
					'track_id' => $id,
				]);
				$like->save();
				
				// Increments vote count & hotness
				$track 		= Track::findOrFail($id);
				$track->up 	= $track->up + 1;
				$track->hot = $track->hotness();
				$track->save();

				// Clear user cache
				Cache::forget('user' . Auth::user()->id);

				// Clear track cache
				Cache::forget('track' . $id);

				return View::make('likes.show', compact('like'));
			}

			else
			{
				return Response::json('<p>You need to be logged in to like.</p>', 403);
			}
		}

		return Response::view('errors.404', [], 404);
	}

	/**
	 * Unlike track
	 */
	public function unlikeTrack($id)
	{
		if (Request::ajax()) 
		{
			if ( Auth::check() ) 
			{
				// Delete the like
				Like::where('track_id', $id)->where('user_id', Auth::user()->id)->delete();

				// Decrements vote count & hotness
				$track 		= Track::findOrFail($id);
				$track->up 	= $track->up - 1;
				$track->hot = $track->hotness();
				$track->save();

				// Clear user cache
				Cache::forget('user' . Auth::user()->id);

				// Clear track cache
				Cache::forget('track' . $id);

				return Response::json(Auth::user()->id); // Return the user id to remove
			}

			else
			{
				return Response::json('<p>You need to be logged in to like.</p>', 403);
			}
		}

		return Response::view('errors.404', [], 404);
	}
	
	/**
	 * Like comment
	 */
	public function likeComement($id)
	{		
		if ( Request::ajax() ) 
		{
			if ( Auth::check() ) 
			{	
				// See if user vote alread exists
				$vote = Like::where('user_id', Auth::user()->id)->where('comment_id', $id)->first();

				if ($vote)
				{
					return Response::json('<p>Looks like you already liked this comment.</p>', 500);
				}

				$like = Like::create([
					'user_id'    => Auth::user()->id,
					'comment_id' => $id,
				]);
				$like->save();

				// Increments vote count & hotness
				$comment 		= Comment::findOrFail($id);
				$comment->up 	= $comment->up + 1;
				$comment->hot 	= $comment->hotness();
				$comment->save();

				// Clear user cache
				Cache::forget('user' . Auth::user()->id);

				// Clear track cache
				Cache::forget('track' . $comment->track_id);

				return Response::json('Succes.');
			}

			else
			{
				return Response::json('<p>You need to be logged in to like.</p>', 403);
			}
		}

		return Response::view('errors.404', [], 404);
	}
	
	/**
	 * Unlike comment
	 */
	public function unlikeComement($id)
	{
		if ( Request::ajax() ) 
		{
			if ( Auth::check() ) 
			{
				// Delete the like
				Like::where('comment_id', $id)->where('user_id', Auth::user()->id)->delete();

				// Decrements vote count & hotness
				$comment 		= Comment::findOrFail($id);
				$comment->up 	= $comment->up - 1;
				$comment->hot 	= $comment->hotness();
				$comment->save();

				// Clear user cache
				Cache::forget('user' . Auth::user()->id);

				// Clear track cache
				Cache::forget('track' . $comment->track_id);

				return Response::json('Success.');
			}

			else
			{
				return Response::json('<p>You need to be logged in to like.</p>', 403);
			}
		}

		return Response::view('errors.404', [], 404);
	}
}
