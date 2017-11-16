<?php

namespace FollowMeBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormError;


class Dating extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
    ->add("user_mail", EmailType::class, [
        "label" => "site-addr",
        "constraints" => [
            new Email([
                "message" => "mesg-emai"
            ]),
            new NotBlank([
                "message" => "mesg-emai"
            ])
        ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "Adresse Email",
        ]
    ])
    ->add("user_pswd", TextType::class, [
        "label" => "site-pswd",
        "constraints" => [
            new Regex([
                "pattern" => "/^[\w]{8,32}$/",
                "message" => "mesg-pswd"
            ]),
            new NotBlank([
                "message" => "mesg-pswd"
            ])
        ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "Mot de passe",
        ]
    ]);
    
    }        
}