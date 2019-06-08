<?php

Config::set('site_name', 'Web Tests');

// Routes. Route name => method prefix
Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_controller', 'home');
Config::set('default_action', 'index');