<?php

declare(strict_types=1);

namespace Wise\Client\Service\ClientDeliveryMethod;

use Wise\Client\Domain\ClientDeliveryMethod\ClientDeliveryMethodRepositoryInterface;
use Wise\Client\Service\ClientDeliveryMethod\Interfaces\ListByFiltersClientDeliveryMethodServiceInterface;
use Wise\Core\Dto\CommonServiceDTO;
use Wise\Core\Helper\QueryFilter\QueryParametersHelper;

class ListByFiltersClientDeliveryMethodService implements ListByFiltersClientDeliveryMethodServiceInterface
{
    public function __construct(
        private readonly ClientDeliveryMethodRepositoryInterface $repository
    ) {}

    public function __invoke(array $filters, array $joins, ?array $fields = null, ?array $aggregates = []): CommonServiceDTO
    {
        $queryParameters = QueryParametersHelper::prepareStandardParameters($filters);

        $entities = $this->repository->findByQueryFiltersView(
            queryFilters:  $queryParameters->getQueryFilters(),
            orderBy: ['field' => $queryParameters->getSortField(), 'direction' => $queryParameters->getSortDirection()],
            limit: $queryParameters->getLimit(),
            offset: $queryParameters->getOffset(),
            fields: $fields,
            joins: $joins,
            aggregates: $aggregates
        );

        $entities ??= [];

        ($resultDTO = new CommonServiceDTO())->writeAssociativeArray($entities);

        return $resultDTO;
    }
}
