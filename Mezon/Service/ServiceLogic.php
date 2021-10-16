<?php
namespace Mezon\Service;

use Mezon\Security\AuthorizationProviderInterface;
use Mezon\Transport\RequestParamsInterface;

/**
 * Class ServiceLogic
 *
 * @package Service
 * @subpackage ServiceLogic
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Class stores all service's logic
 *
 * @author Dodonov A.A.
 */
class ServiceLogic extends ServiceLogicWithModel
{
    use StandartSecurityMethods;

    /**
     * Authorization provider
     *
     * @var AuthorizationProviderInterface
     */
    private $authorizationProvider;

    /**
     * Constructor
     *
     * @param RequestParamsInterface $paramsFetcher
     *            params fetcher
     * @param AuthorizationProviderInterface $authorizationProvider
     *            authorization provider
     * @param ServiceModel $model
     *            Service model
     */
    public function __construct(
        RequestParamsInterface $paramsFetcher,
        AuthorizationProviderInterface $authorizationProvider,
        ServiceModel $model)
    {
        parent::__construct($paramsFetcher, $authorizationProvider, $model);

        $this->authorizationProvider = $authorizationProvider;
    }

    /**
     * Method returns AuthorizationProvider
     *
     * @return AuthorizationProviderInterface
     */
    public function getAuthorizationProvider(): AuthorizationProviderInterface
    {
        return $this->authorizationProvider;
    }
}
