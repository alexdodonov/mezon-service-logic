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
 * @psalm-suppress  PropertyNotSetInConstructor
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
     *
     * {@inheritdoc}
     * @see TestCase::setUp()
     * @psalm-suppress RedundantCondition
     */
    protected function setUp(): void
    {
        if (isset($_POST)) {
            unset($_POST['session_id']);
            unset($_POST['login']);
            unset($_POST['id']);
        }
    }

    /**
     * Testing constructor
     */
    public function testConstructor(): void
    {
        $serviceLogicClassName = $this->className;

        /** @var ServiceBaseLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        $this->assertInstanceOf(MockParamsFetcher::class, $logic->getParamsFetcher());
        $this->assertInstanceOf(MockProvider::class, $logic->getSecurityProvider());
    }
}
