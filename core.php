<?php

namespace CmsLockout;

use CmsLockout\Lib\Settings;
use CmsLockout\Lib\Response;
use CmsLockout\Lib\SettingsPage;
use CmsLockout\Lib\Lockout;

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
        $settings = new Settings;
        $response = new Response;

        new Lockout($settings, $response);
        new SettingsPage($settings, $response);
    }
}
