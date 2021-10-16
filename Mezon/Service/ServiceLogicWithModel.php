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
    private $model;

    /**
     * Constructor
     *
     * @param RequestParamsInterface $paramsFetcher
     *            params fetcher
     * @param ProviderInterface $securityProvider
     *            security provider
     * @param ServiceModel $model
     *            service model
     */
    public function __construct(
        RequestParamsInterface $paramsFetcher,
        ProviderInterface $securityProvider,
        ServiceModel $model)
    {
        parent::__construct($paramsFetcher, $securityProvider);

        $this->model = $model;
    }

    /**
     * Method returns model object
     *
     * @return ServiceModel Model
     */
    public function getModel(): ServiceModel
    {
        return $this->model;
    }
}
