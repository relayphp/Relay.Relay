Changes from 0.1.0-dev:

- Relay now typehints on _RequestInterface_ instead of _ServerRequestInterface_. Because the latter extends the former, this means _Relay_ can now be used for HTTP client logic as well.

- You should now create the _Relay_ object from the _RelayBuilder_ instead of creating it directly. If you create it directly, you will need to pass a _RunnerFactory_ to the constructor instead of a `$resolver`.

- _Relay_ objects are now reusable; i.e., they will reuse the $queue if you dispatch through them again.

- If you know you want to dispatch the middleware queue only once, you can save some minor overhead by instantiating a _Runner_ instead of a _Relay_. E.g., `$runner = new Runner($queue, $resolver); $response = $runner($request, $response);`.
