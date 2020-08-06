<?php
/**
 * Errnm defines the error names and maps these names to numerics.
 *
 * I would have made this array of terms a constant BUT earlier
 * versions of php do not support constant arrays.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Errnm defines the error names and maps these names to numerics.
 */
class Errnm {

    const ERR_NM_PREPARE      = "ERR_NM_PREPARE";
    const ERR_NM_UPDATE_ALL   = "ERR_NM_UPDATE_ALL";
    const ERR_NM_UPDATE       = "ERR_NM_UPDATE";
    const ERR_NM_EMPTY_STRING = "ERR_NM_EMPTY_STRING";
    const ERR_NM_NULL_VALUE   = "ERR_NM_NULL_VALUE";
    const ERR_NM_BAD_VALUE    = "ERR_NM_BAD_VALUE";
    const ERR_NM_BAD_INSERT   = "ERR_NM_BAD_INSERT";
    const ERR_NM_BAD_COLUMN   = "ERR_NM_BAD_COLUMN";
    const ERR_NM_INSERT       = "ERR_NM_INSERT";
    const ERR_NM_OKAY         = "ERR_NM_OKAY";

}

