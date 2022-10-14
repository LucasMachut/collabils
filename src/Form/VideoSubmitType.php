<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class VideoSubmitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => '* Titre',
                'constraints' => new NotBlank(),
                ])
            ->add('definition', TextType::class, [
                'label' => '* Définition',
                'constraints' => new NotBlank(),
                ])
            ->add('context', TextType::class, [
                'label' => '* Contexte d\'utilisation du signe',
                'constraints' => new NotBlank(),
                ])
            ->add('category')
            /*TODO 
            Ajouter la video
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
