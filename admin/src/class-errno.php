<?php
namespace WP_Speak;

interface Errno
{
    const ERR_DB_PREPARE      = 9;
    const ERR_DB_UPDATE_ALL   = 8;
    const ERR_DB_UPDATE       = 7;
    const ERR_DB_EMPTY_STRING = 6;
    const ERR_DB_NULL_VALUE   = 5;
    const ERR_DB_BAD_VALUE    = 4;
    const ERR_DB_BAD_INSERT   = 3;
    const ERR_DB_BAD_COLUMN   = 2;
    const ERR_DB_INSERT       = 1;
    const OKAY                = 0;
}
?>
