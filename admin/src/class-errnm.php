<?php
namespace WP_Speak;

interface Errnm
{
    const NM = array(
        Error::ERR_DB_PREPARE      => "ERR_DB_PREPARE",
        Error::ERR_DB_UPDATE_ALL   => "ERR_DB_UPDATE_ALL",
        Error::ERR_DB_UPDATE       => "ERR_DB_UPDATE",
        Error::ERR_DB_EMPTY_STRING => "ERR_DB_EMPTY_STRING",
        Error::ERR_DB_NULL_VALUE   => "ERR_DB_NULL_VALUE",
        Error::ERR_DB_BAD_VALUE    => "ERR_DB_BAD_VALUE",
        Error::ERR_DB_BAD_INSERT   => "ERR_DB_BAD_INSERT",
        Error::ERR_DB_BAD_COLUMN   => "ERR_DB_BAD_COLUMN",
        Error::ERR_DB_INSERT       => "ERR_DB_INSERT",
        Error::OKAY                => "OKAY"
    );
}
?>
