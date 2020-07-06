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

	/**
	 * The mapping of error names to error numbers. I am leaving
	 * this construct as a variable NOT a constant to support
	 * earlier versions of PHP. Also, I am choosing to make this
	 * array public, at least for testing purposes.
	 *
	 * @var $errno
	 */
	public static $errno = array(
		self::ERR_NM_PREPARE      => self::ERR_NO_PREPARE,
		self::ERR_NM_UPDATE_ALL   => self::ERR_NO_UPDATE_ALL,
		self::ERR_NM_UPDATE       => self::ERR_NO_UPDATE,
		self::ERR_NM_EMPTY_STRING => self::ERR_NO_EMPTY_STRING,
		self::ERR_NM_NULL_VALUE   => self::ERR_NO_NULL_VALUE,
		self::ERR_NM_BAD_VALUE    => self::ERR_NO_BAD_VALUE,
		self::ERR_NM_BAD_INSERT   => self::ERR_NO_BAD_INSERT,
		self::ERR_NM_BAD_COLUMN   => self::ERR_NO_BAD_COLUMN,
		self::ERR_NM_INSERT       => self::ERR_NO_INSERT,
		self::ERR_NM_OKAY         => self::ERR_NO_OKAY
	);

	/**
	 * The mapping of error names to error numbers. I am leaving
	 * this construct as a variable NOT a constant to support
	 * earlier versions of PHP. Also, I am choosing to make this
	 * array public, at least for testing purposes.
	 *
	 * @var $errnm
	 */
	public static $errnm = array(
		self::ERR_NO_PREPARE      => self::ERR_NM_PREPARE,
		self::ERR_NO_UPDATE_ALL   => self::ERR_NM_UPDATE_ALL,
		self::ERR_NO_UPDATE       => self::ERR_NM_UPDATE,
		self::ERR_NO_EMPTY_STRING => self::ERR_NM_EMPTY_STRING,
		self::ERR_NO_NULL_VALUE   => self::ERR_NM_NULL_VALUE,
		self::ERR_NO_BAD_VALUE    => self::ERR_NM_BAD_VALUE,
		self::ERR_NO_BAD_INSERT   => self::ERR_NM_BAD_INSERT,
		self::ERR_NO_BAD_COLUMN   => self::ERR_NM_BAD_COLUMN,
		self::ERR_NO_INSERT       => self::ERR_NM_INSERT,
		self::ERR_NO_OKAY         => self::ERR_NM_OKAY
	);
}

