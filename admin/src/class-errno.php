<?php
/**
 * Errno defines the error names and maps these names to error numbers.
 *
 * I would have made this array of terms a constant BUT earlier
 * versions of php do not support constant arrays.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Errno defines the error names and maps these names to numbers.
 */
class Errno {

	/**
	 * The constants below delineate each of the error numbers.
	 */
    const ERR_NO_PREPARE      = 9;
    const ERR_NO_UPDATE_ALL   = 8;
    const ERR_NO_UPDATE       = 7;
    const ERR_NO_EMPTY_STRING = 6;
    const ERR_NO_NULL_VALUE   = 5;
    const ERR_NO_BAD_VALUE    = 4;
    const ERR_NO_BAD_INSERT   = 3;
    const ERR_NO_BAD_COLUMN   = 2;
    const ERR_NO_INSERT       = 1;
    const ERR_NO_OKAY         = 0;

}

