<?php

namespace App\Form\Types;

use App\Form\Transformers\CommentTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentsType extends AbstractType
{
    private CommentTransformer $transformer;

    public function __construct(
        CommentTransformer $transformer
    )
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    public function getParent()
    {
        return TextType::class;
    }    
}