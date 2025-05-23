<?php

declare(strict_types=1);

namespace Wise\Core\ApiAdmin\Attributes\OpenApi\EndpointType;

use OpenApi\Attributes as OpenApi;
use OpenApi\Attributes\ExternalDocumentation;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\RequestBody;
use Symfony\Component\HttpFoundation\Request;
use Wise\Core\Api\Attributes\trait\BuilderOpenApiHelperTrait;
use Wise\Core\Api\Helper\OpenApiAliasResolver;
use Wise\Core\ApiAdmin\Controller\AbstractAdminApiController;
use Wise\Core\Dto\AbstractDto;
use Wise\Core\Exception\DtoParseException;

/**
 * Atrybut OADelete służy do oznaczania metod lub klas jako operacji DELETE w OpenAPI.
 *
 * Ta klasa rozszerza standardową adnotację OpenAPI `OpenApi\Delete`, dodając możliwości
 * powiązane z frameworkiem, jak i elastyczność w umieszczaniu jej na klasach lub metodach.
 *
 * @see OpenApi\Delete Dokumentacja OpenAPI dla operacji GET.
 *
 * @Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)
 */
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class OADelete extends OpenApi\Delete
{
    /**
     * Trait budujący komponenty OpenAPI na podstawie klasy DTO.
     */
    use BuilderOpenApiHelperTrait;

    const NELMIO_API_DOC_YAML_PATH = '/config/packages/nelmio_api_doc.yaml';
    private ?string $parametersDtoClass = null;

    /**
     * @throws \ReflectionException
     * @throws DtoParseException
     */
    public function __construct(
        ?string $path = null,
        ?string $operationId = null,
        ?string $description = null,
        ?string $summary = null,
        ?array $security = null,
        ?array $servers = null,
        ?RequestBody $requestBody = null,
        ?array $tags = null,
        ?array $parameters = null,
        ?array $responses = null,
        ?array $callbacks = null,
        ?ExternalDocumentation $externalDocs = null,
        ?bool $deprecated = null,
        ?array $x = null,
        ?array $attachables = null,
        ?JsonContent $parametersDto = null,
    ) {
        $parametersDtoDtoClass = null;

        if ($parametersDto instanceof JsonContent && $parametersDto->ref != null) {
            // Pobieramy alias schematu z referencji (usuwając prefiks '#/components/schemas/')
            $alias = str_replace('#/components/schemas/', '', $parametersDto->ref);

            if (!empty($alias)) {
                // Ścieżka do pliku konfiguracyjnego Nelmio (zawierającego aliasy)
                $dir = $this->getProjectDir() . self::NELMIO_API_DOC_YAML_PATH;

                // Pobieramy informacje o klasie na podstawie aliasu z Nelmio
                $aliasInfo = OpenApiAliasResolver::getInformationAboutClassFromNelmioByAlias(
                    yamlFile: $dir,
                    alias: $alias,
                    scope: AbstractAdminApiController::AREA_OPEN_API
                );

                // Jeśli znaleziono pełną nazwę klasy DTO, przypisujemy ją
                if (!empty($aliasInfo['className'])) {
                    $parametersDtoDtoClass = $aliasInfo['className'];
                }
            }
        }

        // Jeśli klasa DTO nie jest zdefiniowana, zgłaszamy wyjątek
        if ($parametersDtoDtoClass === null) {
            throw new DtoParseException(
                'Cannot automatically create parameters because $parametersDtoDtoClass is not set'
            );
        }

        // Tworzymy instancję klasy DTO
        $dto = new ($parametersDtoDtoClass)();
        // Sprawdzamy, czy utworzony obiekt jest instancją AbstractDto
        if (!($dto instanceof AbstractDto)) {
            // Jeśli nie, zgłaszamy wyjątek
            throw new DtoParseException(
                'Cannot automatically create parameters because ' . $parametersDtoDtoClass . ' is not an instance of ' . AbstractDto::class
            );
        }

        // Przypisujemy rozpoznaną klasę DTO do właściwości
        $this->parametersDtoClass = $parametersDtoDtoClass;

        // Generujemy komponenty OpenAPI na podstawie klasy DTO
        $openApiElements = $this->generateOpenApiComponents(
                                dtoClass: $parametersDtoDtoClass,
                                method: Request::METHOD_DELETE,
                                scope: AbstractAdminApiController::AREA_OPEN_API
                            );

        parent::__construct(
            $path,
            $operationId,
            $description,
            $summary,
            $security,
            $servers,
            $requestBody,
            $tags,
            $parameters ?? $openApiElements['parameters'],
            $responses ?? $openApiElements['responses'],
            $callbacks,
            $externalDocs,
            $deprecated,
            $x,
            $attachables
        );
    }

    /**
     * Automatycznie wykrywa i zwraca katalog główny projektu na podstawie lokalizacji pliku kernelowego.
     *
     * Metoda wykorzystuje refleksję, aby znaleźć plik, w którym zdefiniowana jest bieżąca klasa.
     * Następnie iteracyjnie wstecz przeszukuje strukturę katalogów, aż znajdzie plik `composer.json`,
     * co oznacza, że znalazła katalog główny projektu. Jeśli nie uda się znaleźć pliku `composer.json`,
     * metoda zwróci katalog, w którym zlokalizowana jest klasa kernelowa.
     *
     * @return string Ścieżka do katalogu głównego projektu.
     * @throws \LogicException Jeśli nie uda się zlokalizować pliku dla klasy kernelowej.
     */
    protected function getProjectDir(): string
    {
        return '/var/www/backend';
    }

    /**
     * Zwraca pole `responseDtoClass` klasy.
     * @return string|null
     */
    public function getParametersDtoClass(): ?string
    {
        return $this->parametersDtoClass;
    }
}
