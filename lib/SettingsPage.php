<?php

namespace WordpressLockout\Lib;

use WordpressLockout\Lib\Filters;
use WordpressLockout\Lib\Settings;
use WordpressLockout\Lib\Response;

/**
 * Generates the settings page for this plugin and handles any form submissions
 */
class SettingsPage
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
     * @var string
     */
    private $capability;

    /**
     * The menu and page name for this settings page
     * @var string
     */
    private $settingsPageName = 'Wordpress Lockout';

    /**
     * The slug for the settings page menu item
     * @var string
     */
    private $settingsPageSlug = 'wordpress_lockout';

    /**
     * The filter that plugin users can hook into to customise capability
     * required to access this page
     *
     * @var string
     */
    private $capabilityFilterName = 'wordpress_lockout:settings_capability';

    /**
     * Add settings page. If form has been submitted, route to save method.
     *
     * @param Table   $table
     * @param Triggers $triggers
     */
    public function __construct(
        Settings $settings,
        Response $response,
        Filters $filters
    ) {
        $this->settings = $settings;
        $this->response = $response;
        $this->filters = $filters;

        $this->setCapability();
        $this->checkForSubmissions();

        $this->filters->filter('admin_menu', [$this, 'addSettingsPage'], 1);
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
            $this->response->template(__DIR__ . '/../templates/insufficient-capabilities.php');
        }

        $this->response->template(__DIR__ . '/../templates/settings.php', [
            'allUsers' => $this->getAllUsers(),
            'isLocked' => $this->settings->getLockedStatus(),
            'lockedUsers' => $this->settings->getLockedUsers(),
        ]);
    }

    /**
     * Sets the capability required to use this plugin
     *
     * @return void
     */
    private function setCapability()
    {
        $this->capability = $this->filters->filter(
            $this->capabilityFilterName,
            'manage_options'
        );
    }

    /**
     * Check whether there is any input from the user that needs to be processed
     *
     * @return void
     */
    private function checkForSubmissions()
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
