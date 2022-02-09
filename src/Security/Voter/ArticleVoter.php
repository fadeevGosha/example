<?php

namespace App\Security\Voter;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ArticleVoter extends Voter
{
    private Security $security;

    /**
     * ArticleVoter constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, ['MANAGE'])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        switch ($attribute) {
            case 'MANAGE':
                    /** @var Article $subject */
                   if($subject->getAuthor() === $user)
                   {
                        return true;
                   }

                   if($this->security->isGranted(User::ROLE_ADMIN_ARTICLE))
                   {
                       return true;
                   }

                break;
        }

        return false;
    }
}
