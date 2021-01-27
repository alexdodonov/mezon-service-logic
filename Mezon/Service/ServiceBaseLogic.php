<?php
namespace Mezon\Service;

use Mezon\Security\ProviderInterface;
use Mezon\Transport\RequestParamsInterface;

/**
 * Class ServiceBaseLogic
 *
 * @package Service
 * @subpackage ServiceBaseLogic
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Class stores all service's logic
 *
 * @author Dodonov A.A.
 */
class ServiceBaseLogic implements ServiceBaseLogicInterface
{

    /**
     * Security provider
     *
     * @var ProviderInterface
     */
    private $securityProvider = null;

    /**
     * Request params fetcher
     *
     * @var RequestParamsInterface
     */
    private $paramsFetcher = false;

    /**
     * Constructor
     *
     * @param RequestParamsInterface $paramsFetcher
     *            Params fetcher
     * @param ProviderInterface $securityProvider
     *            Security provider
     */
    public function __construct(
        RequestParamsInterface $paramsFetcher,
        ProviderInterface $securityProvider)
    {
        $this->paramsFetcher = $paramsFetcher;

        $this->securityProvider = $securityProvider;
    }

    /**
     * Method returns request parameter
     *
     * @param string $param
     *            parameter name
     * @param mixed $default
     *            default value
     * @return mixed Parameter value
     */
    protected function getParam($param, $default = false)
    {
        return $this->getParamsFetcher()->getParam($param, $default);
    }

    /**
     * Method return params fetcher
     *
     * @return RequestParamsInterface Params fetcher
     */
    public function getParamsFetcher(): RequestParamsInterface
    {
        return $this->paramsFetcher;
    }

    /**
     * Method returns security provider
     *
     * @return ProviderInterface
     */
    public function getSecurityProvider(): ProviderInterface
    {
        return $this->securityProvider;
    }
}
