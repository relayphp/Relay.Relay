Changes from 0.2.0:

- _Relay_ objects are now reusable; i.e., they will reuse the same `$queue` if you dispatch through them again.

- You should now create the _Relay_ object through the _RelayBuilder_ instead of creating it directly. If you create it directly, you will need to pass a _RunnerFactory_ to the constructor instead of a `$resolver`.

- If you know you want to dispatch the middleware queue only once, you can save some minor overhead by instantiating a singel-use _Runner_ instead of a multiple-use _Relay_. E.g., `$runner = new Runner($queue, $resolver); $response = $runner($request, $response);`.
