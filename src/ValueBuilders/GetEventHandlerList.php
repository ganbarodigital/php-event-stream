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
 * @package   EventStream/ValueBuilders
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-event-stream
 */

namespace GanbaroDigital\EventStream\ValueBuilders;

use GanbaroDigital\EventStream\Requirements\RequireEventName;
use GanbaroDigital\EventStream\Streams\EventStream;

class GetEventHandlerList
{
    /**
     * return a read-only list of event handlers for a given event from
     * a given event stream
     *
     * @param  EventStream $stream
     *         the stream to extract from
     * @param  string $eventName
     *         the event to get the handler list for
     * @return array<callable>
     *         the list of handlers for the event
     *         can be an empty list
     */
    public function __invoke(EventStream $stream, $eventName)
    {
        return self::from($stream, $eventName);
    }

    /**
     * return a read-only list of event handlers for a given event from
     * a given event stream
     *
     * @param  EventStream $stream
     *         the stream to extract from
     * @param  string $eventName
     *         the event to get the handler list for
     * @return array<callable>
     *         the list of handlers for the event
     *         can be an empty list
     */
    public static function from(EventStream $stream, $eventName)
    {
        // defensive programming
        RequireEventName::check($eventName);

        if (!isset($stream->{$eventName})) {
            return [];
        }

        return $stream->{$eventName};
    }
}