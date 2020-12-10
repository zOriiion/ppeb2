<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Abonnement;
use App\Entity\Categorie;
use App\Entity\HistoriqueTest;
use App\Entity\ListeMot;
use App\Entity\Niveau;
use App\Entity\Role;
use App\Entity\Test;
use App\Entity\Theme;
use App\Entity\Utilisateur;
use App\Entity\Vocabulaire;


class AppFixtures extends Fixture
{
    private $manager;
    private $repoUser;
    private $faker;

    public function __construct(){
        $this->faker=Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $repoUser = $this->manager->getRepository(User::class);
        $this->loadAbonnements();
        $this->loadCategories();
        $this->loadNiveaux();
        $this->loadRoles();
        $this->loadThemes();
        $this->loadUtilisateurs();
        $this->loadVocabulaires();
        $this->loadListeMots();
        $this->loadTests();
        $this->loadHistoriqueTests();
        $this->loadUsers();
        
        $manager->flush();
    }

    public function loadUsers(){
        for($i=0;$i<10;$i++){
            $user = new User();
            $user->setUsername($this->faker->username())
            ->setPassword(strtolower($user->getPassword()));
            $this->addReference('user'.$i, $user);
            $this->manager->persist($user);
        }
        $user = new User();
        $user->setUsername('julien.legales@gmail.com')
        ->setPassword('julien');
        $this->addReference('julien', $user);

        $this->manager->flush();

    }

    /* public function loadMessages(){
        for($i=0;$i<20;$i++){
            $message = new Message();
            $message->setTitre($this->faker->sentence());
            $message->setDatePoste($this->faker->dateTimeThisYear);
            $message->setCorps($this->faker->paragraph());
            $message->setUser($this->getReference('user'.mt_rand(0,9)));
            $this->addReference('message'.$i, $message);
            $this->manager->persist($message);
        }

        $message = new Message();
        $message->setTitre($this->faker->sentence());
        $message->setDatePoste($this->faker->dateTimeThisYear);
        $message->setCorps($this->faker->paragraph());
        $message->setUser($this->getReference('julien'));
        $this->manager->persist($message);

        for($i=0;$i<20;$i++){
            $message = new Message();
            $message->setTitre($this->faker->sentence());
            $message->setDatePoste($this->faker->dateTimeThisYear);
            $message->setCorps($this->faker->paragraph());
            $message->setUser($this->getReference('user'.mt_rand(0,9)));
            $message->setMessage($this->getReference('message'.mt_rand(0,19+$i)));
            $this->addReference('message'.(20+$i), $message);
            $this->manager->persist($message);
        }    

        $this->manager->flush();


    } */

    public function loadAbonnements(){
        
        $abonnement = new Abonnement();
        $abonnement->setLibelle('jss1abonnement');
        $this->addReference('jss1abonnement', $abonnement);

        $this->manager->flush();

    }

    public function loadCategories(){
        
        $categorie = new Categorie();
        $categorie->setLibelle('categnom');
        $this->addReference('categnom', $categorie);

        $this->manager->flush();

    }

    public function loadHistoriqueTests(){
        
        $historiqueTest = new HistoriqueTest();
        $utilisateur = new Utilisateur();
        $test = new Test();
        $historiqueTest->setDateTest(new \DateTime())
        ->setResultat(1/20)
        ->setIdUtilisateur($this->getReference('Jean-Pierre'))
        ->setIdTest($this->getReference('testnom'));
        $this->addReference('1', $historiqueTest);

        $this->manager->flush();

    }

    public function loadListeMots(){
       
        $listeMot = new ListeMot();
        $vocabulaire = new Vocabulaire();
        $theme = new Theme();
        $listeMot->setLibelle('mot1')
        ->addIdVocabulaire($this->getReference('bonjour'))
        ->setIdTheme($this->getReference('themenom'));
        $this->addReference('mot1', $listeMot);

        $this->manager->flush();

    }

    public function loadNiveaux(){
        
        $niveau = new Niveau();
        $niveau->setLibelle('niveaunom');
        $this->addReference('niveaunom', $niveau);

        $this->manager->flush();

    }

    public function loadRoles(){
        
        $role = new Role();
        $role->setLibelle('rolenom');
        $this->addReference('rolenom', $role);

        $this->manager->flush();

    }


    public function loadTests(){
       
        $test = new Test();
        $listeMot = new ListeMot();
        $niveau = new Niveau();
        $test->setLibelle('testnom')
        ->addIdListeMot($this->getReference('mot1'))
        ->setIdNiveau($this->getReference('niveaunom'));
        $this->addReference('testnom', $test);

        $this->manager->flush();

    }

    public function loadThemes(){
        
        $theme = new Theme();
        $theme->setLibelle('themenom')
        ->setCategorie('jsslaCateg');
        $this->addReference('themenom', $theme);

        $this->manager->flush();
    }

    public function loadUtilisateurs(){
        
        $utilisateur = new Utilisateur();
        $abonnement = new Abonnement();
        $Role = new Role();
        $utilisateur->setPrenom('Jean-Pierre')
        ->setNom('Dupond')
        ->setEmail('jp.dup@gmail.com')
        ->setMotDePasse('jpd')
        ->setIdAbonnement($this->getReference('jss1abonnement'))
        ->setIdRole($this->getReference('rolenom'))
        ->setDateInscription($this->faker->dateTimeThisYear());
        $this->addReference('Jean-Pierre', $utilisateur);

        $this->manager->flush();
    }

    public function loadVocabulaires(){
        
        $vocabulaire = new Vocabulaire();
        $categorie = new Categorie();
        $vocabulaire->setLibelleNonTraduit('bonjour')
        ->setLibelle('hello')
        ->setLibelleFaux1('ciao')
        ->setLibelleFaux2('bye')
        ->setIdCategorie($this->getReference('categnom'));
        $this->addReference('bonjour', $vocabulaire);

        $this->manager->flush();
    }


}
