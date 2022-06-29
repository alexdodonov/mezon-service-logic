<?php
namespace Mezon\Service\Tests;

use Mezon\Transport\Tests\MockParamsFetcher;
use Mezon\Service\ServiceLogic;
use Mezon\Security\MockProvider;
use Mezon\Service\ServiceModel;

/**
 * Class ServiceLogicUnitTests
 *
 * @package ServiceLogic
 * @subpackage ServiceLogicUnitTests
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Base class for service logic unit tests
 *
 * @author Dodonov A.A.
 * @group baseTests
 * @codeCoverageIgnore
 * @psalm-suppress  PropertyNotSetInConstructor
 */
class ServiceLogicUnitTests extends ServiceBaseLogicUnitTests
{

    const TEST_USER_LOGIN = 'admin';

    /**
     * Testing class name.
     *
     * @var string
     */
    protected $className = ServiceLogic::class;

    /**
     * Testing connection routine
     */
    public function testConnect(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        /** @var array{session_id: string} $result */
        $result = $logic->connect();

        // assertions
        $this->assertEquals(32, strlen($result['session_id']));
    }

    /**
     * Testing connection routine
     */
    public function testConnectWithEmptyParams(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(false), new MockProvider(), new ServiceModel());

        if (! empty($_POST)) {
            unset($_POST['login']);
            unset($_POST['password']);
        }

        // assertions
        $this->expectException(\Exception::class);

        // test body
        $logic->connect();
    }

    /**
     * Testing setToken method
     */
    public function testSetToken(): void
    {
        // setup
        $_POST['token'] = 'value';

        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $result = $logic->setToken();

        // assertions
        $this->assertEquals('value', $result['session_id'], 'Setting token failed');
    }

    /**
     * Testing getSelfId method
     */
    public function testGetSelfId(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $result = $logic->getSelfId();

        // assertions
        $this->assertEquals(1, $result['id'], 'Getting self id failed');
    }

    /**
     * Testing getSelfLogin method
     */
    public function testGetSelfLogin(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $result = $logic->getSelfLogin();

        // assertions
        $this->assertEquals('admin@localhost', $result['login']);
    }

    /**
     * Testing loginAs method
     */
    public function testLoginAsWithLogin(): void
    {
        // setup
        $_POST['login'] = 'localhost@index.ru';

        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $result = $logic->loginAs();

        // assertions
        $this->assertEquals('value', $result['session_id']);
    }

    /**
     * Testing loginAs method
     */
    public function testLoginAsWithId(): void
    {
        // setup
        $_POST['id'] = '1';
        $_POST['session_id'] = 'session id';

        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(''), new MockProvider(), new ServiceModel());

        // test body
        $result = $logic->loginAs();

        // assertions
        $this->assertEquals('session id', $result['session_id']);
    }

    /**
     * Testing loginAs method with id
     */
    public function testLoginAsById(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $result = $logic->loginAs();

        // assertions
        $this->assertEquals('value', $result['session_id'], 'Getting self login failed');
    }

    /**
     * Testing validatePermit method
     */
    public function testValidatePermit(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body and assertions
        $logic->validatePermit(ServiceLogicUnitTests::TEST_USER_LOGIN);
        $this->assertTrue(true);
    }

    /**
     * Testing hasPermit method
     */
    public function testHasPermit(): void
    {
        // setup
        $serviceLogicClassName = $this->className;

        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body and assertions
        $logic->hasPermit(ServiceLogicUnitTests::TEST_USER_LOGIN);
        $this->assertTrue(true);
    }

    /**
     * Testing method setSecurityProvider
     */
    public function testSetSecurityProvider(): void
    {
        // setup
        $serviceLogicClassName = $this->className;
        /** @var ServiceLogic $logic */
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), new MockProvider(), new ServiceModel());

        // test body
        $logic->setSecurityProvider($securityProvider = new MockProvider());

        // assertions
        $this->assertSame($securityProvider, $logic->getSecurityProvider());
    }
}
