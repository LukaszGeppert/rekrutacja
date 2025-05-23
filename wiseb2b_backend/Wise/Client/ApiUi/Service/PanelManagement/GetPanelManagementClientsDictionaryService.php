<?php

namespace Wise\Client\ApiUi\Service\PanelManagement;

use Symfony\Contracts\Translation\TranslatorInterface;
use Wise\Client\ApiUi\Service\PanelManagement\Interfaces\GetPanelManagementClientsDictionaryServiceInterface;
use Wise\Client\Service\Client\Interfaces\ListClientsServiceInterface;
use Wise\Core\ApiUi\Dto\CommonDictionaryElementResponseDto;
use Wise\Core\ApiUi\Helper\UiApiShareMethodsHelper;
use Wise\Core\ApiUi\Service\AbstractGetService;
use Wise\Core\Model\QueryFilter;
use Wise\Core\Service\CommonListParams;

class GetPanelManagementClientsDictionaryService extends AbstractGetService implements GetPanelManagementClientsDictionaryServiceInterface
{
    /**
     * Klasa parametrów dla serwisu
     */
    protected const SERVICE_PARAMS_DTO = CommonListParams::class;

    /**
     * Klasa odpowiedzi dla zapytania GET
     */
    protected const RESPONSE_DTO = CommonDictionaryElementResponseDto::class;

    /**
     * Czy serwis ma zwracać ilość wszystkich rekordów
     */
    protected bool $fetchTotalCount = true;

    public function __construct(
        UiApiShareMethodsHelper $shareMethodsHelper,
        private readonly ListClientsServiceInterface $listClientsService,
        private readonly TranslatorInterface $translator
    ){
        parent::__construct($shareMethodsHelper, $listClientsService);
    }

    /**
     * Metoda definiuje mapowanie pól z Response DTO, których nazwy NIE SĄ ZGODNE z domeną i wymagają mapowania.
     * @param array $fieldMapping
     * @return array
     */
    protected function prepareCustomFieldMapping(array $fieldMapping = []): array
    {
        return array_merge(
            parent::prepareCustomFieldMapping($fieldMapping),
            [
                'text' => null,
                'value' => null,
                'id' => 'id',
                'name' => 'name',
                'firstName' => 'firstName',
                'lastName' => 'lastName',
                'email' => 'email',
            ]
        );
    }

    /**
     * Metoda pozwala na dodanie własnych filtrów do listy filtrów
     * Zwraca wartość bool wskazującą, czy dalsze przetwarzanie bieżącego pola powinno być kontynuowane.
     * Wartość true wykonuje "continue" w pętli przetwarzającej parametry.
     * @param array $filters Referencja do tablicy filtrów, do której można dodać własne filtry.
     * @param int|string $field Nazwa parametru do przetworzenia.
     * @param mixed $value Wartość parametru do przetworzenia.
     * @example Wise\Order\ApiUi\Service\Orders\GetOrdersService
     * @return bool Wartość true wykonuje "continue" w pętli przetwarzającej parametry.
     */
    protected function customInterpreterParameters(array &$filters, int|string $field, mixed $value): bool
    {
        if($field === 'value'){
            $filters[] = new QueryFilter('id', $value);

            return true;
        }

        return false;
    }


    /**
     * Metoda pozwala przekształcić serviceDto przed transformacją do responseDto
     * @param array|null $serviceDtoData
     * @return void
     */
    protected function prepareServiceDtoBeforeTransform(?array &$serviceDtoData): void
    {
        $this->fields = [
            'text' => 'text',
            'value' => 'value',
        ];

        $results = [];

        foreach ($serviceDtoData as $item) {

            $fullName = trim(($item['firstName'] ?? '') . ' ' . ($item['lastName'] ?? ''));
            $email = $item['email'] ?? null;

            $resultTextView = $item['name'];

            if (!empty($fullName)) {
                $resultTextView .= " [$fullName]";
            }

            if (!empty($email)) {
                $resultTextView .= " [$email]";
            }

            $results[] = [
                'text' => $resultTextView,
                'value' => $item['id']
            ];
        }

        $serviceDtoData = $results;
    }

}
