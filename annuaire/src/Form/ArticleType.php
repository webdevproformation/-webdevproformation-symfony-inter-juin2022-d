<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Auteur;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('contenu')
            ->add('auteur', EntityType::class , [ // OBLIGATOIRE vous devez le préciser
                "class" => Auteur::class, // préciser l'entité associée
                "choice_label" => "nom"      // préciser la colonne qui va servir dans le menu déroulant
                // mettre à jour les setter et getter (mis manuellement)
                // php bin/console make:entity --regenerate
            ])
            ->add("categorie" , EntityType::class , [
                "class" => Categorie::class,
                "choice_label" => "libelle"
            ])
            ->add("image_une" , FileType::class , [
                        "mapped" => false , // champ non  associé à une propriété de notre entité Article
                        "label" => "image à la une de l'article"
                        ]) 
            ->add("save", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
