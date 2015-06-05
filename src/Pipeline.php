<?php
namespace Pipeline\Pipeline;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Pipeline
{
    protected $queue = [];
    protected $resolver;

    public function __construct(array $queue, callable $resolver = null)
    {
        $this->queue = $queue;
        $this->resolver = $resolver;
    }

    public function __invoke(Request $request, Response $response)
    {
        $spec = array_shift($this->queue);
        $middleware = $this->resolve($spec);
        return $middleware($request, $response, $this);
    }

    protected function resolve($spec)
    {
        if (! $spec) {
            return function (
                Request $request,
                Response $response,
                callable $next
            ) {
                return $response;
            };
        }

        if (! $this->resolver) {
            return $spec;
        }

        return call_user_func($this->resolver, $spec);
    }
}
