# CHANGELOG

This is the changelog for the 2.x series.

## 2.1.1

- Fix a bug where Traversable queues (non-array iterables) will fail because the `reset()`, `current()`, and `next()` array functions are incompatible
- Improve the overall code quality of the project (through internal changes that do not alter the public API)

## 2.1.0

- Raise a more obvious error message when Relay is given an empty queue (#43)
- Fix a bug that broke callable middleware (#45)
- Properly declare PSR dependencies and make it clear that Relay provides an implementation of PSR-15's `Psr\Http\Server\RequestHandlerInterface` (#46)
- Add support for queue items that implement `Psr\Http\Server\RequestHandlerInterface` (#48)
- Replace abandoned `zendframework/zend-diactoros` with same version `laminas/laminas-diactoros`

## 2.0.0

The 2.x series introduces a major change to the way Relay handles middleware. While the 1.x series featured a "double
pass" signature (`function (request, response, next)`), the 2.x series is fully-compatible with
[PSR-15](https://www.php-fig.org/psr/psr-15/)'s "single pass" or "lambda" recommendation
(`function (request, handler) : response`).

Note that middleware designed for Relay 1.x are not compatible with PSR-15 server request handlers ("dispatchers")
like Relay 2.x.
