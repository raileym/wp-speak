<?php
namespace WP_Speak;

class Media_Option extends Basic
{
    protected static $_instance;

	private static $_add_settings_section;
	private static $_image_table;
	private static $_img_table;
	private static $_img_image_table;
	private static $_add_settings_field = array();
	private static $_section = "media_option";
	private static $_section_title;
	private static $_fields = array (
            "media"
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
     *	Orchestrates the creation of the Media Panel
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
            ["id"=>Admin::WPS_ADMIN."media", "title"=>"Media Files", "callback"=>array("WP_Speak\Callback", "section_p_callback"), "args"=>array( "paragraph" => $paragraph )]
        ]);


        // See https://stackoverflow.com/questions/30531600/wordpress-how-do-i-get-all-posts-from-wp-query-in-the-search-results
        // See https://wordpress.stackexchange.com/questions/61530/how-to-get-an-array-of-post-data-from-wp-query-result
        // See https://www.smashingmagazine.com/2016/03/advanced-wordpress-search-with-wp_query/
        // See https://stackoverflow.com/questions/3946506/crawling-a-html-page-using-php

        // An array of arguments
        //$args = array( 'arg_1' => 'val_1', 'arg_2' => 'val_2' );

        // The Query
        //$the_query = new WP_Query( $args );

        if ( !self::$_img_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
            return;
        }

        if ( !self::$_image_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
            return;
        }

        if ( !self::$_img_image_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
            return;
        }

        // The Loop
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'post',
        );
        $the_query = new \WP_Query( $args );

        if ( $the_query->have_posts() ) {

            while ( $the_query->have_posts() ) {

                $the_query->the_post();
    
                // See https://stackoverflow.com/questions/15895773/scraping-all-images-from-a-website-using-domdocument
    
                $dom = new \domDocument;
                $dom->loadHTML($the_query->post->post_content);
                $dom->preserveWhiteSpace = false;
                $images_dom = $dom->getElementsByTagName('img');
    
                foreach ($images_dom as $image_dom) {
     
                    $img   = array();
                    $image = array();
        
                    // E.g., SELECT img.src, img.path, img.title FROM wp_speak_image img, wp_speak_img pst WHERE pst.image_ID == img.ID AND pst.post_id = '50'
        
                    $image['status']      = "GOOD";
                    $image['src']         = $image_dom->getAttribute('src'); // Keep http:// or https://
                    $image['alt']         = "No ALT";
                    $image['img']         = $image_dom->C14N();
                    $image['path']        = str_replace(array("http://", "https://"), array("", ""), $image['src']);
                    $image['title']       = basename( $image['src'] );
                    $image['image_id']    = md5( $image['src'] );
                    
                    $img['wp_post_id']    = $the_query->post->ID;
                    $img['wp_post_title'] = $the_query->post->post_title;
                    $img['use_alt']       = "use_img_attr_alt";
                    $img['alt']           = "No ALT";
                    $img['attr_alt']      = set_default($image_dom->getAttribute('alt'), "No ALT");
                    $img['attr_class']    = set_default($image_dom->getAttribute('class'), "No CLASS");
                    $img['attr_id']       = set_default($image_dom->getAttribute('id'), "No ID");
                    $img['img_id']        = md5( $img['wp_post_id'] . $img['attr_alt'] . $image['src'] );
                    $img['status']        = "GOOD";

                    $img_image = array(
                        "status"       => "GOOD",
                        "img_image_id" => md5( $img['img_id'] . $image['image_id'] ),
                        "img_id"       => $img['img_id'], 
                        "image_id"     => $image['image_id']);

                    if ( !self::$_img_table->validate( $img ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$_image_table->validate( $image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$_img_image_table->validate( $img_image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$_img_table->insert_unique( $img ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
                        
                    if ( !self::$_image_table->insert_unique( $image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$_img_image_table->insert_unique( $img_image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$_img_table->update( 'status', 'valid', 'img_id', $img['img_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$_img_table->update( 'attr_alt', $img['attr_alt'], 'img_id', $img['img_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$_image_table->update( 'status', 'valid', 'image_id', $image['image_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$_img_image_table->update( 'status', 'valid', 'img_image_id', $img_image['img_image_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !$img_fetch = self::$_img_table->fetch( 'img_id', $img['img_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
                    
                    // Database over-rules the default entry. This assigned
                    // value could be the original default value, btw.
                    $img['use_alt'] = $img_fetch[0]["use_alt"];
                }
                
            }

        }
        /* Restore original Post Data */
        wp_reset_postdata();
 
        $img_image_table = self::$_img_image_table->fetch_all();
        $image_table     = self::$_image_table->fetch_all();
        $img_table       = self::$_img_table->fetch_all();

        $master = ["img"=>$img_table, "image"=>$image_table, "img_image"=>$img_image_table];
        
        array_map( self::$_add_settings_field["media"], [
            ["id"=>"media_files",  "title"=>"Media Files", "callback"=>array("WP_Speak\Media_Option", "element_media_callback"), "args"=>array( "master" => $master )]
        ]);

Registry::get_instance()->init_table_registry(self::$_img_table);
Registry::get_instance()->init_table_registry(self::$_image_table);
Registry::get_instance()->init_table_registry(self::$_img_image_table);

        register_setting(
            $page,
            $page,
            array(self::get_instance(), "validate_media_option")
        );

        do_action( Admin::WPS_ADMIN.__FUNCTION__, $page, Option::$OPTION_LIST[self::$_section] );
    }

    public static function element_media_callback($arg_list)
    {
        $max_width = Admin::WORDWRAP_WIDTH;
        
        $master = $arg_list["master"];
        $img_image_list  = $arg_list["master"]["img_image"];
        
        $image_list = array();
        foreach( $arg_list["master"]["image"] as $image ) {
            $image_list[$image["image_id"]] = $image;
        }

        $img_list = array();
        foreach( $arg_list["master"]["img"] as $img ) {
            $img_list[$img["img_id"]] = $img;
        }

        $master_json = json_encode($master);
        $html = "";

        $cnt = 0;
        foreach( $img_image_list as $img_image ) {
        
            $img_id       = $img_image['img_id'  ];
            $image_id     = $img_image['image_id'  ];
            $img_image_id = $img_image['img_image_id'];
            
            $img   = $img_list[   $img_id   ];
            $image = $image_list[ $image_id ];

// error_log( print_r($img, true) );
            
            if ( $img['status'] === "invalid" || $image['status'] === "invalid" || $img_image['status'] === "invalid" ) {
                continue;
            }
            
            $cnt = $cnt+1;
            
            $img_attr_alt = $img['attr_alt'];
            $img_alt      = $img['alt'];
            $image_alt    = $image['alt'];
            
            // Test only
            //$img['use_alt'] = "image_alt";

            $description = <<<EOD
Here is a sample description.
EOD;
        
            $checked = array();
        
            $checked["use_img_alt"]      = ("use_img_alt"      === $img['use_alt']) ? "checked" : "";
            $checked["use_image_alt"]    = ("use_image_alt"    === $img['use_alt']) ? "checked" : "";
            $checked["use_img_attr_alt"] = ("use_img_attr_alt" === $img['use_alt']) ? "checked" : "";

            $selected = array();
        
            $selected["use_img_alt"]      = ("use_img_alt"      === $img['use_alt']) ? " wps-selected " : "";
            $selected["use_image_alt"]    = ("use_image_alt"    === $img['use_alt']) ? " wps-selected " : "";
            $selected["use_img_attr_alt"] = ("use_img_attr_alt" === $img['use_alt']) ? " wps-selected " : "";

            //$html = (isset($arg_list["description"])) ? "<p>".wordwrap($arg_list['description'], Admin::WORDWRAP_WIDTH, "<br/>")."</p>" : "";

            $name = "{$arg_list['page']}[{$arg_list['element']}_sel_alt_{$cnt}]";
            
            $html .=<<<EOD
<div class='wps-test-divXXX' style='width:fit-content'>
<div style='margin:2em 0 0 0; font-size:150%;height:3em;font-weight:900;text-align:center;border-bottom:3px solid rgba(137,83,221,1);'>
    {$img['wp_post_title']}
    <br/>
    <span style='opacity:0.5;font-size:50%;'>{$image['src']}</span>
</div>
<div class='wps-audio-panel' style='float:left'>
    <input type='hidden' id='{$arg_list['element']}_img_id_{$cnt}' name='{$arg_list['page']}[{$arg_list['element']}_img_id_{$cnt}]' value='{$img_id}' />
    <input type='hidden' id='{$arg_list['element']}_image_id_{$cnt}' name='{$arg_list['page']}[{$arg_list['element']}_image_id_{$cnt}]' value='{$image_id}' />
    <input type='hidden' id='{$arg_list['element']}_img_image_id_{$cnt}' name='{$arg_list['page']}[{$arg_list['element']}_img_image_id_{$cnt}]' value='{$img_image_id}' />

<!--
    <div style='font-weight:bold;margin:1em;font-size:120%;'>STATUS: {$img['status']}</div>
-->
    
    <div class='wps-audio-label'>Image</div>
    <div class='wps-audio-content'>{$image['title']}</div>

    <div class='wps-audio-choice wps-{$cnt} wps-img-attr-alt {$selected["use_img_attr_alt"]}'>
        <div class='wps-audio-label'>Audio from Add Media | Alt Text 
            <a class="wps-audio" aria-label="One, Play Alt Text assigned to the media">
            <i title="Speak the 'Alt Text' assigned to this media." class="fa fa-microphone" aria-hidden="true"><span>{$img['attr_alt']}</span></i>
            </a>
        </div>
    <div class='wps-audio-content'>{$img['attr_alt']}</div>
    </div>

    <div class='wps-audio-choice wps-{$cnt} wps-image-alt {$selected["use_image_alt"]}'>
        <div class='wps-audio-label'>Custom Audio from Option Image  
            <a class="wps-audio" aria-label="One, Play custom Alt Text assigned to the image">
            <i title="Speak the custom 'Alt Text' assigned to this image." class="fa fa-microphone" aria-hidden="true"><span>{$image['alt']}</span></i>
            </a>
        </div>
        <div class='wps-audio-content'>{$image['alt']}</div>
    </div>

    <div class='wps-audio-choice wps-{$cnt} wps-img-alt {$selected["use_img_alt"]}'>
        <div class='wps-audio-label'>Custom Audio from Option Media  
            <a class="wps-audio" textarea-id="{$arg_list['element']}_custom_alt_{$cnt}" aria-label="One, Play custom Alt Text assigned to this media">
            <i title="Speak the custom 'Alt Text' assigned to this media." class="fa fa-microphone" aria-hidden="true"><span>{$img['alt']}</span></i>
            </a>
        </div>
        <textarea class='wps-audio-content' id='{$arg_list['element']}_custom_alt_{$cnt}' name='{$arg_list['page']}[{$arg_list['element']}_custom_alt_{$cnt}]' rows='5'>{$img['alt']}</textarea>
    </div>
        
    <div style='font-weight:bold;margin:1em;font-size:120%;'>
        <input class='wps-radio {$arg_list['page']} wps-{$cnt}' wps-cnt='{$cnt}' type='radio' id='{$arg_list['element']}_sel_img_attr_alt_{$cnt}' name='{$name}' value='use_img_attr_alt' {$checked['use_img_attr_alt']} />
        <label for='{$arg_list['element']}_sel_img_attr_alt_{$cnt}'>Use Img Attr Alt</label>

        <input class='wps-radio {$arg_list['page']} wps-{$cnt}' wps-cnt='{$cnt}' type='radio' id='{$arg_list['element']}_sel_image_alt_{$cnt}' name='{$name}' value='use_image_alt' {$checked['use_image_alt']} />
        <label for='{$arg_list['element']}_sel_image_alt_{$cnt}'>Use Image Alt</label>

        <input class='wps-radio {$arg_list['page']} wps-{$cnt}' wps-cnt='{$cnt}' type='radio' id='{$arg_list['element']}_sel_img_alt_{$cnt}' name='{$name}' value='use_img_alt' {$checked['use_img_alt']} />
        <label for='{$arg_list['element']}_sel_img_alt_{$cnt}'>Use Img Alt</label>
    </div>
<!--
    <div style='font-weight:bold;margin:1em;font-size:120%;'>Text for CLASS parameter</div>
    <div style='opacity:0.4;font-weight:bold;margin:1em;font-size:120%;border:1px solid black;'>{$img['attr_class']}</div>
    <div style='font-weight:bold;margin:1em;font-size:120%;'>Img ID</div>
    <div style='opacity:0.4;font-weight:bold;margin:1em;font-size:120%;border:1px solid black;'>{$img['attr_id']}</div>
-->
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

    public function validate_media_option( $arg_input )
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

        $element = "media_files";
        $total_cnt = $arg_input[$element . "_cnt"];
        
// error_log( print_r($arg_input, true) );

        for ($cnt = 1; $cnt <= $total_cnt ; $cnt++ ) {
        
            $img_id     = $arg_input[ "{$element}_img_id_{$cnt}" ];
            $custom_alt = $arg_input[ "{$element}_custom_alt_{$cnt}" ];
            $use_alt    = $arg_input[ "{$element}_sel_alt_{$cnt}" ];
            
            if ( !self::$_img_table->update('alt', $custom_alt, 'img_id', $img_id) ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            if ( !self::$_img_table->update('use_alt', $use_alt, 'img_id', $img_id) ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
            
        }
        
        
        
         // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);

        $master = json_decode($arg_input["media_files"], true);
        
        foreach( $master["img_image"] as $img_image ) {
        
            $img   = $master["img"  ][ $img_image["img_id"] ];
            $image = $master["image"][ $img_image["image_id"] ];
            
            if ( !self::$_img_table->validate( $img ) ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            if ( !self::$_image_table->validate( $image ) ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            $img_id = self::$_img_table->insert($img);
            if ( FALSE === $img_id ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }

            $image_id = self::$_image_table->insert($image);
            if ( FALSE === $image_id ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }

            $img_image_id = self::$_img_image_table->insert( array("img_id" => $img_id, "image_id" => $image_id) );
            if ( FALSE === $img_image_id ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
        }
        
        // Return the new collection
        return apply_filters( Admin::WPS_ADMIN.__FUNCTION__, $output, Option::$OPTION_LIST[self::$_section]);
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
