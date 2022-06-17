<?php
namespace Mezon\Service\Tests;

use PHPUnit\Framework\TestCase;
use Mezon\Transport\Tests\MockParamsFetcher;
use Mezon\Security\MockProvider;
use Mezon\Service\ServiceModel;
use Mezon\Service\ServiceLogicWithModel;

/**
 *
 * @psalm-suppress PropertyNotSetInConstructor
 */
class ServiceLogicWithModelUnitTest extends TestCase
{

    /**
     * Testing constructor
     */
    public function testConstructor(): void
    {
        // setup
        $model1 = new ServiceModel();
        $logic = new TestingServiceLogicWithModel(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $model2 = $logic->getModel();

        // assertions
        $this->assertEquals($model1, $model2);
    }
}
