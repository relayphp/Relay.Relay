# CHANGELOG

This is the changelog for the 2.x series.

## [next]

The 2.x series converts from a `function (request, response, next)` ("double pass") signature to a `function (request, handler) : response` ("single pass" or "lambda") signature.
