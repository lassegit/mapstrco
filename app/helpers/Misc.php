<?php 
/**
 * File containing various function to help modify the app.
 */

class Misc {

	/**
	 * Generate social share links
	 * See for links: http://atlchris.com/1665/how-to-create-custom-share-buttons-for-all-the-popular-social-services/
	 */
	public static function share($url)
	{	
		$full_url = URL::to($url);

		$share['url'] = urlencode($full_url); // Encode the url

		$share['non_encoded'] = $full_url; //explode('//', $full_url)[1];

		return View::make('layouts.share', ['share' => $share]);
	}


	/**
	 * Parse body to markup links with a tags
	 */
	public static function markup($text = '')
	{
		$text = strip_tags($text);

		$pattern = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

		preg_match_all($pattern, $text, $matches);

		$used_match = [];

		foreach ($matches[0] as $key => $match) 
		{
			// Links for local url
			if (stripos($match, 'mapstr.co') && ! array_key_exists($match, $used_match)) 
			{
				$relative_url = preg_replace('/http:\/\/|https:\/\/|www./', '', $match);

				$used_match[$match] = true;

				// User link
				if (stripos($match, 'users')) 
				{
					$text = str_replace($match, '<a href="' . $match . '?type=full" class="userlink">' . $relative_url . '</a>', $text);
				}

				// Track link
				elseif (stripos($match, 'tracks')) 
				{
					$text = str_replace($match, '<a href="' . $match . '?type=full" class="tracklink">' . $relative_url . '</a>', $text);
				}
			}
			
			elseif (! array_key_exists($match, $used_match))
			{
				$used_match[$match] = true;

				$link_text = preg_replace('/http:\/\/|https:\/\/|www./', '', $match);

				$text = str_replace($match, '<a href="' . $match . '" target="_blank" class="external-link">' . Str::limit($link_text, $limit = 30, $end = '...') . '</a>', $text);
			}
		}
		
		return nl2br($text);
	}
}
