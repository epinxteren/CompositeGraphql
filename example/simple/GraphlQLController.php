<?php

declare(strict_types=1);

namespace Example\simple;

use CompositeGraphQL\Infrastructure\Symfony\GraphQLSchemaCompilerPass;
use CompositeGraphQL\Infrastructure\Webonyx\GuzzlePromiseAdapter;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

final class GraphlQLController extends AbstractController
{
    public function __construct(
        private Schema $schemaV2,
        private Environment $twig,
        private NXSpaDTOFactory $factory,
    ) {
    }

    #[Route('/v2/graphql', name: 'graphql_v2')]
    public function v2(Request $request): JsonResponse
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

    #[Route('/v2/value', name: 'graphql_v2_vlUE')]
    public function v2VALUE(): Response
    {
        return (new Response('<pre>' . htmlspecialchars(GraphQLSchemaCompilerPass::printValues())))->setMaxAge(3600);
    }

    #[Route('/v2', name: 'graphql_v2_playground')]
    public function v2Playground(): Response
    {
        $config = SpaPageConfig::create('v2', 'playground', 'home');
        $dto = $this->factory->create($config);
        $dto->config->graphqlRoute = '/v2/graphql';
        $result = $this->twig->render('spa/spa.html.twig', [
            'pageTitle' => $config->pageTitle(),
            'dto' => $dto,
        ]);

        return (new Response($result))->setMaxAge(3600);
    }
}
