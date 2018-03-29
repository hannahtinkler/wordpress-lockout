<?php

namespace CmsLockout\Lib;

use WP_User;
use CmsLockout\Lib\Settings;
use CmsLockout\Lib\Response;

class Lockout
{
    /**
     * @var CmsLockout\Lib\Settings
     */
    private $settings;

    /**
     * @var CmsLockout\Lib\Response
     */
    private $response;

    /**
     * Message shown to the user when they have been locked out
     * @var string
     */
    private $lockoutMessageFilterName = 'cms_lockout:locked_out_message';

    /**
     * Binds lockout functionality to user login
     * @param Settings $settings
     */
    public function __construct(Settings $settings, Response $response)
    {
        $this->settings = $settings;
        $this->response = $response;

        add_action('wp_login', [$this, 'lockoutIfRequired'], null, 2);
    }

    /**
     * Checks if lockout is enabled and if the user trying to log in should be
     * locked out
     *
     * @param  string $username
     * @param  WP_User $user
     * @return void
     */
    public function lockoutIfRequired(string $username, WP_User $user)
    {
        $isLocked = $this->settings->getLockedStatus();
        $lockedUsers = $this->settings->getLockedUsers();

        if ($isLocked && in_array($user->ID, $lockedUsers)) {
            $this->redirectToLockedOutPage();
        }
    }

    /**
     * Shows locked out page with custom or default message
     *
     * @return void
     */
    private function redirectToLockedOutPage()
    {
        $template = __DIR__ . '/../templates/locked-out.php';

        $message = apply_filters(
            $this->lockoutMessageFilterName,
            "You're currently locked out from this CMS"
        );

        $this->response->template($template, compact('message'));
    }
}
