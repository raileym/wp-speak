<?php
namespace WP_Speak;

class Image_Option extends Basic
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
	private static $section = "image_option";
	private static $fields = array (
            "image"
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
     *	Orchestrates the creation of the Image Panel
     */
    public static function init($arg1)
    {
        self::$logger->log( self::$mask, get_called_class() . " " . __FUNCTION__ );

        $option = self::$wp_option->get( get_called_class() );

        if( !$option )
        {
            self::$wp_option->update( get_called_class(), self::filter_default_options( self::$default_options ) );
            $option = self::$wp_option->get( get_called_class() );
        }

        $paragraph = <<<EOD
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis euismod ut nisl nec tincidunt. Donec quis tempus dui. Nam venenatis ullamcorper metus, at semper velit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus interdum egestas aliquam. Etiam efficitur, dolor et dignissim sagittis, ante nunc pellentesque nulla, ut tempus diam sapien lacinia dui. Curabitur lobortis urna a faucibus volutpat. Sed eget risus pharetra, porta risus et, fermentum ligula. Mauris sed hendrerit ex, sed vulputate lorem. Duis in lobortis justo. Aenean mattis odio tortor, sit amet fermentum orci tempus ut. Donec vitae elit facilisis, tincidunt augue id, tempus elit. Nullam sapien est, gravida nec luctus non, rhoncus vitae magna. Fusce dolor justo, ultricies non efficitur vitae, interdum in tortor.
EOD;

        array_map( self::$add_settings_section, [
            ["id"=>Admin::WPS_ADMIN."image",
             "title"=>"Image Files",
             "callback"=>Callback::PARAGRAPH,
             "args"=>array( "paragraph" => $paragraph )]
        ]);


        if ( !self::$image_table->update_all( 'status', 'invalid' ) ) {
            add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
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
                    
                    if ( !self::$image_table->validate( $image ) ) {
                        add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                        return;
                    }
            
                    if ( !self::$image_table->insert_unique( $image ) ) {
                        add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                    if ( !self::$image_table->update( 'status', 'valid', 'image_id', $image['image_id'] ) ) {
                        add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                        return;
                    }

                }
                
            }

        }
        /* Restore original Post Data */
        wp_reset_postdata();
 
        $image_table     = self::init_table_registry( self::$image_table );
        //$image_table     = self::$image_table->fetch_all();

        $master = ["image"=>$image_table];
        
        array_map( self::$add_settings_field["image"], [
            ["id"=>"image_files",  "title"=>"Image Files", "callback"=>array("WP_Speak\Image_Option", "element_image_callback"), "args"=>array( "master" => $master )]
        ]);

        self::$registry->set( WP_Option::$option[ 'image_table' ], self::init_table_registry( self::$image_table ) );

        register_setting(
            WP_Option::$option[ get_called_class() ],
            WP_Option::$option[ get_called_class() ],
            array(self::get_instance(), "validate_image_option")
        );

        do_action(
            Action::$init[get_called_class()],
            get_called_class(),
            $option );

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

    public static function element_image_callback($arg_list)
    {
        $max_width = Admin::WORDWRAP_WIDTH;
        
        $image_list      = $arg_list["master"]["image"];

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
        //self::$logger->log( self::$mask, "Validation: " . __FUNCTION__ );
        //self::$logger->log( self::$mask, "Input");
        //self::$logger->log( self::$mask, print_r( $arg_input, true ) );

        // Define the array for the updated options
        $output = array();
        $output['image_files'] = array();

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
                $output['image_files'][$key] = $arg_input[$key];
            }
        }

        $element = "image_files";
        $total_cnt = $arg_input[$element . "_cnt"];
        
        for ($cnt = 1; $cnt <= $total_cnt ; $cnt++ ) {
        
            $image_id   = $arg_input[ "{$element}_image_id_{$cnt}" ];
            $custom_alt = $arg_input[ "{$element}_custom_alt_{$cnt}" ];
            
            if ( !self::$image_table->update('alt', $custom_alt, 'image_id', $image_id) ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
            
        }
        
        
        
        // Return the new collection
        return apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST["image_option"]);

        $master = json_decode($arg_input["image_files"], true);
        
        foreach( $master["img_image"] as $img_image ) {
        
            $img   = $master["img"  ][ $img_image["img_id"] ];
            $image = $master["image"][ $img_image["image_id"] ];
            
            if ( !self::$img_table->validate( $img ) ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            if ( !self::$image_table->validate( $image ) ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
            
            $img_id = self::$img_table->insert($img);
            if ( FALSE === $img_id ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }

            $image_id = self::$image_table->insert($image);
            if ( FALSE === $image_id ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }

            $img_image_id = self::$img_image_table->insert( array("img_id" => $img_id, "image_id" => $image_id) );
            if ( FALSE === $img_image_id ) {
                add_settings_error( 'image_files', 'Image Files', Error::get_errmsg(), 'error' );
                return;
            }
        }
        
        // Return the new collection
        return apply_filters(
            Filter::$validate[get_called_class()],
            $output,
            Option::$OPTION_LIST["image_option"]);
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
		self::$image_table = $arg_image_table;
		return $this;
	}
	
	public function set_img_table( $arg_img_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$img_table = $arg_img_table;
		return $this;
	}
	
	public function set_img_image_table( $arg_img_image_table)
	{
		//assert( '!is_null($arg_registry)' );
		self::$img_image_table = $arg_img_image_table;
		return $this;
	}
		
    public function set_add_settings_section($arg_add_settings_section)
	{
		//assert( '!is_null($arg_registry)' );
		self::$add_settings_section = $arg_add_settings_section->create(
            get_called_class() );
		return $this;
	}
	
    public function set_add_settings_field($arg_add_settings_field)
	{
		//assert( '!is_null($arg_registry)' );
		foreach(self::$fields as $field) {
            self::$add_settings_field[$field] = $arg_add_settings_field->create(
                get_called_class(),
                Admin::WPS_ADMIN.$field);
		}
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
