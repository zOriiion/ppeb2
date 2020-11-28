<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201128181441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_mot ADD CONSTRAINT FK_E97725189D99812 FOREIGN KEY (id_theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_E97725189D99812 ON liste_mot (id_theme_id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE id_role_id id_role_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_mot DROP FOREIGN KEY FK_E97725189D99812');
        $this->addSql('DROP INDEX IDX_E97725189D99812 ON liste_mot');
        $this->addSql('ALTER TABLE utilisateur CHANGE id_role_id id_role_id INT NOT NULL');
    }
}
