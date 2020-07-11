<?php
namespace WP_Speak;

class SQL 
{
	public static $columns = array(
	
	    "img" => array(
            "attr_alt",
            "alt",
            "attr_class",
            "attr_id",
            "use_alt",
            "img_id",
            "status",
            "wp_post_id",
            "wp_post_title"
            ),

        "image" => array(
            "src",
            "alt",
            "path",
            "img",
            "image_id",
            "status",
            "title"
            ),

        "img_image" => array(
            "img_image_id",
            "img_id",
            "image_id",
            "status"
            )

	    );
	    
	public static $create_table_sql = array(
	
    	"img" => "CREATE TABLE %s (
            id            mediumint(9)  NOT NULL AUTO_INCREMENT,
            attr_alt      varchar(1024) NOT NULL,
            alt           varchar(1024) NOT NULL,
            attr_class    varchar(255)  NOT NULL,
            attr_id       varchar(255)  NOT NULL,
            use_alt       varchar(255)  NOT NULL,
            img_id        varchar(255)  NOT NULL,
            status        varchar(8)    NOT NULL,
            wp_post_id    bigint(20)    NOT NULL,
            wp_post_title varchar(1024) NOT NULL,
            PRIMARY KEY ID (id)
            ) %s;",
            
        "image" => "CREATE TABLE %s (
            id          mediumint(9)  NOT NULL AUTO_INCREMENT,
            src         varchar(1024) NOT NULL,
            alt         varchar(1024) NOT NULL,
            path        varchar(1024) NOT NULL,
            img         varchar(1024) NOT NULL,
            image_id    varchar(255)  NOT NULL,
            status      varchar(8)    NOT NULL,
            title       varchar(255)  NOT NULL,
            PRIMARY KEY ID (id)
            ) %s;",
            
        "img_image" => "CREATE TABLE %s (
            id           mediumint(9) NOT NULL AUTO_INCREMENT,
            img_image_id varchar(32)  NOT NULL,
            img_id       varchar(32)  NOT NULL,
            image_id     varchar(32)  NOT NULL,
            status       varchar(8)   NOT NULL,
            PRIMARY KEY id (id)
            ) %s;"

    );
    	
}

?>
