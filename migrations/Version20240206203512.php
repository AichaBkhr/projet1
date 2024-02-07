<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206203512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Modifier la colonne pour autoriser les valeurs NULL
    }

    public function down(Schema $schema): void
    {
        // Revenir à l'état précédent en interdisant les valeurs NULL
    }
}
