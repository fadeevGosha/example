<?php

namespace App\Validator;

use App\Repository\ICommentRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CommentsValidationValidator extends ConstraintValidator
{
    private ICommentRepository $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        if(count($value) > 2)
        {
            return;
        }


        // TODO: implement the validation here
        $this->context->buildViolation('Комментариев меньше 3')
            ->setParameter('{{ value }}', 3)
            ->addViolation();
    }
}
