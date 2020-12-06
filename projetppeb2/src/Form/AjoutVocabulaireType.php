<?php

namespace App\Form;

use App\Entity\Vocabulaire;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AjoutVocabulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('libelleNonTraduit', TextType::class)
            ->add('libelle', TextType::class)
            ->add('libelleFaux1', TextType::class)
            ->add('libelleFaux2', TextType::class)
            ->add('idCategorie', EntityType::class,
            array( 'class' => 'App\Entity\Categorie',
            'choice_label' => 'libelle'))
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vocabulaire::class,
        ]);
    }
}
