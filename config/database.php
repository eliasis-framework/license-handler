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
use Eliasis\Framework\App;

$pluginConfig = App::getOption('plugin', 'license-handler');

return [
    'db' => [
        'id' => $pluginConfig['db-id'],
        'charset' => $pluginConfig['db-charset'],
        'prefix' => $pluginConfig['db-prefix'],
        'engine' => $pluginConfig['db-engine'],
    ]
];
