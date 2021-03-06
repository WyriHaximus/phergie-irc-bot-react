<?php
/**
 * Phergie (http://phergie.org)
 *
 * @link http://github.com/phergie/phergie-irc-bot-react for the canonical source repository
 * @copyright Copyright (c) 2008-2015 Phergie Development Team (http://phergie.org)
 * @license http://phergie.org/license New BSD License
 * @package Phergie\Irc\Bot\React
 */

namespace Phergie\Irc\Tests\Bot\React\PluginProcessor;

use Phake;
use Phergie\Irc\Bot\React\PluginProcessor\ClientInjector;

/**
 * Tests for ClientInjector.
 *
 * @category Phergie
 * @package Phergie\Irc\Bot\React
 */
class ClientInjectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests process() with a plugin that does not implement
     * ClientAwareInterface.
     */
    public function testProcessWithNonClientAwarePlugin()
    {
        $bot = Phake::mock('\Phergie\Irc\Bot\React\Bot');
        $plugin = Phake::mock('\Phergie\Irc\Bot\React\PluginInterface');
        Phake::verifyNoFurtherInteraction($plugin);
        $processor = new ClientInjector;
        $processor->process($plugin, $bot);
    }

    /**
     * Tests process() with a plugin that implements
     * ClientAwareInterface.
     */
    public function testProcessWithEventEmitterAwarePlugin()
    {
        $client = Phake::mock('\Phergie\Irc\Client\React\ClientInterface');
        $bot = Phake::mock('\Phergie\Irc\Bot\React\Bot');
        Phake::when($bot)->getClient()->thenReturn($client);
        $plugin = Phake::mock('\Phergie\Irc\Bot\React\AbstractPlugin');
        $processor = new ClientInjector;
        $processor->process($plugin, $bot);
        Phake::verify($plugin)->setClient($client);
    }
}
