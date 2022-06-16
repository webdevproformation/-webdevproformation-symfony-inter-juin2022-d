<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // permet de créer les champs du formulaire et ne pas hésiter à ajouter toutes options les champs mis dans le controller
        $builder
            ->add("nom", null , [
                "label" => "saisir le nom de la catégorie" , 
                "attr" => ["placeholder" => "votre catégorie"]
                        ])
            ->add("description" , null , [
                    "label" => "saisir le nom de la catégorie (facultatif)" ,
                    "attr" => [ "rows" => 5 ]
                    ])
            ->add("enregistrer" , SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // liaison entre le formulaire et l'entité Categorie
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
