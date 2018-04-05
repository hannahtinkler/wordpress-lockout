<?php

namespace WordpressLockout\Lib;

use WP_User;
use WP_Error;
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

        add_action('wp_authenticate_user', [$this, 'lockoutIfRequired'], null, 2);
    }

    /**
     * Gets message to display to locked user out when they log in.
     * @return string
     */
    public function getMessage() : string
    {
        return $this->filters->apply(
            $this->lockoutMessageFilterName,
            $this->settings->getLockoutMessage()
        );
    }

    /**
     * Checks if lockout is enabled and if the user trying to log in, return
     * a WP error (which WP will show to the user on the login page as an error)
     *
     * @param  string $username
     * @param  WP_User $user
     * @return boolean
     */
    public function lockoutIfRequired(WP_User $user)
    {
        $isLocked = $this->settings->getLockState();
        $lockedUsers = $this->settings->getLockedUsers();

        if ($isLocked && in_array($user->ID, $lockedUsers)) {
            $user = new WP_Error(403, $this->getMessage());
        }

        return $user;
    }
}
