<?php
session_start();

define('DIR', __DIR__); 


 // configuration file
	require DIR . '/src/db.php';

	require_once DIR . '/vendor/autoload.php';

	require_once __DIR__ . '/includes/fbimg.php';

  $fbimg = new fbimg;

		use Facebook\FacebookSession;
		use Facebook\FacebookRedirectLoginHelper;
		use Facebook\FacebookRequest;
		use Facebook\FacebookResponse;
		use Facebook\FacebookSDKException;
		use Facebook\FacebookRequestException;
		use Facebook\FacebookAuthorizationException;
		use Facebook\GraphObject;

		FacebookSession::setDefaultApplication( $config['appID'] , $config['appSecret'] );

		try {
		  $usession = new FacebookSession( $fbimg->requested['access'] );
		}
		catch( FacebookRequestException $ex ) {
		  // Exception
		}
		catch( Exception $ex ) {
		  // When validation fails or other local issues
		}
		 
	if( isset($usession) ) {

		try {
		 // getting page access token
			$request = new FacebookRequest($usession, 'GET', "/{$fbimg->requested['page']}?fields=access_token");
		}catch( FacebookRequestException $ex ) {
		   die('Check the Page ID.');
		}

		 // page info array
			$page = $request->execute()->getGraphObject()->asArray();

		 // if access token exists
			if( array_key_exists('access_token', $page) ) {
			  // get posting array ( contains Image and page post content )
				$img = $fbimg->get_image();
			 // set the page access token instead of the users' as the request main access token.
				$img['access_token'] = $page['access_token'];
				// post the photo to the page 
					try {
			            $request = new FacebookRequest( $usession, 'POST', "/{$fbimg->requested['page']}/photos" , $img );
					}
					catch( FacebookRequestException $ex ) {
					  die('Faild to post photo');
					}

					// get the post information
			           $post = $request->execute()->getGraphObject()->asArray();

		            if( array_key_exists('id', $post) ) :
		             // Save photo as the last posted photo
		            	$fbimg->save_post();
		                // echo success.
		            	 echo "Posted! <a href='https://fb.com/{$post['id']}'>Here</a>";

		            endif;

			} else {
				die('Something went wrong.');
			}

	} else {

		$login = new FacebookRedirectLoginHelper( $config['redirect'] );
		header("Location: {$login->getLoginUrl(array('email','manage_pages','publish_actions','publish_pages','photo_upload'))}");	

	}
