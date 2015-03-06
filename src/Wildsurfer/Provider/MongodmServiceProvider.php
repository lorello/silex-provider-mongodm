<?php

namespace Wildsurfer\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Purekid\Mongodm\MongoDB;

/*
 * MongodmServiceProvider
 */
class MongodmServiceProvider implements ServiceProviderInterface
{
    /*
     * register
     */
    public function register(Container $app)
    {
        $app['mongodm'] = function() use ($app) {
            if(isset($app['mongodm.blocks']) && is_array($app['mongodm.blocks'])) {
                foreach($app['mongodm.blocks'] as $block => $config) {
                    MongoDB::setConfigBlock($block, array(
                        'connection' => array(
                            'hostnames' => isset($config['host']) ? $config['host'] : 'localhost',
                            'database'  => isset($config['db']) ? $config['db'] : 'test',
                            'options'  => isset($config['options']) ? $config['options'] : array()
                        )
                    ));
                }
            }
            else {
                MongoDB::setConfigBlock('default', array(
                    'connection' => array(
                        'hostnames' => isset($app['mongodm.host']) ? $app['mongodm.host'] : 'localhost',
                        'database'  => isset($app['mongodm.db']) ? $app['mongodm.db'] : 'test',
                        'options'  => isset($app['mongodm.options']) ? $app['mongodm.options'] : array()
                    )
                ));
            }
            return MongoDB::instance();
        };
    }

    /*
     * boot
     */
    public function boot(Container $app)
    {
    }
}
