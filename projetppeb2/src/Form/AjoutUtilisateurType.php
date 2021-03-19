<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AjoutUtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class)
            ->add('nom', TextType::class)
            ->add('email', TextType::class)
            ->add('motdepasse', PasswordType::class)
            ->add('idRole', EntityType::class,
            array( 'class' => 'App\Entity\Role',
            'choice_label' => 'libelle'))
            ->add('idAbonnement', EntityType::class,
            array( 'class' => 'App\Entity\Abonnement',
            'choice_label' => 'libelle'))
            ->add('user', HiddenType::class, array('mapped'=>false, 'data'=>$options['user']))
            ->add('ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'user' => 1
        ]);

    }
}
