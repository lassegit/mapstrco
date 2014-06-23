<a href="/" title="Share this" class="share-link"><span class="sprite-share"></span></a>

<aside class="share-links">

	<span class="tooltip" tooltiptitle="Share on Facebook">
		<a href="https://www.facebook.com/sharer/sharer.php?u={{ $share['url'] }}" class="facebook sprite-facebook" target="_blank">facebook</a>
	</span>

	<span class="tooltip" tooltiptitle="Share on Twitter">
		<a href="https://twitter.com/intent/tweet?url={{ $share['url'] }}" class="twitter sprite-twitter" target="_blank">twitter</a>
	</span>

	<span class="tooltip" tooltiptitle="Share on Google+">
		<a href="https://plus.google.com/share?url={{ $share['url'] }}" class="google sprite-googleplus" target="_blank">google</a>
	</span>

	<span class="tooltip" tooltiptitle="Share on Reddit">
		<a href="http://reddit.com/submit?url={{ $share['url'] }}" class="reddit sprite-reddit" target="_blank">reddit</a>
	</span>

	<span class="tooltip" tooltiptitle="Share on tumblr">
		<a href="http://www.tumblr.com/share/link?url={{ $share['url'] }}" class="tumblr sprite-tumblr" target="_blank">tumblr</a>
	</span>

	<span class="tooltip" tooltiptitle="Share on Linkedin">
		<a href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ $share['url'] }}" class="linkedin sprite-linkedin" target="_blank">linkedin</a>
	</span>

	<div class="share-direct-link">
		<span class="sprite-link"></span>
		<input type="text" readonly value="{{ $share['non_encoded'] }}" onClick="this.select();" class="direct-link-input">
	</div>
</aside>