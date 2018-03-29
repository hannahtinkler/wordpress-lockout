# Wordpress Lockout
This plugin prevents defined users from logging into Wordpress when the CMS is 'locked'.

A set of users to 'lock out' can be defined in the `WP Admin > Settings > Wordpress Lockout` menu. They will not be locked out
however unless the CMS has also been 'locked' via the global switch in the `WP Admin > Settings > Wordpress Lockout` menu


### Filters

#### wordpress_lockout:locked_out_message:
What it does:   Customise the message that is shown to locked out users.
Default:        You're currently locked out from this CMS

```
add_filter('wordpress_lockout:locked_out_message', function ($message) {
    return 'Sorry, we're migrating data at the moment so you can't log in';
});
```


#### wordpress_lockout:settings_capability:
What it does:   Customise the capability required to 'lock' the CMS.
Default:        'manage_options'

```
add_filter('wordpress_lockout:settings_capability', function ($capability) {
    return 'read_posts';
});
```
