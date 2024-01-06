<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106022942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_commandes ADD offres_id INT NOT NULL');
        $this->addSql('ALTER TABLE details_commandes ADD CONSTRAINT FK_4FD424F76C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4FD424F76C83CD9F ON details_commandes (offres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE details_commandes DROP CONSTRAINT FK_4FD424F76C83CD9F');
        $this->addSql('DROP INDEX IDX_4FD424F76C83CD9F');
        $this->addSql('ALTER TABLE details_commandes DROP offres_id');
    }
}
