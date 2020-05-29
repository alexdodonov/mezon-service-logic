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
     * Model
     *
     * @var ServiceModel
     */
    private $model = false;

    /**
     * Constructor
     *
     * @param RequestParamsInterface $paramsFetcher
     *            Params fetcher
     * @param ProviderInterface $securityProvider
     *            Security provider
     * @param mixed $model
     *            Service model
     */
    public function __construct(
        RequestParamsInterface $paramsFetcher,
        ProviderInterface $securityProvider,
        $model = null)
    {
        $this->paramsFetcher = $paramsFetcher;

        $this->securityProvider = $securityProvider;

        if (is_string($model)) {
            $this->model = new $model();
        } else {
            $this->model = $model;
        }
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
     * Method returns model object
     *
     * @return ?ServiceModel Model
     */
    public function getModel(): ?ServiceModel
    {
        return $this->model;
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
