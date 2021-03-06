<?php
namespace WP_Speak;

class Image_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_image_table;
	private static $_img_table;
	private static $_img_image_table;
	private static $_add_settings_field = array();
	private static $_section = "image_option";
	private static $_section_title;
	private static $_fields = array (
            "image"
	    );
	private static $_default_options = array(
        );


	
	protected function __construct() { 

    	self::$_section_title = Admin::WPS_ADMIN . self::$_section;
    	
        add_action("admin_init", array(get_class(), "init")); 
        add_action(Admin::WPS_ADMIN."init_".self::$_section,     array(self::$_registry, "init_registry"),   Callback::EXPECT_NON_DEFAULT_PRIORITY, Callback::EXPECT_TWO_ARGUMENTS);
        add_filter(Admin::WPS_ADMIN."validate_".self::$_section, array(self::$_registry, "update_registry"), Callback::EXPECT_DEFAULT_PRIORITY, Callback::EXPECT_TWO_ARGUMENTS);

	}
	
    public function get_section() {
        return self::$_section;
    }
    
    /**
     *	Orchestrates the creation of the Image Panel
     */
    public static function init($arg1)
    {
        $page = Option::$OPTION_EXTENDED_TITLE[self::$_section];

        if( !get_option( $page ) )
        {
            update_option( $page, self::filter_default_options( self::$_default_options ) );
        }

        $paragraph = <<<EOD
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis euismod ut nisl nec tincidunt. Donec quis tempus dui. Nam venenatis ullamcorper metus, at semper velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus interdum egestas aliquam. Etiam efficitur, dolor et dignissim sagittis, ante nunc pellentesque nulla, ut tempus diam sapien lacinia dui. Curabitur lobortis urna a faucibus volutpat. Sed eget risus pharetra, porta risus et, fermentum ligula. Mauris sed hendrerit ex, sed vulputate lorem. Duis in lobortis justo. Aenean mattis odio tortor, sit amet fermentum orci tempus ut. Donec vitae elit facilisis, tincidunt augue id, tempus elit. Nullam sapien est, gravida nec luctus non, rhoncus vitae magna. Fusce dolor justo, ultricies non efficitur vitae, interdum in tortor.
EOD;

        array_map( self::$_add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."image", "title"=>"Image Files", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


//         if ( !self::$_img_table->update_all( 'status', 'invalid' ) ) {
//             add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
//             return;
//         }

        if ( !self::$_image_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
            return;
        }

//         if ( !self::$_img_image_table->update_all( 'status', 'invalid' ) ) {
//             add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
//             return;
//         }

        // The Loop
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'post',
        );
        $the_query = new \WP_Query( $args );

        if ( $the_query->have_posts() ) {

            while ( $the_query->have_posts() ) {

                $the_query->the_post();
    
                $dom = new \domDocument;
                $dom->loadHTML($the_query->post->post_content);
                $dom->preserveWhiteSpace = false;
                $images_dom = $dom->getElementsByTagName('img');
    
                foreach ($images_dom as $image_dom) {
     
                    $img   = array();
                    $image = array();
        
                    $image['status']      = "GOOD";
                    $image['src']         = $image_dom->getAttribute('src'); // Keep http:// or https://
                    $image['alt']         = "No ALT";
                    $image['img']         = $image_dom->C14N();
                    $image['path']        = str_replace(array("http://", "https://"), array("", ""), $image['src']);
                    $image['title']       = basename( $image['src'] );
                    $image['image_id']    = md5( $image['src'] );
                    
                    if ( !self::$_image_table->validate( $image ) ) {
                        add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$_image_table->insert_unique( $image ) ) {
                        add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$_image_table->update( 'status', 'valid', 'image_id', $image['image_id'] ) ) {
                        add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                }
                
            }

        }
        /* Restore original Post Data */
        wp_reset_postdata();
 
        $image_table     = self::$_image_table->fetch_all();

        $master = ["image"=>$image_table];
        
        array_map( self::$_add_settings_field["image"], [
            ["id"=>"image_files",  "title"=>"Image Files", "callback"=>array("WP_Speak\Image_Option", "element_image_callback"), "args"=>array( "master" => $master )]
        ]);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_image_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public static function element_image_callback($arg_list)
    {
        $max_width = Admin::WORDWRAP_WIDTH;
        
        $image_list = array();
        foreach( $arg_list["master"]["image"] as $image ) {
            $image_list[$image["image_id"]] = $image;
        }

        $html = "";

        $cnt = 0;
        foreach( $image_list as $image ) {
        
            $image_id     = $image['image_id'];
            
            if ( $image['status'] === "invalid" ) {
                continue;
            }
            
            $cnt = $cnt+1;
            
            $html .=<<<EOD
<div class='wps-test-divXXX' style='width:fit-content'>
<div style='margin:2em 0 0 0; font-size:150%;height:3em;font-weight:900;text-align:center;border-bottom:3px solid rgba(137,83,221,1);'>
    {$image['title']}
    <br/>
    <span style='opacity:0.5;font-size:50%;'>{$image['src']}</span>
</div>
<div class='wps-test-divXXX' style='float:left'>
    <input type='hidden' id='{$arg_list['element']}_image_id_{$cnt}' name='{$arg_list['page']}[{$arg_list['element']}_image_id_{$cnt}]' value='{$image_id}' />

<!--
    <div style='font-weight:bold;margin:1em;font-size:120%;'>STATUS: {$image['status']}</div>
-->
    
    <div style='font-weight:bold;margin:1em;font-size:120%;'>Custom Audio for ALT parameter</div>
    <textarea id='{$arg_list['element']}_custom_alt_{$cnt}' name='{$arg_list['page']}[{$arg_list['element']}_custom_alt_{$cnt}]' style='margin:0 1em;' cols='50' rows='5'>{$image['alt']}</textarea>
    
</div>
<div class='wps-test-divXXX' style='border:2px solid rgba(137,83,221,0.4);margin:1em;float:right;width:30em;'>
    {$image['img']}
</div>
</div>
<div class='wps-clear'></div>
EOD;
        }

    $html .=<<<EOF
<input type='hidden' id='{$arg_list['element']}_cnt' name='{$arg_list['page']}[{$arg_list['element']}_cnt]' value='{$cnt}' />
EOF;
        echo $html;
    }

    public function validate_image_option( $arg_input )
    {
        self::$_logger->log( self::$_mask, "Validation: " . __FUNCTION__ );
        self::$_logger->log( self::$_mask, "Input");
        self::$_logger->log( self::$_mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();

        if ( !isset($arg_input) )
        {
            return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
        }

        // Loop through each of the options sanitizing the data
        foreach( $arg_input as $key => $val )
        {
            if( isset ( $arg_input[$key] ) )
            {
                $output[$key] = $arg_input[$key];
            }
        }

        $element = "image_files";
        $total_cnt = $arg_input[$element . "_cnt"];
        
        for ($cnt = 1; $cnt <= $total_cnt ; $cnt++ ) {
        
            $image_id   = $arg_input[ "{$element}_image_id_{$cnt}" ];
            $custom_alt = $arg_input[ "{$element}_custom_alt_{$cnt}" ];
            
            if ( !self::$_image_table->update('alt', $custom_alt, 'image_id', $image_id) ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
            
        }
        
        
        
        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST["image_option"]);

        $master = json_decode($arg_input["image_files"], true);
        
        foreach( $master["img_image"] as $img_image ) {
        
            $img   = $master["img"  ][ $img_image["img_id"] ];
            $image = $master["image"][ $img_image["image_id"] ];
            
            if ( !self::$_img_table->validate( $img ) ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            if ( !self::$_image_table->validate( $image ) ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            $img_id = self::$_img_table->insert($img);
            if ( FALSE === $img_id ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }

            $image_id = self::$_image_table->insert($image);
            if ( FALSE === $image_id ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }

            $img_image_id = self::$_img_image_table->insert( array("img_id" => $img_id, "image_id" => $image_id) );
            if ( FALSE === $img_image_id ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
        }
        
        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST["image_option"]);
    }


    /**
     * Provides default values for the Media Options.
     */
    public static function filter_default_options($arg_default_options)
    {
        return $arg_default_options;
        
        $defaults = array(
        );

        return $defaults;
    }

	public function set_image_table( $arg_image_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_image_table = $arg_image_table;
		return $this;
	}
	
	public function set_img_table( $arg_img_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_img_table = $arg_img_table;
		return $this;
	}
	
	public function set_img_image_table( $arg_img_image_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_img_image_table = $arg_img_image_table;
		return $this;
	}
		
    public function set_add_settings_section($arg_add_settings_section)
	{
		//assert( '!is_null($arg_registry)' );
		self::$_add_settings_section = $arg_add_settings_section->create(Option::$OPTION_EXTENDED_TITLE[self::$_section]);;
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		foreach(self::$_fields as $field) {
            self::$_add_settings_field[$field] = $arg_add_settings_field->create(self::$_section_title, Admin::WPS_ADMIN.$field);
		}
		return $this;
	}
	
	public function set_db(DB $arg_db)
	{
		//assert( '!is_null($arg_logger)' );
		self::$_db = $arg_db;
		return $this;
	}
	
}

?>
