<?php

/**
 * Send PHOTOS to facebook pages
 * FBimg class
 * ----------------------------------------------- #
 * @category  Social Media
 * @author    Mostafa Kassem < elkasem2012@gmail.com >
 * @author    https://www.facebook.com/Zanzofily
 * @copyright Copyright (c) 2015
 * @version   0.3
 */

class fbimg {
 
  public $requested = array( 'page' => '' , 'user'  => '' , 'key'  => '' );
  private $db = null , $photo = null;
  

  /**
    *  Class constructor 
    *  =================
    *   Global database and cron key
    *   Check GET variables
    *
    */

   public function __construct() {

   	global $ckey , $db;
   	$this->db = $db;

   	// checking requested data
   	 $requested  = implode( ',' , $this->requested );

   	    foreach ($this->requested as $key => $value) {
   	    	 
   	    	 if( ! array_key_exists( $key ,  $_GET ) || empty( $_GET[$key] ) ) 
   	    	 	die("Please make sure you entered all requested fields ( {$requested} )");
   	    	 else {
                 
                 if( $key == 'page' AND ! is_numeric( $_GET[$key] ) )
   	    	 			 die("Page ID must be a number.");
   	    	 	 elseif ( $key == 'user' AND ! is_numeric( $_GET[$key] ) ) 
   	    	 			 die("User ID must be a number.");
   	    	 	 elseif ( $key == 'key' AND $_GET[$key] != $ckey ) 
   	    	 			 die("CRON Key is wrong.");

   	    	 	 $this->requested[$key] = $_GET[$key];
   	    	 }
   	    	  
   	    }

   	    // check user and assign access token
   	  	  $this->check_user();

   }

   /**
     * Checking if user is valid
     * ==========================
     * Assigning user access token
     *
     */

   public function check_user() {
		
		$this->db->where ( "fbid" , $this->requested['user'] );
		$user = $this->db->getOne ("users");

		  if(! $this->db->count )
		  	die("User not found, Please visit this <a href='{$config['redirect']}'>page</a> to add your access token.");
		 
		 $this->requested['access']  = $user['access'];

   }

   /**
     * Getting last posted image 
     * ==========================
     * works on the current page 
     *
     */
   public function get_last_img() {

		$this->db->where ( "pageID" , $this->requested['page'] );
		$page = $this->db->getOne ("share");

		  if( $this->db->count ) {
		  		 return $page['img'];
		  }
		 

   }

   /**
     * Save the post 
     * ==========================
     * Preventing repeating the same photo twice
     *
     */
   public function save_post () {
   		
   		$this->db->where ( "pageID" , $this->requested['page']);

   		$stats = $this->db->getOne ("share", "sum(id), count(*) as total");
   		$data = array( 'pageID' => $this->requested['page'] , 'img' => $this->photo );

		 	if( $stats['total'] ) { 

				$this->db->where ( "pageID", $this->requested['page']);
				$this->db->update ('share', $data);

		 	} else 
		 		$this->db->insert ('share', $data);

   }

   /**
     * Get a random photo 
     * ==========================
     * from gallery a random photo different than the last time's posted photo
     *
     */

   public function get_image() {
		
		global $text;

		$dir = DIR . "/gellary/";

	  // check gallery folder
   		if (! is_dir($dir) ) 
   			die('gellary folder not found.');

	  // get photos in gallery folder		
   		$images  = glob("{$dir}*.{jpg,png,gif}", GLOB_BRACE);

   		  foreach ($images as $key => $value) 
   		  	$images[$key] = basename($value);

   		  $last_post = $this->get_last_img();

			if( ($key = array_search($last_post, $images)) !== false) 
			    unset($images[$key]);

   		  
		  // count gallery photos
		    $count_images = count($images);

		    if( $count_images != 0 )
		    	$count_images--;

		  // get random photo
		    $rand_img = rand( 0 , $count_images);

		    $this->photo = $images[$rand_img];

		    $img = realpath( $dir . $images[$rand_img]);

		    $count_text = count($text);

		    if($count_text !=0)
			    $count_text = $count_text-1;

		    $rand_txt = rand(0,$count_text);
		    $message = $text[$rand_txt];
		    
		    // request data
		    $args = array(
			     'message' => $message,
			     'source' =>  new CURLFile( $img ),
			     'access_token' => $this->requested['access']
		    );

		    return $args;

   }



}