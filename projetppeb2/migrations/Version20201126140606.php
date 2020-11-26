<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126140606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_mot_vocabulaire (liste_mot_id INT NOT NULL, vocabulaire_id INT NOT NULL, INDEX IDX_FA787D4552E60369 (liste_mot_id), INDEX IDX_FA787D45D8B12F03 (vocabulaire_id), PRIMARY KEY(liste_mot_id, vocabulaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_liste_mot (test_id INT NOT NULL, liste_mot_id INT NOT NULL, INDEX IDX_6BEAB2D21E5D0459 (test_id), INDEX IDX_6BEAB2D252E60369 (liste_mot_id), PRIMARY KEY(test_id, liste_mot_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_mot_vocabulaire ADD CONSTRAINT FK_FA787D4552E60369 FOREIGN KEY (liste_mot_id) REFERENCES liste_mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_mot_vocabulaire ADD CONSTRAINT FK_FA787D45D8B12F03 FOREIGN KEY (vocabulaire_id) REFERENCES vocabulaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_liste_mot ADD CONSTRAINT FK_6BEAB2D21E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE test_liste_mot ADD CONSTRAINT FK_6BEAB2D252E60369 FOREIGN KEY (liste_mot_id) REFERENCES liste_mot (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie ADD id_categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6349F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_497DD6349F34925F ON categorie (id_categorie_id)');
        $this->addSql('ALTER TABLE historique_test ADD id_utilisateur_id INT DEFAULT NULL, ADD id_test_id INT NOT NULL');
        $this->addSql('ALTER TABLE historique_test ADD CONSTRAINT FK_5C2659EEC6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE historique_test ADD CONSTRAINT FK_5C2659EEC0C0AD29 FOREIGN KEY (id_test_id) REFERENCES test (id)');
        $this->addSql('CREATE INDEX IDX_5C2659EEC6EE5C49 ON historique_test (id_utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_5C2659EEC0C0AD29 ON historique_test (id_test_id)');
        $this->addSql('ALTER TABLE liste_mot ADD id_theme_id INT NOT NULL, ADD id_there VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE liste_mot ADD CONSTRAINT FK_E97725189D99812 FOREIGN KEY (id_theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_E97725189D99812 ON liste_mot (id_theme_id)');
        $this->addSql('ALTER TABLE test ADD id_niveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C8B0B20A6 FOREIGN KEY (id_niveau_id) REFERENCES niveau (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0C8B0B20A6 ON test (id_niveau_id)');
        $this->addSql('ALTER TABLE utilisateur ADD id_abonnement_id INT DEFAULT NULL, ADD id_role_id INT NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34FFF9576 FOREIGN KEY (id_abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B389E8BDC FOREIGN KEY (id_role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B34FFF9576 ON utilisateur (id_abonnement_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B389E8BDC ON utilisateur (id_role_id)');
        $this->addSql('ALTER TABLE vocabulaire ADD id_categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE vocabulaire ADD CONSTRAINT FK_DB1ADE7D9F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_DB1ADE7D9F34925F ON vocabulaire (id_categorie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE liste_mot_vocabulaire');
        $this->addSql('DROP TABLE test_liste_mot');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6349F34925F');
        $this->addSql('DROP INDEX IDX_497DD6349F34925F ON categorie');
        $this->addSql('ALTER TABLE categorie DROP id_categorie_id');
        $this->addSql('ALTER TABLE historique_test DROP FOREIGN KEY FK_5C2659EEC6EE5C49');
        $this->addSql('ALTER TABLE historique_test DROP FOREIGN KEY FK_5C2659EEC0C0AD29');
        $this->addSql('DROP INDEX IDX_5C2659EEC6EE5C49 ON historique_test');
        $this->addSql('DROP INDEX IDX_5C2659EEC0C0AD29 ON historique_test');
        $this->addSql('ALTER TABLE historique_test DROP id_utilisateur_id, DROP id_test_id');
        $this->addSql('ALTER TABLE liste_mot DROP FOREIGN KEY FK_E97725189D99812');
        $this->addSql('DROP INDEX IDX_E97725189D99812 ON liste_mot');
        $this->addSql('ALTER TABLE liste_mot DROP id_theme_id, DROP id_there');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C8B0B20A6');
        $this->addSql('DROP INDEX IDX_D87F7E0C8B0B20A6 ON test');
        $this->addSql('ALTER TABLE test DROP id_niveau_id');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B34FFF9576');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B389E8BDC');
        $this->addSql('DROP INDEX IDX_1D1C63B34FFF9576 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B389E8BDC ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP id_abonnement_id, DROP id_role_id');
        $this->addSql('ALTER TABLE vocabulaire DROP FOREIGN KEY FK_DB1ADE7D9F34925F');
        $this->addSql('DROP INDEX IDX_DB1ADE7D9F34925F ON vocabulaire');
        $this->addSql('ALTER TABLE vocabulaire DROP id_categorie_id');
    }
}
