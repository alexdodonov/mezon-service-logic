<?php
namespace Mezon\Service;

use Mezon\Transport\RequestParamsInterface;
use Mezon\Security\AuthorizationProviderInterface;
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
     * Method sets security provider
     *
     * @param ProviderInterface $securityProvider
     */
    public abstract function setSecurityProvider(ProviderInterface $securityProvider): void;

    /**
     * Method returns security provider
     *
     * @return AuthorizationProviderInterface
     */
    public abstract function getAuthorizationProvider(): AuthorizationProviderInterface;

    /**
     * Method creates connection
     *
     * @return array session id
     */
    public function connect(): array
    {
        $login = $this->getParam($this->getAuthorizationProvider()
            ->getLoginFieldName(), false);
        $password = $this->getParam('password', false);

        // TODO throw exception with the call stack, for debug purposes
        if ($login === false || $password === false) {
            throw (new \Exception('Fields login and/or password were not set', - 1));
        }

        return [
            $this->getAuthorizationProvider()->getSessionIdFieldName() => $this->getAuthorizationProvider()->connect(
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
            $this->getAuthorizationProvider()->getSessionIdFieldName() => $this->getAuthorizationProvider()->createSession(
                $this->getParam('token'))
        ];
    }

    /**
     * Method returns session user's id
     *
     * @return array session user's id
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
     * @return array session user's login
     */
    public function getSelfLogin(): array
    {
        return [
            $this->getAuthorizationProvider()->getLoginFieldName() => $this->getSelfLoginValue()
        ];
    }

    /**
     * Method returns session id
     *
     * @return string session id
     */
    protected function getSessionId(): string
    {
        return $this->getParam($this->getAuthorizationProvider()
            ->getSessionIdFieldName());
    }

    /**
     * Method allows to login under another user
     *
     * @return array session id
     */
    public function loginAs(): array
    {
        $loginFieldName = $this->getAuthorizationProvider()->getLoginFieldName();

        // we can login using either user's login or id
        if (($loginOrId = $this->getParam($loginFieldName, '')) !== '') {
            // we are log in using login
            $loginFieldName = 'login';
        } elseif (($loginOrId = $this->getParam('id', '')) !== '') {
            // we are log in using id
            $loginFieldName = 'id';
        }

        return [
            $this->getAuthorizationProvider()->getSessionIdFieldName() => $this->getAuthorizationProvider()->loginAs(
                $this->getSessionId(),
                $loginOrId,
                $loginFieldName)
        ];
    }

    /**
     * Method returns self id
     *
     * @return int session user's id
     */
    public function getSelfIdValue(): int
    {
        return $this->getAuthorizationProvider()->getSelfId();
    }

    /**
     * Method returns self login
     *
     * @return string session user's login
     */
    public function getSelfLoginValue(): string
    {
        return $this->getAuthorizationProvider()->getSelfLogin();
    }

    /**
     * Checking does user has permit
     *
     * @param string $permit
     *            permit to check
     * @return bool true or false if the session user has permit or not
     */
    public function hasPermit(string $permit): bool
    {
        return $this->getAuthorizationProvider()->hasPermit($this->getSessionId(), $permit);
    }

    /**
     * The same as hasPermit but throwing exception for session user no permit
     *
     * @param string $permit
     *            permit name
     */
    public function validatePermit(string $permit): void
    {
        $this->getAuthorizationProvider()->validatePermit($this->getSessionId(), $permit);
    }
}
