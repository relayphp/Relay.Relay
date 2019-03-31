# CHANGELOG

This is the changelog for the 2.x series.

## 2.0.0

The 2.x series introduces a major change to the way Relay handles middleware. While the 1.x series featured a "double
pass" signature (`function (request, response, next)`), the 2.x series is fully-compatible with
[PSR-15](https://www.php-fig.org/psr/psr-15/)'s "single pass" or "lambda" recommendation
(`function (request, handler) : response`).

Note that middleware designed for Relay 1.x are not compatible with PSR-15 server request handlers ("dispatchers")
like Relay 2.x.
