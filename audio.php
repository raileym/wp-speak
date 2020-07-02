<?php
namespace WP_Speak;

class Audio {

    private static $_instance;
    private static $_logger;
    private static $_registry;

    private function __construct() { }

    public function wps_enqueue_speak_scripts() {
        $params = array(
          'url'      => admin_url('admin-ajax.php'),
          'audio'    => wp_create_nonce('audio-hWLv9nsqfN6UtyVyVzsL'),
          'speak'    => "https://".$_SERVER['SERVER_NAME']."/speak/",
          'name'     => 'malcolm'
        );
        wp_localize_script("wps-main", 'AJAX', $params );
    }

    public function init() {
        add_action("wp_enqueue_scripts",    array(self::$_instance, "wps_enqueue_speak_scripts") );
        add_action("admin_enqueue_scripts", array(self::$_instance, "wps_enqueue_speak_scripts") );

        add_action( 'wp_ajax_wps_speak',         array(self::$_instance, "wps_speak_callback") );
        add_action( 'wp_ajax_nopriv_wps_speak',  array(self::$_instance, "wps_speak_callback") ); 
    
        return true;
    }
    
    public static function get_instance()
    {
        if ( is_null(self::$_instance) ) {
            self::$_instance = new self;
            self::$_instance->init();
        }

        return self::$_instance;
//         self::$_instance->init();
//         is_null(self::$_instance) && self::$_instance = new self;
//         return self::$_instance;
    }

	public function set_logger(Logger $arg_logger )
	{
		//assert( '!is_null($arg_logger)' );
		self::$_logger = $arg_logger;
		return $this;
	}
	
	public function set_registry(Registry $arg_registry )
	{
		//assert( '!is_null($arg_registry)' );
		self::$_registry = $arg_registry;
		return $this;
	}
	
    public function wps_speak_callback() {

        check_ajax_referer( 'audio-hWLv9nsqfN6UtyVyVzsL', 'audio' );

        $file  = $_POST['file'];

        $response = array();
        $response["name"] = "malcolm";
        $response["file"] = $file;   https://wp-speak.com/wp-speak-audio/123/
        $response["mp3"]  = "https://".$_SERVER['SERVER_NAME']."/wp-speak-audio/".$file."?audio=".$_POST['audio'];

        $words = "<speak version='1.0' xmlns='www.w3.org/2001/10/synthesis' xml:lang='en-US'>".$_POST['words']."</speak>";

        $extension = "mp3";
        $mime_type = "audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3";

        if(file_exists(ABSPATH . "audio/".$file.".mp3")) {
            //$data["ibm"] = file_get_contents(ABSPATH . "audio/".$file.".mp3");
            $response["status"] = "cached";
            echo json_encode($response);
            wp_die();
        }

        $words = str_replace(array("\\'",'\\"'), array("'",'"'), $words);
    
        file_put_contents(ABSPATH . "audio/".$file.".txt", $words);

        // $data = array("text" => "{$words}");                                                                    
        $data = array("text" => $words, "voice" => "en-US_AllisonVoice");                                                                    
        $data_string = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.us-south.text-to-speech.watson.cloud.ibm.com/instances/866a24a9-30b7-468f-ad74-ecc9004afdf0/v1/synthesize?voice=en-US_MichaelV2Voice");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: audio/wav'
            ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_VERBOSE, 0); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 866a24a9-30b7-468f-ad74-ecc9004afdf0

        // APIKEY instead
        curl_setopt($ch, CURLOPT_USERPWD, "apikey:JG6tQ0Fp3Ag3RmOGkc_eYy6zD6QoWmyMxTg-hsu1VIdW");

        $output = curl_exec ($ch);
        curl_close ($ch);

        file_put_contents(ABSPATH . "audio/".$file.".mp3", $output);

        $response["status"] = "new";
        echo json_encode($response);

        wp_die();
    }

    function wp_speak_getfile() {

        $nonce = get_query_var( 'audio' );
        if ( ! wp_verify_nonce( $nonce, 'audio-hWLv9nsqfN6UtyVyVzsL' ) ) {
            exit;
        }

        //
        // See https://console.bluemix.net/docs/services/text-to-speech/SSML-elements.html#say-as_element
        //
        function return_file($file) {
            $mime_type = "audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3";

            header('Content-type: {$mime_type}');
            header('Content-length: ' . filesize($file));
            header('Content-Disposition: filename="' . $file);
            header('X-Pad: avoid browser bug');
            header('Cache-Control: no-cache');
            readfile($file);
        }

        $file = get_query_var( 'wp-speak-audio' );
        //$file  = $_GET['wp-speak-audio'];

        if(file_exists(ABSPATH . "audio/".$file.".mp3")) {
            return_file(ABSPATH . "audio/".$file.".mp3");
            exit;
        }

        exit;
    }


}

