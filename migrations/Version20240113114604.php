<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240113114604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //$this->addSql('ALTER TABLE utilisateurs ADD resert_token BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateurs DROP resert_token');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified TYPE BOOLEAN');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified SET DEFAULT false');
        $this->addSql('ALTER TABLE utilisateurs ALTER is_verified TYPE BOOLEAN');
    }
}
