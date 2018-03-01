<?php
/**
 * Licensing and applications manager.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - License Handler
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/license-handler.git
 * @since     1.0.0
 */

return [
    'table' => [
        'applications' => [
            'id' => 'app_id',
            'name' => 'app_name',
            'type' => 'app_type',
            'category' => 'app_category',
            'state' => 'app_state',
            'updated' => 'updated',
            'created' => 'created',
        ],

        'sites' => [
            'id' => 'site_id',
            'domain' => 'site_domain',
            'host' => 'site_host',
            'ip' => 'site_ip',
            'authorized' => 'site_authorized',
            'updated' => 'updated',
            'created' => 'created',
        ],

        'licenses' => [
            'id' => 'lic_id',
            'key' => 'lic_key',
            'state' => 'lic_state',
            'expire' => 'lic_expire',
            'updated' => 'updated',
            'created' => 'created',
        ],

        'options' => [
            'id' => 'option_id',
            'name' => 'option_name',
            'value' => 'option_value',
        ],
    ],
];
