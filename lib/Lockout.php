<?php

namespace WordpressLockout\Lib;

use WP_User;
use WordpressLockout\Lib\Filters;
use WordpressLockout\Lib\Response;
use WordpressLockout\Lib\Settings;

/**
 * Determines whether a user should be locked out upon login and returns response
 * template if so.
 */
class Lockout
{
    /**
     * @var WordpressLockout\Lib\Settings
     */
    private $settings;

    /**
     * @var WordpressLockout\Lib\Response
     */
    private $response;

    /**
     * @var WordpressLockout\Lib\Filters
     */
    private $filters;

    /**
     * Message shown to the user when they have been locked out
     * @var string
     */
    private $lockoutMessageFilterName = 'wordpress_lockout:locked_out_message';

    /**
     * Binds lockout functionality to user login
     * @param Settings $settings
     */
    public function __construct(
        Settings $settings,
        Response $response,
        Filters $filters
    ) {
        $this->settings = $settings;
        $this->response = $response;
        $this->filters = $filters;

        add_action('wp_login', [$this, 'lockoutIfRequired'], null, 2);
    }

    /**
     * Checks if lockout is enabled and if the user trying to log in should be
     * locked out
     *
     * @param  string $username
     * @param  WP_User $user
     * @return boolean
     */
    public function lockoutIfRequired(string $username, WP_User $user)
    {
        $isLocked = $this->settings->getLockedStatus();
        $lockedUsers = $this->settings->getLockedUsers();

        if ($isLocked && in_array($user->ID, $lockedUsers)) {
            $this->redirectToLockedOutPage();
            return true;
        }

        return false;
    }

    /**
     * Shows locked out page with custom or default message
     *
     * @return void
     */
    private function redirectToLockedOutPage()
    {
        $template = __DIR__ . '/../templates/locked-out.php';

        $message = $this->filters->filter(
            $this->lockoutMessageFilterName,
            "You're currently locked out from this CMS"
        );

        return $this->response->template($template, compact('message'));
    }
}
