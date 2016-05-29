<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['vk'] = ['APP_ID' 			=> 5483556,
				 'APP_SECRET' 		=> '48PE7iHaBE190lhbBd3Y',
				 'URL_CALLBACK' 	=> 'http://localhost/wifi/wifi/vk',
				 'URL_ACCESS_TOKEN' => 'https://oauth.vk.com/access_token',
				 'URL_AUTHORIZE' 	=>  'https://oauth.vk.com/authorize',
				 'URL_GET_PROFILES' => 'https://api.vk.com/method/users.get'
				];

$config['twitter'] = ['CONSUMER_KEY'		=> '1SjHxoqRBhpCv20Pak24QApm3',
				 	  'CONSUMER_SECRET' 	=> 'cLtaWs2w86pFrIetKDm6mmBDoTcmog0A7fyVZW8hjF2urLAkWT',
				 	  'URL_CALLBACK' 		=> 'http://localhost/wifi/wifi/twitter',
				 	  'URL_GET_TOKEN' 		=> 'https://api.twitter.com/oauth2/token',
				 	  'URL_REQUEST_TOKEN' 	=> 'https://api.twitter.com/oauth/request_token',
				 	  'URL_AUTHORIZE' 		=> 'https://api.twitter.com/oauth/authorize',
				 	  'URL_ACCESS_TOKEN' 	=> 'https://api.twitter.com/oauth/access_token',
				 	  'URL_USER_DATA' 		=> 'https://api.twitter.com/1.1/users/show.json'
					 ];

$config['fb'] = ['APP_ID'			=> 1801137726772847,
				 'APP_SECRET' 		=> 'd2cd5c15fa1f97b785096c34fdcfada3',
				 'URL_CALLBACK' 	=> 'http://localhost/wifi/wifi/facebook',
				 'URL_ACCESS_TOKEN' => 'https://graph.facebook.com/oauth/access_token',
				 'URL_OATH' 		=> 'https://www.facebook.com/dialog/oauth',
				 'URL_GET_ME' 		=> 'https://graph.facebook.com/me'
				 ];

$config['ok'] = ['APP_ID'			=> 1247133440,
				 'APP_SECRET' 		=> 'F2DC27635A7161FD03025158',
				 'URL_CALLBACK' 	=> 'http://localhost/wifi/wifi/odnoklassniki',
				 'APP_PUBLIC' 		=> 'CBAQLGFLEBABABABA',
				 'URL_AUTHORIZE' 	=> 'http://www.odnoklassniki.ru/oauth/authorize',
				 'URL_ACCESS_TOKEN' => 'http://api.odnoklassniki.ru/fb.do',
				 'URL_GET_TOKEN' 	=> 'http://api.odnoklassniki.ru/oauth/token.do'
				 ];

$config['ig'] = ['CLIENT_ID'		=> 'f9a35fb150984c5788435b317a02c12d',
				 'CLIENT_SECRET' 	=> 'b8d6bf1a35214ebebe5b6e7f9fd5c2fe',
				 'REDIRECT_URI' 	=> 'http://localhost/wifi/wifi/instagram',
				 'URL_AUTHORIZE' 	=> 'https://api.instagram.com/oauth/authorize/',
				 'URL_ACCESS_TOKEN' => 'https://api.instagram.com/oauth/access_token',
				 'URL_GET_PROFILES' => 'https://api.instagram.com/v1/users/'
				 ];