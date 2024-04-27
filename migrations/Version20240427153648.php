<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427153648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateurs_offres DROP CONSTRAINT fk_eb4d524c1e969c5');
        $this->addSql('ALTER TABLE utilisateurs_offres DROP CONSTRAINT fk_eb4d524c6c83cd9f');
        $this->addSql('ALTER TABLE offres_utilisateurs DROP CONSTRAINT fk_6c58bfb76c83cd9f');
        $this->addSql('ALTER TABLE offres_utilisateurs DROP CONSTRAINT fk_6c58bfb71e969c5');
        $this->addSql('DROP TABLE utilisateurs_offres');
        $this->addSql('DROP TABLE offres_utilisateurs');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE utilisateurs_offres (utilisateurs_id INT NOT NULL, offres_id INT NOT NULL, PRIMARY KEY(utilisateurs_id, offres_id))');
        $this->addSql('CREATE INDEX idx_eb4d524c6c83cd9f ON utilisateurs_offres (offres_id)');
        $this->addSql('CREATE INDEX idx_eb4d524c1e969c5 ON utilisateurs_offres (utilisateurs_id)');
        $this->addSql('CREATE TABLE offres_utilisateurs (offres_id INT NOT NULL, utilisateurs_id INT NOT NULL, PRIMARY KEY(offres_id, utilisateurs_id))');
        $this->addSql('CREATE INDEX idx_6c58bfb71e969c5 ON offres_utilisateurs (utilisateurs_id)');
        $this->addSql('CREATE INDEX idx_6c58bfb76c83cd9f ON offres_utilisateurs (offres_id)');
        $this->addSql('ALTER TABLE utilisateurs_offres ADD CONSTRAINT fk_eb4d524c1e969c5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateurs_offres ADD CONSTRAINT fk_eb4d524c6c83cd9f FOREIGN KEY (offres_id) REFERENCES offres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offres_utilisateurs ADD CONSTRAINT fk_6c58bfb76c83cd9f FOREIGN KEY (offres_id) REFERENCES offres (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE offres_utilisateurs ADD CONSTRAINT fk_6c58bfb71e969c5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateurs (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
