<?php

namespace WordpressLockout\Lib;

class Response
{
    /**
     * Declares data as variables, shows template and dies
     *
     * @param  string $file
     * @param  array $data
     * @return void
     */
    public function template(string $file, array $data = [])
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        require($file);
        exit;
    }
}
