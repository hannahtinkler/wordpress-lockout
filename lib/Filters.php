<?php

namespace WordpressLockout\Lib;

/**
 * Simple wrapper around Wordpress' apply_filters function, to allow for mocking
 * in tests
 */
class Filters
{
    /**
     * Apply a filter using Wordpress' inbuilt function
     *
     * @param  string $filter
     * @param  any $default
     * @return any
     */
    public function filter(string $filter, $default, $priority = 10)
    {
        return add_filter($filter, $default);
    }
}
