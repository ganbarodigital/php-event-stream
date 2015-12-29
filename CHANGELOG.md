# CHANGELOG

## develop branch

Nothing yet.

## 1.1.0 - Tue Dec 29 2015

### New

* `Streams\EventStream` is now a `DataBag`.
  * Allows us to take advantage of DataBag-related utils in the future.

## 1.0.0 - Thu Sep 10 2015

### New

* Checks\HasEventHandler
* Checks\IsEventName
* Events\Event
* Exceptions\Exxx_EventStreamException
* Exceptions\E4xx_EventStreamException
* Exceptions\E4xx_NotAnEvent
* Exceptions\E4xx_UnsupportedType
* Requirements\RequireEventName
* Streams\DispatchEvent
* Streams\EventStream
* Streams\RegisterEventHandler
* ValueBuilders\GetEventHandlerList
* ValueBuilders\GuaranteeEventStream