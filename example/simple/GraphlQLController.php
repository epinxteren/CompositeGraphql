<?php

declare(strict_types=1);

namespace Example\simple;

use CompositeGraphQL\Infrastructure\Webonyx\GuzzlePromiseAdapter;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use http\Client\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class GraphlQLController
{
    #[Route('/demo/graphql', name: 'demo_graphql')]
    public function graphql(Request $request): JsonResponse
    {
        if (!\is_array($data = json_decode($request->getContent(), true))) {
            throw new BadRequestHttpException('GraphQL data is not valid JSON.');
        }
        $query = $data['query'] ?? null;
        $variableValues = $data['variables'] ?? [];

        try {
            $promiseAdapter = new GuzzlePromiseAdapter();
            $promise = GraphQL::promiseToExecute(
                $promiseAdapter, $this->schemaV2, $query, [], null, $variableValues,
            );
            $result = $promise->adoptedPromise->wait($promise);
            $output = $result->toArray();
        } catch (\Exception $e) {
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage(),
                    ],
                ],
            ];
        }

        return new JsonResponse($output);
    }

}
