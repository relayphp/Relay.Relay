# CHANGELOG

This is the changelog for the 2.x series.

## 2.0.0-alpha1

The 2.x series converts from a `function (request, response, next)` ("double pass") signature to a `function (request, handler) : response` ("single pass" or "lambda") signature.
