<?php
// define("WP_SPEAK_IMAGES_URL", "https://wp-speak.com/images/");

define("WP_SPEAK_PUBLIC_INCLUDES_URL", plugins_url()."/wp-speak/public/inc/");
define("WP_SPEAK_ADMIN_INCLUDES_URL",  plugins_url()."/wp-speak/admin/inc/");

define("WP_SPEAK_PUBLIC_DIST_URL",     plugins_url()."/wp-speak/public/js/dist/");
define("WP_SPEAK_PUBLIC_JS_URL",       plugins_url()."/wp-speak/public/js/src/");

define("WP_SPEAK_ADMIN_DIST_URL",      plugins_url()."/wp-speak/admin/js/dist/");
define("WP_SPEAK_ADMIN_JS_URL",        plugins_url()."/wp-speak/admin/js/src/");

// define("WP_SPEAK_JS_URL",        plugins_url()."/wp-speak/js/src/");
// define("WP_SPEAK_SHORTURL",      "https://wp-speak.com/");

define("WP_SPEAK_CSS_URL",         		  WP_SPEAK_PUBLIC_INCLUDES_URL . "wp-speak.css"); 
define("WP_SPEAK_ADMIN_CSS_URL",          WP_SPEAK_ADMIN_INCLUDES_URL  . "wp-speak-admin.css"); 

define("WP_SPEAK_INIT_JS_URL",            WP_SPEAK_ADMIN_JS_URL        . "wps-init.js"); 
define("WP_SPEAK_MAIN_JS_URL",            WP_SPEAK_ADMIN_DIST_URL      . "wps-main.js"); 

define("FONT_AWESOME_URL", "https://use.fontawesome.com/releases/v5.7.1/css/all.css?ver=1.0.41n");



// define("WP_SPEAK_NEWLINE", "\n");
// 
// define("WP_SPEAK_NULL_ALLOWED",    	TRUE);
// define("WP_SPEAK_NULL_DISALLOWED", 	FALSE);

define("WP_SPEAK_ENQUEUE_FOOTER",		TRUE);
define("WP_SPEAK_ENQUEUE_HEADER",		FALSE);

// define("WP_SPEAK_LOGMASK_ALL",		0x00FF);
// define("WP_SPEAK_LOGMASK_ADMIN",	0x0001);
// define("WP_SPEAK_LOGMASK_CACHE",	0x0002);
// define("WP_SPEAK_LOGMASK_COMM",		0x0004);
// define("WP_SPEAK_LOGMASK_CUSTOM",	0x0008);
// define("WP_SPEAK_LOGMASK_ENQUEUE",	0x0010);
// define("WP_SPEAK_LOGMASK_PRECACHE",	0x0020);

// define("WP_SPEAK_NO_MIN",				1);
// define("WP_SPEAK_NO_MAX",				999);
// 
// define("WP_SPEAK_ERRCODE_APP_SUCCESS",			"APP_200");
// define("WP_SPEAK_ERRCODE_APP",					"APP_");
// define("WP_SPEAK_ERRCODE_HTTP_FAILED_REQUEST",	"HTTP_404");
// define("WP_SPEAK_ERRCODE_HTTP",					"HTTP_");
// 
// define("WP_SPEAK_ERRMSG_EXPAND_BAD_COMM",			"Communication problem getting long url for %s%s:%s");
// define("WP_SPEAK_ERRMSG_EXPAND_BAD_JSON",			"Format problem getting long url for %s%s:%s");
// define("WP_SPEAK_ERRMSG_EXPAND_BAD_CREDENTIALS",	"Username or password is wrong for %s:%s");
// define("WP_SPEAK_ERRMSG_EXPAND_BAD_UNKNOWN",		"EXPAND Unknown Error for %s%s:%s ... please improve on this message");
// 
// define("WP_SPEAK_ERRMSG_SHORTEN_BAD_COMM",		"Communication problem getting long url for %s%s:%s");
// define("WP_SPEAK_ERRMSG_SHORTEN_BAD_JSON",		"Format problem getting long url for %s%s:%s");
// define("WP_SPEAK_ERRMSG_SHORTEN_BAD_CREDENTIALS",	"Username or password is wrong for %s:%s");
// define("WP_SPEAK_ERRMSG_SHORTEN_BAD_UNKNOWN",		"SHORTEN Unknown Error for %s%s:%s ... please improve on this message");
// 
// 
// define("WP_SPEAK_ERRMSG_BAD_AUTHOR",			"Bad Value. Argument('AUTHOR')");
// define("WP_SPEAK_ERRMSG_BAD_BASENAME",		"Bad Value. Argument('BASENAME')");
// define("WP_SPEAK_ERRMSG_BAD_BACKGROUND",		"Bad Value. Argument('BACKGROUND')");
// define("WP_SPEAK_ERRMSG_BAD_BUILDTYPE",		"Bad Value. Argument('BUILDTYPE')");
// define("WP_SPEAK_ERRMSG_BAD_COLOR",			"Bad Value. Argument('COLOR')");
// define("WP_SPEAK_ERRMSG_BAD_CSS_URL",			"Bad Value. Argument('CSS_URL')");
// define("WP_SPEAK_ERRMSG_BAD_DATE",			"Bad Value. Argument('DATE')");
// define("WP_SPEAK_ERRMSG_BAD_EMAIL",			"Bad Value. Argument('EMAIL')");
// define("WP_SPEAK_ERRMSG_BAD_HEIGHT",			"Bad Value. Argument('HEIGHT')");
// define("WP_SPEAK_ERRMSG_BAD_ID",				"Bad Value. Argument('ID')");
// define("WP_SPEAK_ERRMSG_BAD_LONGURL",			"Bad Value. Argument('LONGURL')");
// define("WP_SPEAK_ERRMSG_BAD_NO",				"Bad Value. Argument('NO')");
// define("WP_SPEAK_ERRMSG_BAD_SHORT",			"Bad Value. Argument('SHORT')");
// define("WP_SPEAK_ERRMSG_BAD_SHOWBORDER",		"Bad Value. Argument('SHOWBORDER')");
// define("WP_SPEAK_ERRMSG_BAD_SHOWTITLE",		"Bad Value. Argument('SHOWTITLE')");
// define("WP_SPEAK_ERRMSG_BAD_SHORTURL",		"Bad Value. Argument('URL')");
// define("WP_SPEAK_ERRMSG_BAD_USECACHE",		"Bad Value. Argument('USECACHE')");
// define("WP_SPEAK_ERRMSG_BAD_USECUSTOM",		"Bad Value. Argument('USECUSTOM')");
// define("WP_SPEAK_ERRMSG_BAD_USEIFRAME",		"Bad Value. Argument('USEIFRAME')");
// define("WP_SPEAK_ERRMSG_BAD_VERSION",			"Bad Value. Argument('VERSION')");
// define("WP_SPEAK_ERRMSG_BAD_WIDTH",			"Bad Value. Argument('WIDTH')");
// define("WP_SPEAK_ERRMSG_BAD_COMBINATION",		"You must set exactly one of either URL, LONGURL, or ID");		// Waiting on these two
// define("WP_SPEAK_ERRMSG_BAD_SMALL_COMBINATION",		"You must set exactly one of either URL or LONGURL");
// 
// define("WP_SPEAK_DEFAULT_BACKGROUND",			"white");
// define("WP_SPEAK_DEFAULT_BUILDTYPE",			"re-package");
// define("WP_SPEAK_DEFAULT_COLOR",				"black");
// define("WP_SPEAK_DEFAULT_COPYRIGHT_AUTHOR",	null);
// define("WP_SPEAK_DEFAULT_COPYRIGHT_DATE",		null);
// define("WP_SPEAK_DEFAULT_COPYRIGHT_EMAIL",	null);
// define("WP_SPEAK_DEFAULT_COPYRIGHT_SHORT",	null);
// define("WP_SPEAK_DEFAULT_HEIGHT",				"500px");
// define("WP_SPEAK_DEFAULT_ID",					null);
// define("WP_SPEAK_DEFAULT_LONGURL",			null);
// define("WP_SPEAK_DEFAULT_NO",					"1");
// define("WP_SPEAK_DEFAULT_SHOWBORDER",			"FALSE");
// define("WP_SPEAK_DEFAULT_SHOWTITLE",			"TRUE");
// define("WP_SPEAK_DEFAULT_URL",				null);
// define("WP_SPEAK_DEFAULT_USECACHE",			"TRUE");
// define("WP_SPEAK_DEFAULT_USECUSTOM",			"TRUE");
// define("WP_SPEAK_DEFAULT_USEIFRAME",			"TRUE");
// define("WP_SPEAK_DEFAULT_VERSION",			"1.0");
// define("WP_SPEAK_DEFAULT_WIDTH",				"450px");
// define("WP_SPEAK_DEFAULT_PREVIEW",			null);
// 
// define("WP_SPEAK_ADD_POST_META_UNIQUE",		TRUE);
// define("WP_SPEAK_ADD_POST_META_NON_UNIQUE",	FALSE);
// define("WP_SPEAK_GET_POST_META_STRING",		TRUE);
// define("WP_SPEAK_GET_POST_META_ARRAY",		FALSE);
?>
