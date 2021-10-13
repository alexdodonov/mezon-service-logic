<?php
namespace Mezon\Service\Tests;

use Mezon\Transport\Tests\MockParamsFetcher;
use Mezon\Service\ServiceLogic;
use Mezon\Security\MockProvider;

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
     * Method returns mock of the security provider
     *
     * @return object mock object
     */
    protected function getSecurityProviderMock(): object
    {
        $mock = $this->getMockBuilder(MockProvider::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
            'connect',
            'validatePermit',
            'hasPermit'
        ])
            ->getMock();

        $mock->method('connect')->will($this->returnValue('valuevalue'));

        return $mock;
    }

    /**
     * Testing connection routine
     */
    public function testConnect(): void
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();
        $serviceLogicClassName = $this->className;
        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->connect();

        // assertions
        $this->assertEquals('valuevalue', $result['session_id'], 'Connection failed');
    }

    /**
     * Testing connection routine
     */
    public function testConnectWithEmptyParams(): void
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();
        $serviceLogicClassName = $this->className;
        $logic = new $serviceLogicClassName(new MockParamsFetcher(false), $securityProviderMock);

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
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

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
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

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
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->getSelfLogin();

        // assertions
        $this->assertEquals('admin@localhost', $result['login']);
    }

    /**
     * Testing loginAs method
     */
    public function testLoginAs(): void
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->loginAs();

        // assertions
        $this->assertEquals('value', $result['session_id'], 'Getting self login failed');
    }

    /**
     * Testing loginAs method with id
     */
    public function testLoginAsById(): void
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

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
        $securityProviderMock = $this->getSecurityProviderMock();
        $securityProviderMock->method('validatePermit')->with(
            $this->equalTo('value'),
            $this->equalTo(ServiceLogicUnitTests::TEST_USER_LOGIN));

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

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
        $securityProviderMock = $this->getSecurityProviderMock();
        $securityProviderMock->method('hasPermit')->with(
            $this->equalTo('value'),
            $this->equalTo(ServiceLogicUnitTests::TEST_USER_LOGIN));

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher(), $securityProviderMock);

        // test body and assertions
        $logic->hasPermit(ServiceLogicUnitTests::TEST_USER_LOGIN);
        $this->assertTrue(true);
    }
}
