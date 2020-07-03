<?php
namespace WP_Speak;

class Audio {

	private function __construct()
	{
		add_shortcode("wps_audio", array($this, "shortcode"));
    }

	public function shortcode($arg_atts, $arg_content = NULL)
	{
        $content = do_shortcode($arg_content);
        
        $src = WP_SPEAK_AUDIO_ONDEMAND_JS_URL;
        
        return "<!-- MALCOLM --><script text='{$content}' src='{$src}'></script>";
               
	}
	
}
