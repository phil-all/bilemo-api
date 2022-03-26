<?php

namespace App\Form;

use App\Entity\Shopper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

/**
 * ShopperFormType class
 * @package App\Form
 */
class ShopperFormType extends AbstractType
{
    /**
     * Build Form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'email' . $options['messageNotBlank'],
                    ]),
                    new Regex([
                        'pattern' => $options['regexCorrectEmail'],
                        'message' => 'email is not valid',
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'firstName' . $options['messageNotBlank'],
                    ]),
                    new Length([
                        'max' => 80,
                        'maxMessage' => 'firstName' . $options['message80LetterMax'],
                    ]),
                    new Regex([
                        'pattern' => $options['regexCapitalizeFisrt'],
                        'message' => 'firstName' . $options['messageCapitalFisrt'],
                    ]),
                    new Regex([
                        'pattern' => $options['regexNameCharacters'],
                        'message' => 'firstName' . $options['messageContainLetters'],
                    ]),
                ]
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'lastName' . $options['messageNotBlank'],
                    ]),
                    new Length([
                        'max' => 80,
                        'maxMessage' => 'lastName' . $options['message80LetterMax'],
                    ]),
                    new Regex([
                        'pattern' => $options['regexCapitalizeFisrt'],
                        'message' => 'lastName' . $options['messageCapitalFisrt'],
                    ]),
                    new Regex([
                        'pattern' => $options['regexNameCharacters'],
                        'message' => 'lastName' . $options['messageContainLetters'],
                    ]),
                ]
            ]);
    }

    /**
     * Set form options
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'            => Shopper::class,
            'messageNotBlank'       => ' should not be blank',
            'message80LetterMax'    => ' should be at most 80 characters',
            'messageCapitalFisrt'   => ' should start with a capital letter',
            'messageContainLetters' => ' should contain only letters, dash, quote or space',
            'regexCorrectEmail'     => '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]{2,3}$/',
            'regexCapitalizeFisrt'  => '/^(?=.*[A-Z]).*$/',
            'regexNameCharacters'   => '/^[a-zA-zÀ-ÖØ-öø-ÿœŒ\s\-\']+$/',
        ]);
    }
}
