<?php
/**
 * Licensing and applications manager.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - License Handler
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/license-handler.git
 * @since     1.0.1
 */
return [
    'db' => [
        'app' => [
            'provider' => 'PDOprovider',
            'host' => $GLOBALS['DB_HOST'],
            'user' => $GLOBALS['DB_USER'],
            'name' => $GLOBALS['DB_NAME'],
            'password' => $GLOBALS['DB_PASSWORD'],
            'settings' => ['charset' => 'utf8'],
        ],
    ],
];
