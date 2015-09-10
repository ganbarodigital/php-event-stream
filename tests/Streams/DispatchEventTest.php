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
use PHPUnit_Framework_TestCase;

class DispatchEventTest_DummyEvent1 implements Event { }
class DispatchEventTest_DummyEvent2 implements Event { }

/**
 * @coversDefaultClass GanbaroDigital\EventStream\Streams\DispatchEvent
 */
class DispatchEventTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::to
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;
        $event = new DispatchEventTest_DummyEvent1;
        $eventName = get_class($event);

        $actualPayload = null;
        $handler = function($event) use(&$actualPayload) {
            $actualPayload = $event->payload;
        };

        $expectedPayload = "hello, world";
        $event->payload = $expectedPayload;

        RegisterEventHandler::on($stream, $eventName, $handler);

        // ----------------------------------------------------------------
        // perform the change

        DispatchEvent::to($stream, $event);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedPayload, $actualPayload);
    }

    /**
     * @covers ::to
     */
    public function testDispatchesEventsOnlyToThatEventsHandlers()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;

        $event1 = new DispatchEventTest_DummyEvent1;
        $eventName1 = get_class($event1);
        $actualPayload1 = null;
        $handler1 = function($event) use(&$actualPayload1) {
            $actualPayload1 = $event->payload;
        };
        $expectedPayload1 = "hello, world";
        $event1->payload = $expectedPayload1;

        $event2 = new DispatchEventTest_DummyEvent2;
        $eventName2 = get_class($event2);
        $actualPayload2 = null;
        $handler2 = function($event) use(&$actualPayload2) {
            $actualPayload2 = $event->payload;
        };
        $expectedPayload2 = "goodbye, sweetheart";
        $event2->payload = $expectedPayload2;

        RegisterEventHandler::on($stream, $eventName1, $handler1);
        RegisterEventHandler::on($stream, $eventName2, $handler2);

        // ----------------------------------------------------------------
        // perform the change
        //
        // we must make sure that each dispatched event has not called
        // the handlers for any other registered events

        DispatchEvent::to($stream, $event1);
        $this->assertEquals($expectedPayload1, $actualPayload1);

        $actualPayload1 = null;
        DispatchEvent::to($stream, $event2);
        $this->assertNull($actualPayload1);
        $this->assertEquals($expectedPayload2, $actualPayload2);
    }

    /**
     * @covers ::to
     */
    public function testDispatchesEventOnlyAllEventsHandlersForThatEvent()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;

        $event = new DispatchEventTest_DummyEvent1;
        $eventName = get_class($event);
        $expectedPayload = "hello, world";
        $event->payload = $expectedPayload;

        $actualPayload1 = null;
        $handler1 = function($event) use(&$actualPayload1) {
            $actualPayload1 = $event->payload;
        };

        $actualPayload2 = null;
        $handler2 = function($event) use(&$actualPayload2) {
            $actualPayload2 = $event->payload;
        };

        RegisterEventHandler::on($stream, $eventName, $handler1);
        RegisterEventHandler::on($stream, $eventName, $handler2);

        // ----------------------------------------------------------------
        // perform the change

        DispatchEvent::to($stream, $event);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedPayload, $actualPayload1);
        $this->assertEquals($expectedPayload, $actualPayload2);
    }

    /**
     * @covers ::to
     */
    public function testDoesNothingIfNoRegisteredEventHandlersForEvent()
    {
        // ----------------------------------------------------------------
        // setup your test

        $stream = new EventStream;

        $event1 = new DispatchEventTest_DummyEvent1;
        $eventName1 = get_class($event1);
        $actualPayload1 = null;
        $handler1 = function($event) use(&$actualPayload1) {
            $actualPayload1 = $event->payload;
        };
        $expectedPayload1 = "hello, world";
        $event1->payload = $expectedPayload1;

        $event2 = new DispatchEventTest_DummyEvent2;
        $eventName2 = get_class($event2);

        RegisterEventHandler::on($stream, $eventName1, $handler1);

        // ----------------------------------------------------------------
        // perform the change

        DispatchEvent::to($stream, $event2);

        // ----------------------------------------------------------------
        // test the results

        $this->assertNull($actualPayload1);
    }
}