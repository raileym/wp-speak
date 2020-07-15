<?php
namespace WP_Speak;

class Media_Option extends Basic
{
    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

	private static $add_settings_section;
	private static $image_table;
	private static $img_table;
	private static $img_image_table;
	private static $add_settings_field = array();
	private static $section = "media_option";
	private static $fields = array (
            "media"
	    );
	private static $default_options = array(
        );


	
	protected function __construct() { 

        add_action(
            "admin_init", 
            array(get_class(), "init")); 

        add_action(
            Action::$init[get_called_class()],
            array(self::$registry, "init_registry"),
            Callback::EXPECT_NON_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);

        add_filter(
            Filter::$validate[get_called_class()],
            array(self::$registry, "update_registry"),
            Callback::EXPECT_DEFAULT_PRIORITY,
            Callback::EXPECT_TWO_ARGUMENTS);
        
	}
	
    public function get_section() {
        return self::$section;
    }
    
    /**
     *	Orchestrates the creation of the Media Panel
     */
    public static function init($arg1)
    {
        self::$logger->log( self::$mask, get_called_class() . " " . __FUNCTION__ );

        $option = self::$wp_option->get( get_called_class() );

        if( !$option )
        {
            //self::$logger->log( self::$mask, __FUNCTION__ . "Set default options." );
            self::$wp_option->update( get_called_class(), self::filter_default_options( self::$default_options ) );
            $option = self::$wp_option->get( get_called_class() );
        }


		self::$add_settings_section = self::$wp_settings->create_add_settings_section(
            get_called_class() );


		foreach(self::$fields as $field) {
            self::$add_settings_field[$field] = self::$wp_settings->create_add_settings_field(
                get_called_class(),
                Admin::WPS_ADMIN.$field);
		}


        $paragraph = <<<EOD
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis euismod ut nisl nec tincidunt. Donec quis tempus dui. Nam venenatis ullamcorper metus, at semper velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus interdum egestas aliquam. Etiam efficitur, dolor et dignissim sagittis, ante nunc pellentesque nulla, ut tempus diam sapien lacinia dui. Curabitur lobortis urna a faucibus volutpat. Sed eget risus pharetra, porta risus et, fermentum ligula. Mauris sed hendrerit ex, sed vulputate lorem. Duis in lobortis justo. Aenean mattis odio tortor, sit amet fermentum orci tempus ut. Donec vitae elit facilisis, tincidunt augue id, tempus elit. Nullam sapien est, gravida nec luctus non, rhoncus vitae magna. Fusce dolor justo, ultricies non efficitur vitae, interdum in tortor.
EOD;

        array_map(
            self::$add_settings_section, [
                ["id"=>Admin::WPS_ADMIN."media",
                 "title"=>"Media Files",
                 "callback"=>Callback::PARAGRAPH,
                 "args"=>array( "paragraph" => $paragraph )]
        ]);


        // See https://stackoverflow.com/questions/30531600/wordpress-how-do-i-get-all-posts-from-wp-query-in-the-search-results
        // See https://wordpress.stackexchange.com/questions/61530/how-to-get-an-array-of-post-data-from-wp-query-result
        // See https://www.smashingmagazine.com/2016/03/advanced-wordpress-search-with-wp_query/
        // See https://stackoverflow.com/questions/3946506/crawling-a-html-page-using-php

        // An array of arguments
        //$args = array( 'arg_1' => 'val_1', 'arg_2' => 'val_2' );

        // The Query
        //$the_query = new WP_Query( $args );

        if ( !self::$img_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
            return;
        }

        if ( !self::$image_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
            return;
        }

        if ( !self::$img_image_table->update_all( 'status', 'invalid' ) ) {
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

                    if ( !self::$img_table->validate( $img ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$image_table->validate( $image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$img_image_table->validate( $img_image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$img_table->insert_unique( $img ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }
                        
                    if ( !self::$image_table->insert_unique( $image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$img_image_table->insert_unique( $img_image ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$img_table->update( 'status', 'valid', 'img_id', $img['img_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$img_table->update( 'attr_alt', $img['attr_alt'], 'img_id', $img['img_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$image_table->update( 'status', 'valid', 'image_id', $image['image_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$img_image_table->update( 'status', 'valid', 'img_image_id', $img_image['img_image_id'] ) ) {
                        add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !$img_fetch = self::$img_table->fetch( 'img_id', $img['img_id'] ) ) {
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
 
        /**
         * At this point, the three database tables, img, image, and 
         * img_image, contain ALL of their relevant data based on the
         * current website pages.
         */
        $img_image_table = self::init_table_registry( self::$img_image_table );
        $image_table     = self::init_table_registry( self::$image_table );
        $img_table       = self::init_table_registry( self::$img_table );

        //$img_image_table = self::$img_image_table->fetch_all();
        //$image_table     = self::$image_table->fetch_all();
        //$img_table       = self::$img_table->fetch_all();

        $master = ["img"=>$img_table, "image"=>$image_table, "img_image"=>$img_image_table];
        
        array_map(self::$add_settings_field["media"], [
            ["id"=>"media_files",
             "title"=>"Media Files",
             "callback"=>array("WP_Speak\Media_Option", "element_media_callback"),
             "args"=>array( "master" => $master )]
        ]);
        
        self::$registry->set( WP_Option::$option[ 'img_table' ],       self::init_table_registry( self::$img_table ) );
        self::$registry->set( WP_Option::$option[ 'image_table' ],     self::init_table_registry( self::$image_table ) );
        self::$registry->set( WP_Option::$option[ 'img_image_table' ], self::init_table_registry( self::$img_image_table ) );

        //self::$registry->init_table_registry(self::$img_table_title,       self::$img_table);
        //self::$registry->init_table_registry(self::$image_table_title,     self::$image_table);
        //self::$registry->init_table_registry(self::$img_image_table_title, self::$img_image_table);

        self::$wp_settings->register_setting(
            WP_Option::$option[ self::$section ],
            WP_Option::$option[ self::$section ],
            array(self::get_instance(), "validate_media_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            Option::$OPTION_LIST[self::$section] );
    }

    /**
     * The function init_table_registry() grabs all the values
     * from the given table, and stores the values in-cache.
     *
     * @param string $arg_table is the db table to grab.
     */
    public static function init_table_registry(
        $arg_table ) {

        $id      = $arg_table->id();
        $tag     = $arg_table->tag();
        $results = $arg_table->fetch_all();

        /**
         * Fetch_all() returns an array of rows,
         * where each row contains a single element for
         * each table column. While each table row
         * contains the primary key, each row
         * also contains a special key that 
         * uniquely identifies that row (aside from the
         * primary key itself.
         *
         * This function returns a table's rows, but rather
         * than return an array of rows indexed by the
         * primary key or by index, it returns
         * the row indexed by the special key that
         * is included as a value in the row itself.
         * 
         * This function simply reshapes
         * that array so that data can be retrieved
         * using the special key.
         */

        /**
         * For all the rows fetched from the table,
         * grab all the assorted data. Row_list is
         * a NEW list that I am creating from the
         * rows returned from the database.
         */
        $row_list = array();
        foreach ( $results as $result ) {

            /**
             * $result[ $id ] IS that special key.
             * The column name for that special key
             * is $id, which is based on the name
             * of the table.
             *
             * I am assigning the given row ($result)
             * into the new row_list array at an
             * index equal to that special key.
             */
            $row_list[ $result[ $id ] ] = $result;

        }

        /**
         * At this point, $row_list contains
         * the re-shaped contents of the table. I 
         * am storing that entire row set into my
         * in-process cache here.
         */
        return $row_list;
    }

    public static function element_media_callback($arg_list)
    {
        $max_width = Admin::WORDWRAP_WIDTH;
        
        $master = $arg_list["master"];
        $img_image_list  = $arg_list["master"]["img_image"];
        $img_list        = $arg_list["master"]["img"];
        $image_list      = $arg_list["master"]["image"];
        
        $master_json = json_encode($master);
        $html = "";

        $cnt = 0;
        foreach( $img_image_list as $img_image ) {
        
            $img_id       = $img_image['img_id'  ];
            $image_id     = $img_image['image_id'  ];
            $img_image_id = $img_image['img_image_id'];
            
            $img   = $img_list[   $img_id   ];
            $image = $image_list[ $image_id ];

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
        //self::$logger->log( self::$mask, "Validation: " . __FUNCTION__ );
        //self::$logger->log( self::$mask, "Input");
        //self::$logger->log( self::$mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();
        $output['media_files'] = array();

        if ( !isset($arg_input) )
        {
            return apply_filters(
                Filter::$validate[get_called_class()],
                $output,
                Option::$OPTION_LIST[self::$section]);
        }

        // Loop through each of the options sanitizing the data
        foreach( $arg_input as $key => $val )
        {
            if( isset ( $arg_input[$key] ) )
            {
                $output['media_files'][$key] = $arg_input[$key];
            }
        }

        /**
         * Now that I have sanitized the data, update
         * the database tables of the same. I am ONLY
         * updating the data that would change: ALT and
         * USE_ALT.
         */
        $element = "media_files";
        $total_cnt = $arg_input[$element . "_cnt"];
        
        for ($cnt = 1; $cnt <= $total_cnt ; $cnt++ ) {
        
            $img_id     = $arg_input[ "{$element}_img_id_{$cnt}" ];
            $custom_alt = $arg_input[ "{$element}_custom_alt_{$cnt}" ];
            $use_alt    = $arg_input[ "{$element}_sel_alt_{$cnt}" ];
            
            if ( !self::$img_table->update('alt', $custom_alt, 'img_id', $img_id) ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            if ( !self::$img_table->update('use_alt', $use_alt, 'img_id', $img_id) ) {
                add_settings_error( 'media_files', 'Media Files', Error::get_errmsg(), 'error' );
                return;
            }
            
        }
        
         // Return the new collection
        return apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST[self::$section]);

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
		assert( !is_null( $arg_image_table ) );
		self::$image_table = $arg_image_table;
		return $this;
	}
	
	public function set_img_table( $arg_img_table)
	{
		assert( !is_null( $arg_img_table ) );
		self::$img_table = $arg_img_table;
		return $this;
	}
	
	public function set_img_image_table( $arg_img_image_table)
	{
		assert( !is_null( $arg_img_image_table ) );
		self::$img_image_table = $arg_img_image_table;
		return $this;
	}
		
	public function set_db(DB $arg_db)
	{
		//assert( '!is_null($arg_logger)' );
		self::$db = $arg_db;
		return $this;
	}
	
}

?>
