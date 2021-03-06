<?php
namespace Mezon\Service;

use Mezon\Transport\RequestParamsInterface;
use Mezon\Security\ProviderInterface;

/**
 * Class ServiceLogic
 *
 * @package Service
 * @subpackage ServiceLogic
 * @author Dodonov A.A.
 * @version v.1.0 (2019/08/17)
 * @copyright Copyright (c) 2019, aeon.org
 */

/**
 * Class stores all service's logic
 *
 * @author Dodonov A.A.
 */
trait StandartSecurityMethods
{

    /**
     * Method returns request parameter
     *
     * @param string $param
     *            parameter name
     * @param mixed $default
     *            default value
     * @return mixed Parameter value
     */
    protected abstract function getParam($param, $default = false);

    /**
     * Method return params fetcher
     *
     * @return RequestParamsInterface Params fetcher
     */
    public abstract function getParamsFetcher(): RequestParamsInterface;

    /**
     * Method returns security provider
     *
     * @return ProviderInterface
     */
    public abstract function getSecurityProvider(): ProviderInterface;

    /**
     * Method creates connection
     *
     * @return array session id
     */
    public function connect(): array
    {
        $login = $this->getParam($this->getSecurityProvider()
            ->getLoginFieldName(), false);
        $password = $this->getParam('password', false);

        // TODO throw exception with the call stack, for debug purposes
        if ($login === false || $password === false) {
            throw (new \Exception('Fields login and/or password were not set', - 1));
        }

        return [
            $this->getSecurityProvider()->getSessionIdFieldName() => $this->getSecurityProvider()->connect(
                $login,
                $password)
        ];
    }

    /**
     * Method sets token
     *
     * @return array Session id
     */
    public function setToken(): array
    {
        return [
            $this->getSecurityProvider()->getSessionIdFieldName() => $this->getSecurityProvider()->createSession(
                $this->getParam('token'))
        ];
    }

    /**
     * Method returns session user's id
     *
     * @return int Session user's id
     */
    public function getSelfId(): array
    {
        return [
            'id' => $this->getSelfIdValue()
        ];
    }

    /**
     * Method returns session user's login
     *
     * @return string Session user's login
     */
    public function getSelfLogin(): array
    {
        return [
            $this->getSecurityProvider()->getLoginFieldName() => $this->getSelfLoginValue()
        ];
    }

    /**
     * Method returns session id
     *
     * @return string Session id
     */
    protected function getSessionId(): string
    {
        return $this->getParam($this->getSecurityProvider()
            ->getSessionIdFieldName());
    }

    /**
     * Method allows to login under another user
     *
     * @return array Session id
     */
    public function loginAs(): array
    {
        $loginFieldName = $this->getSecurityProvider()->getLoginFieldName();

        // we can login using either user's login or id
        if (($loginOrId = $this->getParam($loginFieldName, '')) !== '') {
            // we are log in using login
            $loginFieldName = 'login';
        } elseif (($loginOrId = $this->getParam('id', '')) !== '') {
            // we are log in using id
            $loginFieldName = 'id';
        }

        return [
            $this->getSecurityProvider()->getSessionIdFieldName() => $this->getSecurityProvider()->loginAs(
                $this->getSessionId(),
                $loginOrId,
                $loginFieldName)
        ];
    }

    /**
     * Method returns self id
     *
     * @return int Session user's id
     */
    public function getSelfIdValue(): int
    {
        return $this->getSecurityProvider()->getSelfId();
    }

    /**
     * Method returns self login
     *
     * @return string Session user's login
     */
    public function getSelfLoginValue(): string
    {
        return $this->getSecurityProvider()->getSelfLogin();
    }

    /**
     * Checking does user has permit
     *
     * @param string $permit
     *            Permit to check
     * @return bool true or false if the session user has permit or not
     */
    public function hasPermit(string $permit): bool
    {
        return $this->getSecurityProvider()->hasPermit($this->getSessionId(), $permit);
    }

    /**
     * The same as hasPermit but throwing exception for session user no permit
     *
     * @param string $permit
     *            Permit name
     */
    public function validatePermit(string $permit)
    {
        $this->getSecurityProvider()->validatePermit($this->getSessionId(), $permit);
    }
}
