<?php


namespace App\Form\Model;


use App\Validator\UniqueUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegistrationFormModel
 * @package App\Form\Model
 */
class UserRegistrationFormModel
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public string $email;
    public string $first_name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="Пароль не должен быть длинной меньше 6-ти символов")
     */
    public string $plainPassword;

    /**
     * @var bool
     * @Assert\IsTrue(message="'Вы должны согласиться с условиями'")
     */
    public bool $agreeTerms;
}