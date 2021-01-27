<?php
namespace Mezon\Service;

use Mezon\Security\ProviderInterface;
use Mezon\Transport\RequestParamsInterface;

/**
 * Class ServiceBaseLogic
 *
 * @package Service
 * @subpackage ServiceLogicWithModel
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Class stores all service's logic
 *
 * @author Dodonov A.A.
 */
class ServiceLogicWithModel extends ServiceBaseLogic
{

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
        parent::__construct($paramsFetcher, $securityProvider);

        if (is_string($model)) {
            $this->model = new $model();
        } else {
            $this->model = $model;
        }
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
}
