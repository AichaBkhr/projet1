<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427165127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_commandes DROP CONSTRAINT fk_4fd424f78bf5c2e6');
        $this->addSql('ALTER TABLE details_commandes DROP CONSTRAINT fk_4fd424f76c83cd9f');
        $this->addSql('DROP INDEX idx_4fd424f76c83cd9f');
        $this->addSql('DROP INDEX idx_4fd424f78bf5c2e6');
        $this->addSql('ALTER TABLE details_commandes DROP commandes_id');
        $this->addSql('ALTER TABLE details_commandes DROP offres_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE details_commandes ADD commandes_id INT NOT NULL');
        $this->addSql('ALTER TABLE details_commandes ADD offres_id INT NOT NULL');
        $this->addSql('ALTER TABLE details_commandes ADD CONSTRAINT fk_4fd424f78bf5c2e6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_commandes ADD CONSTRAINT fk_4fd424f76c83cd9f FOREIGN KEY (offres_id) REFERENCES offres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4fd424f76c83cd9f ON details_commandes (offres_id)');
        $this->addSql('CREATE INDEX idx_4fd424f78bf5c2e6 ON details_commandes (commandes_id)');
    }
}
