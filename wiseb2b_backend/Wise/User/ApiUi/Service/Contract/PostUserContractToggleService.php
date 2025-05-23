<?php

namespace Wise\User\ApiUi\Service\Contract;

use Wise\Agreement\ApiUi\Dto\ContractAgreement\PostUserContractsToggleDto;
use Wise\Agreement\ApiUi\Dto\ContractAgreement\PostUserContractToggleDto;
use Wise\Agreement\Service\Contract\Interfaces\ChangeUserAgreementServiceInterface;
use Wise\Agreement\Service\ContractAgreement\ChangeUserAgreementParams;
use Wise\Core\ApiUi\Helper\UiApiShareMethodsHelper;
use Wise\Core\ApiUi\Service\AbstractPostUiApiService;
use Wise\Core\Dto\AbstractDto;
use Wise\Security\Service\Interfaces\CurrentUserServiceInterface;
use Wise\User\ApiUi\Service\Contract\Interfaces\PostUserContractToggleServiceInterface;

class PostUserContractToggleService extends AbstractPostUiApiService implements PostUserContractToggleServiceInterface
{
    protected string $messageSuccessTranslation = 'contract_agreement.success_toggle';

    public function __construct(
        UiApiShareMethodsHelper $sharedActionService,
        private readonly ChangeUserAgreementServiceInterface $changeUserAgreementService,
        private readonly CurrentUserServiceInterface $currentUserService
    ){
        parent::__construct($sharedActionService, $changeUserAgreementService);
    }

    public function post(PostUserContractsToggleDto|AbstractDto $dto): void
    {
        /** @var PostUserContractToggleDto $element */
        foreach ($dto->getItems() as $element){
            $type = $element->isAgree() ? ChangeUserAgreementParams::TYPE_AGREE : ChangeUserAgreementParams::TYPE_DISAGREE;

            $params = new ChangeUserAgreementParams();
            $params
                ->setUserId($this->currentUserService->getUserId())
                ->setClientId($this->currentUserService->getClientId())
                ->setContractId($element->getContractId())
                ->setType($type)
                ->setContextAgreement($element->getContextAgreement())
                ->setCanDisagreeRequiredContract(true);

            // Wywołanie serwisu aplikacji z przekazanymi parametrami
            $serviceDto = ($this->changeUserAgreementService)($params);
            $serviceDtoData = $serviceDto->read();
        }

        // Tworzenie rezultatu zwracanego przez serwis
        $this->prepareResponse($dto, $serviceDtoData);
    }

}
