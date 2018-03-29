<?php

namespace CmsLockout\Lib;

/**
 * Interacts with Wordpress to save and retrieve plugin settings (as options)
 */
class Settings
{
    /**
     * The option key that the enabled tables is stored in
     * @var string
     */
    private $isLockedOptionName = 'cms_lockout:is_locked';

    /**
     * The option key that the enabled tables is stored in
     * @var string
     */
    private $lockedUsersOptionName = 'cms_lockout:locked_users';

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
    public function getLockedStatus() : bool
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
}
