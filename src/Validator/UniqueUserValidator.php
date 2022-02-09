<?php

namespace App\Validator;

use App\Repository\IUserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserValidator extends ConstraintValidator
{
    private IUserRepository $userRepository;

    /**
     * UniqueUserValidator constructor.
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint UniqueUser */

        if (null === $value || '' === $value) {
            return;
        }

        if(!$this->userRepository->count(['email' => $value]))
        {
            return;
        }


        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
