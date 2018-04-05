<?php

namespace WordpressLockout\Lib;

/**
 * Simple wrapper around Wordpress' apply_filters function, to allow for mocking
 * in tests
 */
class Filters
{
    /**
     * Adds a filter using Wordpress' inbuilt function
     *
     * @param  string $filter
     * @param  any $default
     * @return any
     */
    public function add(string $filter, callable $method)
    {
        return add_filter($filter, $method);
    }

    /**
     * Applies a filter using Wordpress' inbuilt function
     *
     * @param  string $filter
     * @param  any $default
     * @return any
     */
    public function apply(string $filter, $default, $priority = 10)
    {
        return apply_filters($filter, $default);
    }
}
