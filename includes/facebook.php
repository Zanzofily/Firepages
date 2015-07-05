<?php

/**
 * Send PHOTOS to facebook pages
 * index file
 * ----------------------------------------------- #
 * @category  Social Media
 * @author    Mostafa Kassem < elkasem2012@gmail.com >
 * @author    https://www.facebook.com/Zanzofily
 * @copyright Copyright (c) 2015
 * @version   0.3
 */


// Facebook SDK Path
define('FACEBOOK_SDK_V4_SRC_DIR', DIR . '/src/Facebook/');

require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookSession.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookRedirectLoginHelper.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookRequest.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookResponse.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookSDKException.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookRequestException.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'FacebookAuthorizationException.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'GraphObject.php' );

require_once( FACEBOOK_SDK_V4_SRC_DIR . 'HttpClients/FacebookHttpable.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'HttpClients/FacebookCurl.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'HttpClients/FacebookCurlHttpClient.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'Entities/AccessToken.php' );
require_once( FACEBOOK_SDK_V4_SRC_DIR . 'Entities/SignedRequest.php' );

 // configuration file
	require __DIR__ . '/db.php';


?>