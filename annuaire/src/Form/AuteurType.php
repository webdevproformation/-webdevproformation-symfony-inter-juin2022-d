<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // https://symfony.com/doc/current/reference/forms/types/choice.html
        $roles = [];
        foreach( (new Auteur())->listRole() as $r){
            $roles[$r] = $r;
        }

        $builder
            ->add('nom')
            ->add('role', ChoiceType::class , [
                "choices" => $roles
                /* [
                    "admin" => "admin" , "redacteur" => "redacteur"
                ] */
            ])
            ->add('actif')
            ->add("photo_profil" , FileType::class , ["mapped" => false])
            ->add("save", SubmitType::class , ["attr" => ["class"=> "btn btn-warning"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
