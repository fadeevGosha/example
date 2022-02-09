<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\IUserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Article|null $article * $article */
        $article = $options['data'] ?? null;
        $cannotEditAuthor = $article && $article->getId() && $article->isPublished();

        $builder
            ->add('image', FileType::class,
            [
                'mapped' => false
            ]
            )
            ->add('title', TextType::class,
                [
                    'label' => 'Укажите название статьи',
                    'help'  => 'Не используйте в названии слово "собака"',
                    'required' => false
                ]
            )
            ->add('body', TextareaType::class,
                  [
                      'label' => 'Укажите тело статьи',
                      'required' => false,
                      'rows' => 15
                  ])
            ->add('author', EntityType::class,
            [
                'class' => User::class,
                'choice_label' => function(User $user)
                {
                    return sprintf('%s (id: %d)', $user->getFirstName(), $user->getId());
                },
                'placeholder' => 'Выберите автора статьи',
                'choices' => $this->userRepository->findAllSortedByName(),
                'invalid_message' => 'Такой автор не существует',
                'disabled' => $cannotEditAuthor,
            ]);

        if($options['enabled_published_at'])
        {
            $builder->add('publishedAt', null,
                  [
                      'label' => 'Выберите дату публикации',
                      'widget' => 'single_text'
                  ]);
        }

        $builder->get('body')
            ->addModelTransformer(new CallbackTransformer(
                function ($bodyFromDatabase)
                {
                    return str_replace('****собака****', 'собака', $bodyFromDatabase);
                },
                function ($bodyFromInput)
                {
                    return str_replace('собака', '****собака****', $bodyFromInput);
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'enabled_published_at' => false
        ]);
    }
}
