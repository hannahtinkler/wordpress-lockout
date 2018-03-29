<?php

namespace WordpressLockout;

use WordpressLockout\Lib\Filters;
use WordpressLockout\Lib\Lockout;
use WordpressLockout\Lib\Settings;
use WordpressLockout\Lib\Response;
use WordpressLockout\Lib\SettingsPage;

/**
 * Plugin base file. Controls initialisation of Plugin.
 */
class Core
{
    /**
     * Plugin setup and functonality goes here
     *
     * @return void
     */
    public function initialise()
    {
        $filters = new Filters;
        $settings = new Settings;
        $response = new Response;

        new Lockout($settings, $response, $filters);
        new SettingsPage($settings, $response, $filters);
    }
}
