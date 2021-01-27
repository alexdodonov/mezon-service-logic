<?php
namespace Mezon\Service\Tests;

use Mezon\Security\MockProvider;
use Mezon\Transport\Tests\MockParamsFetcher;
use Mezon\Service\ServiceModel;
use Mezon\Service\ServiceBaseLogic;
use PHPUnit\Framework\TestCase;

/**
 * Service logic utin tests
 *
 * @package ServiceLogic
 * @subpackage ServiceBaseLogicUnitTests
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Base class for service logic unit tests
 *
 * @author Dodonov A.A.
 */
class ServiceBaseLogicUnitTests extends TestCase
{

    /**
     * Testing class name.
     *
     * @var string
     */
    protected $className = ServiceBaseLogic::class;

    /**
     * Method tests creation of the logis's parts
     *
     * @param object $logic
     *            ServiceLogic object
     */
    protected function checkLogicParts(object $logic): void
    {
        $this->assertInstanceOf(MockParamsFetcher::class, $logic->getParamsFetcher());
        $this->assertInstanceOf(MockProvider::class, $logic->getSecurityProvider());
    }

    /**
     * Testing connect method
     */
    public function testConstruct1(): void
    {
        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider());

        $this->checkLogicParts($logic);
    }

    /**
     * Testing connect method
     */
    public function testConstruct2(): void
    {
        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(
            new MockParamsFetcher(),
            new MockProvider(),
            new ServiceModel());

        $this->checkLogicParts($logic);
    }

    /**
     * Testing connect method
     */
    public function testConstruct3(): void
    {
        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(
            new MockParamsFetcher(),
            new MockProvider(),
            ServiceModel::class);

        $this->checkLogicParts($logic);
    }
}
