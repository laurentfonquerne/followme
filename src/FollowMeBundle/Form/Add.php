<?php

namespace FollowMeBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\FormError;


class Add extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
    ->add("dating_title", TextType::class, [
        "label" => "dating-title",
        "constraints" => [
            
            new NotBlank([
                "message" => "mesg-title"
            ])
        ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "titre",
        ],
                
    ])
    ->add("dating_start", DateTimeType::class, [
        "label" => "dating-start",
        "format" => "YYYY-MM-dd HH:mm",
        // "constraints" => [
        //     new TextType([
        //         "message" => "mesg-date"
        //     ]),
        //     new NotBlank([
        //         "message" => "mesg-date"
        //     ])
        // ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "Date Debut",
        ],
                
    ])
    ->add("dating_end", TimeType::class, [
        "label" => "dating-end",
        // "constraints" => [
        //     new TextType([
        //         "message" => "mesg-date"
        //     ]),
        //     new NotBlank([
        //         "message" => "mesg-date"
        //     ])
        // ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "Date Fin",
        ],
                
    ])
    ->add("dating_description", TextType::class, [
        "label" => "dating-description",
    //     "constraints" => [
    //         new TextType([
    //             "message" => "mesg-description"
    //         ]),
    //         new NotBlank([
    //             "message" => "mesg-description"
    //         ])
    //     ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "description",
        ],
                
    ])
    ->add("dating_lat", TextType::class, [
        "label" => "dating-lat",
    //     "constraints" => [
    //         new TextType([
    //             "message" => "mesg-lat"
    //         ]),
    //         new NotBlank([
    //             "message" => "mesg-lat"
    //         ])
    //     ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "lattitude",
        ],
                
    ])
    ->add("dating_lng", TextType::class, [
        "label" => "dating-lng",
    //     "constraints" => [
    //         new TextType([
    //             "message" => "mesg-lng"
    //         ]),
    //         new NotBlank([
    //             "message" => "mesg-lng"
    //         ])
    //     ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "longitude",
        ],
                
    ])
    ->add("dating_link_href", TextType::class, [
        "label" => "dating-link-href",
    //     "constraints" => [
    //         new TextType([
    //             "message" => "mesg-link-href"
    //         ]),
    //         new NotBlank([
    //             "message" => "mesg-link-href"
    //         ])
    //     ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "link",
        ],
                
    ])
    ->add("dating_link_title", TextType::class, [
        "label" => "dating-link-title",
    //     "constraints" => [
    //         new TextType([
    //             "message" => "mesg-link-title"
    //         ]),
    //         new NotBlank([
    //             "message" => "mesg-link-title"
    //         ])
    //     ],
        "attr" => [
            "class" => "form-control",
            "placeholder" => "title link",
        ],
                
    ])
    
    ;
    
    }        
}