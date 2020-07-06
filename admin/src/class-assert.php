<?php
namespace WP_Speak;

class Assert {

    const ASSERT_UNDEFINED       = "%s ('%s') is undefined.";
    const ASSERT_OUT_OF_BOUNDS   = "%s ('%s') is out-of-bounds.";
    const ASSERT_INDEX_NOT_FOUND = "%s ('%s') not found.";

    public static function is_gte($arg_higher, $arg_lower) {
        return $arg_higher >= $arg_lower;
    }

    public static function is_gt($arg_higher, $arg_lower) {
        return $arg_higher > $arg_lower;
    }

    public static function is_lte($arg_lower, $arg_higher) {
        return $arg_lower <= $arg_higher;
    }

    public static function is_lt($arg_lower, $arg_higher) {
        return $arg_lower < $arg_higher;
    }

    public static function in_range($arg_value, $arg_low_range, $arg_high_range) {
        return $arg_value >= $arg_low_range && $arg_value < $arg_high_range;
    }

}
