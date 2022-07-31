<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\EnvPlaceholderParameterBag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Config\Framework\Workflows\WorkflowsConfig\PlaceConfig;

class NewUserType extends AbstractType
{
        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
                $builder
                        // PRENOM
                        ->add('firstname', TextType::class, [
                                'label' => 'Prénom',
                                'attr' => array(
                                        'placeholder' => 'Prénom'
                                ),
                                'constraints' => new NotBlank()
                        ])
                        // NOM
                        ->add('lastname', TextType::class, [
                                'label' => 'Nom',
                                'attr' => array(
                                        'placeholder' => 'Nom'
                                ),
                                'constraints' => new NotBlank()
                        ])
                        // EMAIL        
                        ->add('email', RepeatedType::class, [
                                'type' => EmailType::class,
                                'invalid_message' => 'Les emails doivent correspondre',
                                'first_options'  => [
                                        'label' => '* Adresse email',
                                        'constraints' => new NotBlank(),
                                        'constraints' => new NotNull(),
                                        'attr' => array(
                                                'type' => 'email',
                                                'placeholder' => 'Email'
                                        )
                                ],
                                'second_options' => [
                                        'label' => '* Confirmez l\'adresse email',
                                        'constraints' => new NotBlank(),
                                        'constraints' => new NotNull(),
                                        'attr' => array(
                                                'type' => 'email',
                                                'placeholder' => 'Email'
                                        )
                                ],
                        ])
                        // PASSWORD                    
                        ->add('password', RepeatedType::class, [
                                'type' => PasswordType::class,
                                'invalid_message' => 'Les mots de passe doivent correspondre.',
                                'label' => 'Entrez un mot de passe',
                                'first_options'  => [
                                        'label' => '* Mot de passe',
                                        'constraints' => new NotBlank(),
                                        'constraints' => new NotNull(),
                                        'attr' => array(
                                                'type' => 'password',
                                                'placeholder' => 'Password'
                                        ),
                                ],
                                'second_options' => [
                                        'label' => '* Confirmez le mot de passe',
                                        'constraints' => new NotBlank(),
                                        'constraints' => new NotNull(),
                                        'attr' => array(
                                                'type' => 'password',
                                                'placeholder' => 'Password'
                                        ),
                                ],
                        ])
                        // JOB                    
                        ->add('lastname', TextType::class, [
                            'label' => 'Nom',
                            'attr' => array(
                                    'placeholder' => 'Nom'
                            ),
                            'constraints' => new NotBlank()
                        ]);
        }

        public function configureOptions(OptionsResolver $resolver): void
        {
                $resolver->setDefaults([
                        'data_class' => User::class,
                ]);
        }
        //TODO make UserEntity and UserController
}