<?php

namespace CmsLockout\Lib;

use CmsLockout\Lib\Settings;
use CmsLockout\Lib\Response;

class SettingsPage
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
     * The menu and page name for this settings page
     * @var string
     */
    private $settingsPageName = 'CMS Lockout';

    /**
     * The slug for the settings page menu item
     * @var string
     */
    private $settingsPageSlug = 'cms_lockout';

    /**
     * The filter that plugin users can hook into to customise capability
     * required to access this page
     *
     * @var string
     */
    private $capabilityFilterName = 'ctp_tables:settings_capability';

    /**
     * Add settings page. If form has been submitted, route to save method.
     *
     * @param Table   $table
     * @param Triggers $triggers
     */
    public function __construct(Settings $settings, Response $response)
    {
        $this->settings = $settings;
        $this->response = $response;

        $this->checkForSubmissions();

        $this->capability = apply_filters($this->capabilityFilterName, 'manage_options');

        add_filter('admin_menu', [$this, 'addSettingsPage'], 1);
    }

    /**
     * Check whether there is any input from the user that needs to be processed
     *
     * @return void
     */
    public function checkForSubmissions()
    {
        if (isset($_GET['lock'])) {
            $this->settings->updateLockState($_GET['lock']);
            $this->redirect(['locked' => $_GET['lock']]);
        }

        if (isset($_POST['locked_users'])) {
            $this->settings->updateLockedUsers($_POST['locked_users']);
            $this->redirect(['success' => 1]);
        }
    }

    /**
     * Add settings page to admin settings menu
     */
    public function addSettingsPage()
    {
        add_options_page(
            $this->settingsPageName,
            $this->settingsPageName,
            $this->capability,
            $this->settingsPageSlug,
            [$this, 'showSettingsPage']
        );
    }

    /**
     * Shows the settings page or a 404 if the user does not have access
     * @return void
     */
    public function showSettingsPage()
    {
        if (!current_user_can($this->capability)) {
            require_once __DIR__ . '/../templates/insufficient-capabilities.php';
            wp_die();
        }

        $allUsers = $this->getAllUsers();
        $isLocked = $this->settings->getLockedStatus();
        $lockedUsers = $this->settings->getLockedUsers();

        require_once __DIR__ . '/../templates/settings.php';
    }

    /**
     * Grabs all users, removes current user (so they can't lock themself out)
     * and orders alphabetically.
     *
     * @return array
     */
    private function getAllUsers() : array
    {
        $users = array_filter(get_users(), function ($user) {
            return get_current_user_id() != $user->ID;
        });

        usort($users, function ($a, $b) {
            return strcasecmp($a->data->display_name, $b->data->display_name);
        });

        return $users;
    }

    /**
     * Redirects to this settings page (root WP options page plus the 'page'
     * GET variable) with the supplied additional data
     *
     * @param  array $data
     * @return void
     */
    private function redirect(array $data)
    {
        $url = explode('?', $_SERVER['REQUEST_URI']);

        $queryString = http_build_query(
            ['page' => $this->settingsPageSlug] + $data
        );

        wp_redirect(sprintf('%s?%s', $url[0], $queryString));

        exit;
    }
}
