<?php
session_start();

define('DIR', dirname(__FILE__));

	require_once __DIR__ . '/includes/facebook.php';

		use Facebook\FacebookSession;
		use Facebook\FacebookRedirectLoginHelper;
		use Facebook\FacebookRequest;
		use Facebook\FacebookResponse;
		use Facebook\FacebookSDKException;
		use Facebook\FacebookRequestException;
		use Facebook\FacebookAuthorizationException;
		use Facebook\GraphObject;

		FacebookSession::setDefaultApplication( $config['appID'] , $config['appSecret'] );

		$login = new FacebookRedirectLoginHelper( $config['redirect'] );
		
		try {
		  $usession = $login->getSessionFromRedirect();
		}
		catch( FacebookRequestException $ex ) {
		  // Exception
		}
		catch( Exception $ex ) {
		  // When validation fails or other local issues
		}
		 
	if( isset($usession) ) {

		$accessToken = $usession->getAccessToken();		
		 // never expires access token 
			$longLivedAccessToken = (string) $accessToken->extend();

			$request = new FacebookRequest($usession, 'GET', '/me/');
			$user = $request->execute()->getGraphObject()->asArray();

			$data = array( 'fbid' =>  $user['id'] , 'access' => $longLivedAccessToken );
			
			$db->where ( "fbid", $user['id'] );

			$stats = $db->getOne ("users", "sum(uid), count(*) as total");
			 	
			 	if( $stats['total'] ) {

			 		$db->where ( "fbid", $user['id'] );
					$db->update ('users', $data);
					  
					  if($db->count) 
					  	echo "Updated Successfully.";
					  else
					  	echo "Something Went wrong.";

			 	} else {
			  		$id = $db->insert ('users', $data);

			  		if ($id) 
					  	echo "Added Successfully.";
			  		else
					  	echo "Something Went wrong.";

			 	}


			$request = new FacebookRequest($usession, 'GET', '/me/accounts?fields=id&limit=999');
			$pageList = $request->execute()->getGraphObject()->asArray();

			 foreach ($pageList['data'] as $key => $value) {
			 	echo $value->id;
			 }

	} else
		header("Location: {$login->getLoginUrl(array('email','manage_pages','publish_actions','publish_pages'))}");