<?php
/**
 * Various macros
 */

/**
 * Render the region links
 */
HTML::macro('regions', function($region) 
{	
	switch ($region) {
		case 'north america':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '40.0850925',
				'lng'	=> '-96.9514821',
				'zoom'	=> 4,
			]);
			break;

		case 'latin america & carribean':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '-4.1089732',
				'lng'	=> '-78.8460133',
				'zoom'	=> 4,
			]);
			break;

		case 'europe':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '54.6267983',
				'lng'	=> '12.9407135',
				'zoom'	=> 4,
			]);
			break;

		case 'mid east & north africa':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '32.700419',
				'lng'	=> '16.1926666',
				'zoom'	=> 4,
			]);
			break;
		
		case 'sub-saharan africa':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '-8.1397107',
				'lng'	=> '24.1028229',
				'zoom'	=> 4,
			]);
			break;

		case 'south asia':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '18.5900301',
				'lng'	=> '77.979776',
				'zoom'	=> 4,
			]);
			break;

		case 'east asia & pacific':
			return '<span class="sprite-compass"></span> ' . HTML::link($region, Str::title($region), [
				'class' => 'regionlink',
				'title' => 'Zoom to ' . $region,
				'lat' 	=> '18.6108551',
				'lng'	=> '118.8049713',
				'zoom'	=> 4,
			]);
			break;

		default:
			return '<i>no region set</i>';
			break;
	}
});


/**
 * Generate google ads markup
 */
HTML::macro('adsense', function($name) 
{
	$data = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';


	switch ($name) {
		case 'comment':
			$data .= '<ins class="adsbygoogle"
				    	style="display:block; margin:auto auto 1em auto;width:336px;height:280px"
				     	data-ad-client="ca-pub-7957938424440448"
				    	data-ad-slot="1288777019">
				    </ins>';
			break;
		case 'like':
			$data .= '<ins class="adsbygoogle"
				     	style="display:block; margin:auto auto 1em auto;width:336px;height:280px"
				    	data-ad-client="ca-pub-7957938424440448"
				    	data-ad-slot="4102642611">
				    </ins>';
			break;
		case 'track':
			$data .= '<ins class="adsbygoogle"
				    	style="display:block; margin:auto auto 1em auto;width:336px;height:280px"
				    	data-ad-client="ca-pub-7957938424440448"
				    	data-ad-slot="5579375815">
     				</ins>';
			break;
		default:
			# code...
			break;
	}

	$data .= '<script> (adsbygoogle = window.adsbygoogle || []).push({}); </script>';

	return $data;
});
