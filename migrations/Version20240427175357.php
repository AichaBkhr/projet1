<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240427175357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE details_commandes ADD commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE details_commandes ADD offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE details_commandes ADD CONSTRAINT FK_4FD424F782EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_commandes ADD CONSTRAINT FK_4FD424F74CC8505A FOREIGN KEY (offre_id) REFERENCES offres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4FD424F782EA2E54 ON details_commandes (commande_id)');
        $this->addSql('CREATE INDEX IDX_4FD424F74CC8505A ON details_commandes (offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE details_commandes DROP CONSTRAINT FK_4FD424F782EA2E54');
        $this->addSql('ALTER TABLE details_commandes DROP CONSTRAINT FK_4FD424F74CC8505A');
        $this->addSql('DROP INDEX IDX_4FD424F782EA2E54');
        $this->addSql('DROP INDEX IDX_4FD424F74CC8505A');
        $this->addSql('ALTER TABLE details_commandes DROP commande_id');
        $this->addSql('ALTER TABLE details_commandes DROP offre_id');
    }
}
