<?php

declare(strict_types=1);

namespace CompositeGraphQL\Infrastructure\Webonyx;

use GraphQL\Executor\Promise\Promise;
use GraphQL\Executor\Promise\PromiseAdapter;
use GraphQL\Utils\Utils;
use GuzzleHttp\Promise\Create;
use GuzzleHttp\Promise\Promise as GuzzlePromise;
use GuzzleHttp\Promise\PromiseInterface as GuzzlePromiseInterface;

class GuzzlePromiseAdapter implements PromiseAdapter
{
    /**
     * {@inheritdoc}
     */
    public function isThenable($value)
    {
        return $value instanceof GuzzlePromiseInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function convertThenable($thenable)
    {
        return new Promise($thenable, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function then(Promise $promise, ?callable $onFulfilled = null, ?callable $onRejected = null)
    {
        /** @var GuzzlePromiseInterface $adoptedPromise */
        $adoptedPromise = $promise->adoptedPromise;

        return new Promise($adoptedPromise->then($onFulfilled, $onRejected), $this);
    }

    /**
     * {@inheritdoc}
     */
    public function create(callable $resolver)
    {
        $promise = new GuzzlePromise($resolver);

        return new Promise($promise, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function createFulfilled($value = null)
    {
        $promise = Create::promiseFor($value);

        return new Promise($promise, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function createRejected($reason)
    {
        $promise = Create::rejectionFor($reason);

        return new Promise($promise, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function all(array $promisesOrValues)
    {
        $promisesOrValues = Utils::map(
            $promisesOrValues,
            static function ($item) {
                return $item instanceof Promise ? $item->adoptedPromise : Create::promiseFor($item);
            },
        );

        return new Promise(\GuzzleHttp\Promise\Utils::all($promisesOrValues)->then(static function ($values) use ($promisesOrValues): array {
            $orderedResults = [];

            foreach ($promisesOrValues as $key => $value) {
                $orderedResults[$key] = $values[$key];
            }

            return $orderedResults;
        }), $this);
    }
}
