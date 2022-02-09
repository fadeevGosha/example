<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Model\UserRegistrationFormModel;
use App\Validator\UniqueUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['constraints' => [new UniqueUser()]])
            ->add('plainPassword', PasswordType::class,
            [
                'constraints' =>
                [
                    new NotBlank(['message' => 'Пароль не указан']),
                    new Length(['min' => 6, 'minMessage' => 'Пароль не должен быть длинной меньше 6-ти символов'])
                ]
            ])
            ->add('first_name')
            ->add('agreeTerms', CheckboxType::class,
                  [
                      'constraints' =>
                      [
                          new IsTrue(['message' => 'Вы должны согласиться с условиями'])
                      ]
                  ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegistrationFormModel::class,
        ]);
    }
}
