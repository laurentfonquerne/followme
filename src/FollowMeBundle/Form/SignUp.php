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


class SignUp extends SignIn
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    parent::buildForm($builder, $options);    
    $builder
    
    ->add("confirm", TextType::class, [
        "label" => "site-conf",
        "constraints" => [
            new Regex([
                "pattern" => "/^[\w]{8,32}$/",
                "message" => "mesg-emai"
            ]),
            new NotBlank([
                "message" => "mesg-emai"
            ])
        ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "Confirmation",
        ]
    ]);
    }        
}