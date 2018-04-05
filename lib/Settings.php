<?php

namespace WordpressLockout\Lib;

/**
 * Interacts with Wordpress to save and retrieve plugin settings (as options)
 */
class Settings
{
    /**
     * The option key that the enabled tables is stored in
     * @var string
     */
    private $isLockedOptionName = 'wordpress_lockout:is_locked';

    /**
     * The option key that the enabled tables is stored in
     * @var string
     */
    private $lockedUsersOptionName = 'wordpress_lockout:locked_users';

    /**
     * The option key that stores user custom lockout message
     * @var string
     */
    private $lockoutMessageOptionName = 'wordpress_lockout:lockout_message';

    /**
     * The default lockout message
     * @var string
     */
    private $defaultLockoutMessage = "You're currently locked out from this CMS, so you're unable to log in.";

    /**
     * Gets the option that stores enabled post type tables and unserializes it
     * @return array
     */
    public function getLockedUsers() : array
    {
        return unserialize(get_option($this->lockedUsersOptionName)) ?: [];
    }

    /**
     * Save the new settings to the options table and then update the db to add
     * new tables and rebuild the triggers
     *
     * @return void
     */
    public function updateLockedUsers($users)
    {
        return update_option($this->lockedUsersOptionName, serialize($users), null, true);
    }

    /**
     * Gets the option that stores enabled post type tables and unserializes it
     * @return array
     */
    public function getLockState() : bool
    {
        return (bool) get_option($this->isLockedOptionName) ?: false;
    }

    /**
     * Save the lock state to the options table
     *
     * @return void
     */
    public function updateLockState($state)
    {
        return update_option($this->isLockedOptionName, $state, null, true);
    }

    /**
     * Gets the option that stores enabled post type tables and unserializes it
     * @return array
     */
    public function getLockoutMessage()
    {
        return get_option($this->lockoutMessageOptionName) ?: $this->defaultLockoutMessage;
    }

    /**
     * Save the lock state to the options table
     *
     * @return void
     */
    public function updateLockoutMessage($state)
    {
        return update_option($this->lockoutMessageOptionName, $state, null, true);
    }
}
