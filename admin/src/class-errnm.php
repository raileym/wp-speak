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

	/**
	 * The mapping of error names to error numbers. I am leaving
	 * this construct as a variable NOT a constant to support
	 * earlier versions of PHP. Also, I am choosing to make this
	 * array public, at least for testing purposes.
	 *
	 * @var $NM
	 */
	public static $nm = array(
		'ERR_DB_PREPARE'      => 9,
		'ERR_DB_UPDATE_ALL'   => 8,
		'ERR_DB_UPDATE'       => 7,
		'ERR_DB_EMPTY_STRING' => 6,
		'ERR_DB_NULL_VALUE'   => 5,
		'ERR_DB_BAD_VALUE'    => 4,
		'ERR_DB_BAD_INSERT'   => 3,
		'ERR_DB_BAD_COLUMN'   => 2,
		'ERR_DB_INSERT'       => 1,
		'ERR_DB_OKAY'         => 0,
	);
}

