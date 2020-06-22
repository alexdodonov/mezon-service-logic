<?php
namespace Mezon\Service\Tests;

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
 * Mock parameter fetcher
 *
 * @author Dodonov A.A.
 * @group baseTests
 * @codeCoverageIgnore
 */
class MockParamsFetcher2 extends \Mezon\Transport\Tests\MockParamsFetcher
{

    // TODO try to remove this class with the \Mezon\Transport\Tests\MockParamsFetcher

    /**
     * Method returns request parameter
     *
     * @param string $param
     *            parameter name
     * @param mixed $default
     *            default value
     * @return mixed Parameter value
     */
    public function getParam($param, $default = false)
    {
        if ($param == 'login') {
            return '';
        } elseif ($param == 'id' || $param == 'session_id') {
            return $this->value;
        } else {
            return null;
        }
    }
}

/**
 * Base class for service logic unit tests
 *
 * @author Dodonov A.A.
 * @group baseTests
 * @codeCoverageIgnore
 */
class ServiceLogicUnitTests extends \Mezon\Service\Tests\ServiceBaseLogicUnitTests
{

    const TEST_USER_LOGIN = 'admin';

    /**
     * Testing class name.
     *
     * @var string
     */
    protected $className = \Mezon\Service\ServiceLogic::class;

    /**
     * Method returns mock of the security provider
     */
    protected function getSecurityProviderMock()
    {
        $mock = $this->getMockBuilder(\Mezon\Security\MockProvider::class)
            ->disableOriginalConstructor()
            ->setMethods([
            'connect',
            'getParam',
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
    public function testConnect()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();
        $serviceLogicClassName = $this->className;
        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->connect();

        // assertions
        $this->assertEquals('valuevalue', $result['session_id'], 'Connection failed');
    }

    /**
     * Testing connection routine
     */
    public function testConnectWithEmptyParams()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();
        $serviceLogicClassName = $this->className;
        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(false), $securityProviderMock);
        unset($_POST['login']);
        unset($_POST['password']);

        // assertions
        $this->expectException(\Exception::class);

        // test body
        $logic->connect();
    }

    /**
     * Testing setToken method
     */
    public function testSetToken()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->setToken();

        // assertions
        $this->assertEquals('value', $result['session_id'], 'Setting token failed');
    }

    /**
     * Testing getSelfId method
     */
    public function testGetSelfId()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->getSelfId();

        // assertions
        $this->assertEquals(1, $result['id'], 'Getting self id failed');
    }

    /**
     * Testing getSelfLogin method
     */
    public function testGetSelfLogin()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->getSelfLogin();

        // assertions
        $this->assertEquals('admin@localhost', $result['login']);
    }

    /**
     * Testing loginAs method
     */
    public function testLoginAs()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body
        $result = $logic->loginAs();

        // assertions
        $this->assertEquals('value', $result['session_id'], 'Getting self login failed');
    }

    /**
     * Testing loginAs method with id
     */
    public function testLoginAsById()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new MockParamsFetcher2(), $securityProviderMock);

        // test body
        $result = $logic->loginAs();

        // assertions
        $this->assertEquals('value', $result['session_id'], 'Getting self login failed');
    }

    /**
     * Testing validatePermit method
     */
    public function testValidatePermit()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();
        $securityProviderMock->method('validatePermit')->with(
            $this->equalTo('value'),
            $this->equalTo(ServiceLogicUnitTests::TEST_USER_LOGIN));

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body and assertions
        $logic->validatePermit(ServiceLogicUnitTests::TEST_USER_LOGIN);
        $this->addToAssertionCount(1);
    }

    /**
     * Testing hasPermit method
     */
    public function testHasPermit()
    {
        // setup
        $securityProviderMock = $this->getSecurityProviderMock();
        $securityProviderMock->method('hasPermit')->with(
            $this->equalTo('value'),
            $this->equalTo(ServiceLogicUnitTests::TEST_USER_LOGIN));

        $serviceLogicClassName = $this->className;

        $logic = new $serviceLogicClassName(new \Mezon\Transport\Tests\MockParamsFetcher(), $securityProviderMock);

        // test body and assertions
        $logic->hasPermit(ServiceLogicUnitTests::TEST_USER_LOGIN);
        $this->addToAssertionCount(1);
    }
}
