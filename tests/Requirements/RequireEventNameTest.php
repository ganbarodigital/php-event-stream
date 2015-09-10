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
 * @package   EventStream/Requirements
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-event-stream
 */

namespace GanbaroDigital\EventStream\Requirements;

use GanbaroDigital\EventStream\Events\Event;
use PHPUnit_Framework_TestCase;
use RuntimeException;

class RequireEventNameTest_DummyEvent implements Event { }

/**
 * @coversDefaultClass GanbaroDigital\EventStream\Requirements\RequireEventName
 */
class RequireEventNameTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $obj = new RequireEventName();

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof RequireEventName);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideValidEventNames
     */
    public function testCanUseAsObject($eventName)
    {
        // ----------------------------------------------------------------
        // setup your test

        $obj = new RequireEventName();

        // ----------------------------------------------------------------
        // perform the change

        $obj($eventName);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here with no exception, the test has passed
    }


    /**
     * @covers ::check
     * @dataProvider provideValidEventNames
     */
    public function testCanCallStatically($eventName)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireEventName::check($eventName);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here with no exception, the test has passed
    }

    /**
     * @covers ::check
     * @dataProvider provideValidEventNames
     */
    public function testAcceptsValidEventNames($eventName)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireEventName::check($eventName);

        // ----------------------------------------------------------------
        // test the results


    }

    /**
     * @covers ::check
     * @dataProvider provideInvalidEventNames
     * @expectedException GanbaroDigital\EventStream\Exceptions\E4xx_NotAnEvent
     */
    public function testThrowsExceptionForInvalidEventNames($eventName)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireEventName::check($eventName);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here with no exception, the test has failed
    }

    /**
     * @covers ::check
     * @dataProvider provideEverythingElse
     * @expectedException GanbaroDigital\EventStream\Exceptions\E4xx_NotAnEvent
     */
    public function testThrowsExceptionForEverythingElse($eventName)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireEventName::check($eventName);

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here with no exception, the test has failed
    }

    public function provideEverythingElse()
    {
        return [
            [ null ],
            [ [] ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ new RequireEventName ],
            [ "hello, world!" ],
        ];
    }

    public function provideValidEventNames()
    {
        return [
            [ RequireEventNameTest_DummyEvent::class, true ],
        ];
    }

    public function provideInvalidEventNames()
    {
        return [
            [ RequireEventName::class, false ],
        ];
    }
}