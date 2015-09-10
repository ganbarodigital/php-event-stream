<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   EventStream/Streams
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-event-stream
 */

namespace GanbaroDigital\EventStream\Streams;

use GanbaroDigital\EventStream\Checks\HasEventHandler;
use GanbaroDigital\EventStream\Events\Event;
use GanbaroDigital\EventStream\ValueBuilders\GetEventHandlerList;
use PHPUnit_Framework_TestCase;
use RuntimeException;

class RegisterEventHandlerTest_DummyEvent implements Event { }

/**
 * @coversDefaultClass GanbaroDigital\EventStream\Streams\RegisterEventHandler
 */
class RegisterEventHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::on
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;
        $eventName = RegisterEventHandlerTest_DummyEvent::class;
        $handler = function($event) { };

        $this->assertFalse(HasEventHandler::check($stream, $eventName));

        // ----------------------------------------------------------------
        // perform the change

        RegisterEventHandler::on($stream, $eventName, $handler);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue(HasEventHandler::check($stream, $eventName));
    }

    /**
     * @covers ::on
     */
    public function testCanAddAnEventHandler()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;
        $eventName = RegisterEventHandlerTest_DummyEvent::class;
        $handler1 = function($event) { };

        $this->assertFalse(HasEventHandler::check($stream, $eventName));

        // ----------------------------------------------------------------
        // perform the change

        RegisterEventHandler::on($stream, $eventName, $handler1);

        // ----------------------------------------------------------------
        // test the results

        $handlers = GetEventHandlerList::from($stream, $eventName);
        $this->assertSame($handlers[0], $handler1);
    }

    /**
     * @covers ::on
     */
    public function testCanHaveMultipleHandlersForOneEvent()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;
        $eventName = RegisterEventHandlerTest_DummyEvent::class;
        $handler1 = function($event) { };
        $handler2 = function($event) { };

        $this->assertFalse(HasEventHandler::check($stream, $eventName));

        // ----------------------------------------------------------------
        // perform the change

        RegisterEventHandler::on($stream, $eventName, $handler1);
        RegisterEventHandler::on($stream, $eventName, $handler2);

        // ----------------------------------------------------------------
        // test the results

        $handlers = GetEventHandlerList::from($stream, $eventName);
        $this->assertSame($handlers[0], $handler1);
        $this->assertSame($handlers[1], $handler2);
    }

}