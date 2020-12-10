<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210162137 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique_test (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT DEFAULT NULL, id_test_id INT NOT NULL, datetest DATE NOT NULL, resultat INT NOT NULL, INDEX IDX_5C2659EEC6EE5C49 (id_utilisateur_id), INDEX IDX_5C2659EEC0C0AD29 (id_test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_mot (id INT AUTO_INCREMENT NOT NULL, id_theme_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_E97725189D99812 (id_theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_mot_vocabulaire (liste_mot_id INT NOT NULL, vocabulaire_id INT NOT NULL, INDEX IDX_FA787D4552E60369 (liste_mot_id), INDEX IDX_FA787D45D8B12F03 (vocabulaire_id), PRIMARY KEY(liste_mot_id, vocabulaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, id_niveau_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_D87F7E0C8B0B20A6 (id_niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_liste_mot (test_id INT NOT NULL, liste_mot_id INT NOT NULL, INDEX IDX_6BEAB2D21E5D0459 (test_id), INDEX IDX_6BEAB2D252E60369 (liste_mot_id), PRIMARY KEY(test_id, liste_mot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, id_abonnement_id INT DEFAULT NULL, id_role_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(25) NOT NULL, motdepasse VARCHAR(255) NOT NULL, dateinscription DATE NOT NULL, INDEX IDX_1D1C63B34FFF9576 (id_abonnement_id), INDEX IDX_1D1C63B389E8BDC (id_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vocabulaire (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT DEFAULT NULL, libelle_non_traduit VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, libelle_faux1 VARCHAR(255) NOT NULL, libelle_faux2 VARCHAR(255) NOT NULL, INDEX IDX_DB1ADE7D9F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique_test ADD CONSTRAINT FK_5C2659EEC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE historique_test ADD CONSTRAINT FK_5C2659EEC0C0AD29 FOREIGN KEY (id_test_id) REFERENCES test (id)');
        $this->addSql('ALTER TABLE liste_mot ADD CONSTRAINT FK_E97725189D99812 FOREIGN KEY (id_theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE liste_mot_vocabulaire ADD CONSTRAINT FK_FA787D4552E60369 FOREIGN KEY (liste_mot_id) REFERENCES liste_mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_mot_vocabulaire ADD CONSTRAINT FK_FA787D45D8B12F03 FOREIGN KEY (vocabulaire_id) REFERENCES vocabulaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C8B0B20A6 FOREIGN KEY (id_niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE test_liste_mot ADD CONSTRAINT FK_6BEAB2D21E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_liste_mot ADD CONSTRAINT FK_6BEAB2D252E60369 FOREIGN KEY (liste_mot_id) REFERENCES liste_mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34FFF9576 FOREIGN KEY (id_abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B389E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE vocabulaire ADD CONSTRAINT FK_DB1ADE7D9F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34FFF9576');
        $this->addSql('ALTER TABLE vocabulaire DROP FOREIGN KEY FK_DB1ADE7D9F34925F');
        $this->addSql('ALTER TABLE liste_mot_vocabulaire DROP FOREIGN KEY FK_FA787D4552E60369');
        $this->addSql('ALTER TABLE test_liste_mot DROP FOREIGN KEY FK_6BEAB2D252E60369');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C8B0B20A6');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B389E8BDC');
        $this->addSql('ALTER TABLE historique_test DROP FOREIGN KEY FK_5C2659EEC0C0AD29');
        $this->addSql('ALTER TABLE test_liste_mot DROP FOREIGN KEY FK_6BEAB2D21E5D0459');
        $this->addSql('ALTER TABLE liste_mot DROP FOREIGN KEY FK_E97725189D99812');
        $this->addSql('ALTER TABLE historique_test DROP FOREIGN KEY FK_5C2659EEC6EE5C49');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FB88E14F');
        $this->addSql('ALTER TABLE liste_mot_vocabulaire DROP FOREIGN KEY FK_FA787D45D8B12F03');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE historique_test');
        $this->addSql('DROP TABLE liste_mot');
        $this->addSql('DROP TABLE liste_mot_vocabulaire');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE test_liste_mot');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE vocabulaire');
    }
}
