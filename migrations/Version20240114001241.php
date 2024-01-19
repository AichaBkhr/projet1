<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240114001241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE utilisateurs SET roles = \'["ROLE_USER"]\' WHERE roles IS NULL');
        $this->addSql('ALTER TABLE utilisateurs ALTER COLUMN roles SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE utilisateurs ALTER COLUMN roles DROP NOT NULL');
    }
}
