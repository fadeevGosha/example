<?php


namespace App\Form\Transformers;


use App\Entity\Comment;
use App\Repository\ICommentRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class CommentTransformer implements DataTransformerInterface
{
    private ICommentRepository $commentRepository;

    public function __construct(ICommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function transform($value)
    {
        return ($value instanceof Comment) ? $value->getId() : null;
    }

    public function reverseTransform($value)
    {
        $comment =  $this->commentRepository->findOneBy(['id' => $value]);

        if(!$comment)
        {
            throw new TransformationFailedException(sprintf('User file with id "%s" does not exist', $value));
        }

        return $comment;
    }
}