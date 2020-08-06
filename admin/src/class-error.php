<?php
/**
 * Error provides the assorted constructs for error-handling.
 *
 * Error includes all the functions to handle errno, errnm,
 * errmsg, and errlog.
 *
 * @file
 * @package admin
 */

namespace WP_Speak;

/**
 * Error provides the assorted constructs for error-handling.
 */
class Error extends Basic {


    protected static $instance;

    /**
     * $mask is the local (protected) copy of mask.
     *
     * @var int $mask
     */
    protected static $mask;

    /**
     * $errno_idx is an index into the errno array.
     *
     * @var int $errno_idx.
     */
    private static $errno_idx;

    /**
     * $errnm_idx is an index into the errnm array.
     *
     * @var int $errnm_idx.
     */
    private static $errnm_idx;

    /**
     * $errmsg is a string handle to the errmsg.
     *
     * @var int $errmsg.
     */
    private static $errmsg;

    /**
     * $errlog is a string handle to the errlog.
     *
     * @var int $errlog.
     */
    private static $errlog = '';

    /**
     * $use_errlog_ind is an indicator on whether to
     * write to the errlog.
     *
     * @var int $use_errlog_ind.
     */
    private static $use_errlog_ind = true;

    /**
     * $use_print_errlog_ind is an indicator on whether to
     * print the errlog.
     *
     * @var int $use_print_errlog_ind.
     */
    private static $use_print_errlog_ind = false;

	/**
	 * The mapping of error names to error numbers. I am leaving
	 * this construct as a variable NOT a constant to support
	 * earlier versions of PHP. Also, I am choosing to make this
	 * array public, at least for testing purposes.
	 *
	 * @var $errno
	 */
	public static $errno = array(
		Errnm::ERR_NM_PREPARE      => Errno::ERR_NO_PREPARE,
		Errnm::ERR_NM_UPDATE_ALL   => Errno::ERR_NO_UPDATE_ALL,
		Errnm::ERR_NM_UPDATE       => Errno::ERR_NO_UPDATE,
		Errnm::ERR_NM_EMPTY_STRING => Errno::ERR_NO_EMPTY_STRING,
		Errnm::ERR_NM_NULL_VALUE   => Errno::ERR_NO_NULL_VALUE,
		Errnm::ERR_NM_BAD_VALUE    => Errno::ERR_NO_BAD_VALUE,
		Errnm::ERR_NM_BAD_INSERT   => Errno::ERR_NO_BAD_INSERT,
		Errnm::ERR_NM_BAD_COLUMN   => Errno::ERR_NO_BAD_COLUMN,
		Errnm::ERR_NM_INSERT       => Errno::ERR_NO_INSERT,
		Errnm::ERR_NM_OKAY         => Errno::ERR_NO_OKAY
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
		Errno::ERR_NO_PREPARE      => Errnm::ERR_NM_PREPARE,
		Errno::ERR_NO_UPDATE_ALL   => Errnm::ERR_NM_UPDATE_ALL,
		Errno::ERR_NO_UPDATE       => Errnm::ERR_NM_UPDATE,
		Errno::ERR_NO_EMPTY_STRING => Errnm::ERR_NM_EMPTY_STRING,
		Errno::ERR_NO_NULL_VALUE   => Errnm::ERR_NM_NULL_VALUE,
		Errno::ERR_NO_BAD_VALUE    => Errnm::ERR_NM_BAD_VALUE,
		Errno::ERR_NO_BAD_INSERT   => Errnm::ERR_NM_BAD_INSERT,
		Errno::ERR_NO_BAD_COLUMN   => Errnm::ERR_NM_BAD_COLUMN,
		Errno::ERR_NO_INSERT       => Errnm::ERR_NM_INSERT,
		Errno::ERR_NO_OKAY         => Errnm::ERR_NM_OKAY
	);






    /**
     * The function set_errnm sets the current index
     * for the errnm array. The function checks whether
     * the index is out-of-range.
     *
     * @param int $arg_errnm_idx is an index into errnm.
     */
    public function set_errnm( $arg_errnm_idx ) {
        assert( array_key_exists( $arg_errnm_idx, self::$errno ), sprintf( Assert::ASSERT_UNDEFINED, 'arg_errnm_idx', $arg_errnm_idx ) );

        self::$errnm_idx = $arg_errnm_idx;
        self::$errno_idx = self::$errno[ $arg_errnm_idx ];

    }

    /**
     * The function set_errno sets the current index
     * for the errno array.
     *
     * @param int $arg_errno_idx is an index into errno.
     */
    public function set_errno( $arg_errno_idx ) {
        assert( Assert::in_range( $arg_errno_idx, 0, count( self::$errno ) ), sprintf( Assert::ASSERT_OUT_OF_BOUNDS, 'arg_errno_idx', $arg_errno_idx ) );

        self::$errno_idx = $arg_errno_idx;
        self::$errnm_idx = self::$errnm[ $arg_errno_idx ];

    }

    /**
     * The function get_errnm gets the current index
     * for the errnm array.
     */
    public function get_errnm() {
        assert( array_key_exists( self::$errno_idx, self::$errnm ), sprintf( Assert::ASSERT_INDEX_NOT_FOUND, 'errno_idx', self::$errno_idx ) );
        return self::$errnm_idx;
    }

    /**
     * The function get_errno gets the current index
     * for the errno array.
     */
    public function get_errno() {
        assert( array_key_exists( self::$errnm_idx, self::$errno ), sprintf( Assert::ASSERT_INDEX_NOT_FOUND, 'errnm_idx', self::$errnm_idx ) );
        return self::$errno_idx;
    }

    /**
     * The function clear_errlog simply resets the errlog.
     */
    public function clear_errlog() {
        self::$errlog = '';
    }

    /**
     * The function write_errlog writes to the errlog.
     *
     * @param string $arg_message is the message to write.
     * @param bool   $arg_print_errlog_ind denotes whether to print the log.
     */
    public function write_errlog(
        $arg_message,
        $arg_print_errlog_ind = true ) {

        if ( WP_DEBUG !== true ) {
            return;
        }

        if ( is_array( $arg_message ) || is_object( $arg_message ) ) {
            $message = print_r( $arg_message, true );
        } else {
            $message = $arg_message;
        }
        
        self::$errlog .= $message . PHP_EOL;
        
        if ( $arg_print_errlog_ind ) {
            self::print_errlog();
        }
    }

    /**
     * The function print_errlog simply prints the errlog to error_log.
     */
    public function print_errlog() {
        error_log( self::get_errlog( true ) );
    }

    /**
     * The function clear_errmsg simply resets the errmsg.
     */
    public function clear_errmsg() {
        self::$errmsg = '';
    }

    /**
     * The function set_errmsg assigns a value to the errmsg,
     * which can include a string of values for errmsg. This
     * function will also assign the errmsg to errlog, if
     * appropriate.
     *
     * @param string $arg_errmsg is the incoming errmsg.
     * @param string ...$args is any extra arguments (for sprintf).
     */
    public function set_errmsg( $arg_errmsg = null, ...$args ) {

        if ( empty( $arg_errmsg ) ) {

            self::$errmsg = self::get_errnm();

        } elseif ( empty( self::$errmsg ) ) {

            self::$errmsg = self::get_errnm() . ': ' . vsprintf( $arg_errmsg, $args );

        } else {

            self::$errmsg = self::get_errnm() . ': ' . vsprintf( $arg_errmsg, $args ) . '. ' . self::$errmsg;

        }

        if ( self::$use_errlog_ind && empty( self::$errlog ) ) {

            self::$errlog = self::$errmsg;

        } elseif ( self::$use_errlog_ind ) {

            self::$errlog .= PHP_EOL . self::$errmsg;

        }

        if ( self::$use_print_errlog_ind ) {

            self::print_errlog();

        }

    }

    /**
     * The function get_errmsg returns the current value
     * for errmsg. This function resets errmsg by default.
     *
     * @param string $arg_clear_errmsg_ind denotes whether to reset errmsg.
     */
    public function get_errmsg( $arg_clear_errmsg_ind = true ) {

        $errmsg = self::$errmsg;

        if ( $arg_clear_errmsg_ind ) {
            self::clear_errmsg();
        }

        return $errmsg;
    }

    /**
     * The function get_errlog returns the current value
     * for errlog. This function resets errlog by default.
     *
     * @param string $arg_clear_errlog_ind denotes whether to reset errmsg.
     */
    public function get_errlog( $arg_clear_errlog_ind = true ) {

        $errlog = trim( self::$errlog );

        if ( $arg_clear_errlog_ind ) {
            self::clear_errlog();
        }

        return $errlog;
    }

}

