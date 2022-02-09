<?php

namespace App\Security;

use App\Repository\IApiTokenRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class ApiTokenAuthenticator extends AbstractGuardAuthenticator
{
    private IApiTokenRepository $apiTokenRepository;

    /**
     * ApiTokenAuthenticator constructor.
     * @param IApiTokenRepository $apiTokenRepository
     */
    public function __construct(IApiTokenRepository $apiTokenRepository)
    {
        $this->apiTokenRepository = $apiTokenRepository;
    }

    public function supports(Request $request): bool
    {
        return $request->headers->has('Authorization') && 0 === strpos($request->headers->get('Authorization'), 'Bearer');
    }

    public function getCredentials(Request $request)
    {
        return substr($request->headers->get('Authorization'), strpos($request->headers->get('Authorization'), ' ') + 1) ;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
       $token = $this->apiTokenRepository->findOneBy(['token' => $credentials]);

       if(!$token)
       {
           throw new CustomUserMessageAccountStatusException('Invalid token');

       }

       if($token->isExpired())
       {
           throw new CustomUserMessageAccountStatusException('Token expired');
       }

       return $token->getUser();
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return new JsonResponse(['message' => $exception->getMessage()], 401);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        // todo
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        throw new \Exception('Never called!');
    }

    public function supportsRememberMe(): bool
    {
       return false;
    }
}
