<?php

Config::set('site_name', 'Web Tests');
Config::set('site_url', 'http://localhost');

Config::set('auth_domain', 'fmijs.eu.auth0.com');
Config::set('auth_client_id', 'WrftI8wCb6Qqx4PFBqzw60Ee54Z5vgD8');
Config::set('auth_client_secret', 'EFzOZCGZo7LKBQR8SLmCKdZYWzq2JnAYNqLWnvCT20z758wWNwdlAqpuzEegUBfs');

// Routes. Route name => method prefix
Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_controller', 'home');
Config::set('default_action', 'index');