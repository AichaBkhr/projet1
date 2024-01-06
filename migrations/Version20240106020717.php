<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106020717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE commandes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE details_commandes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE images_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE offres_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateurs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commandes (id INT NOT NULL, utilisateur_id INT DEFAULT NULL, reference VARCHAR(20) NOT NULL, date_de_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, cle_2 VARCHAR(255) NOT NULL, qr_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282CD2A8ABEB ON commandes (cle_2)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_35D4282C7D8B1FB5 ON commandes (qr_code)');
        $this->addSql('CREATE INDEX IDX_35D4282CFB88E14F ON commandes (utilisateur_id)');
        $this->addSql('COMMENT ON COLUMN commandes.date_de_creation IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE details_commandes (id INT NOT NULL, commandes_id INT NOT NULL, quantité INT NOT NULL, prix INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4FD424F78BF5C2E6 ON details_commandes (commandes_id)');
        $this->addSql('CREATE TABLE images (id INT NOT NULL, offres_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E01FBE6A6C83CD9F ON images (offres_id)');
        $this->addSql('CREATE TABLE offres (id INT NOT NULL, type VARCHAR(255) NOT NULL, prix INT NOT NULL, capacité INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C6AC35448CDE5729 ON offres (type)');
        $this->addSql('CREATE TABLE utilisateurs (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom_utilisateur VARCHAR(255) NOT NULL, cle_1 VARCHAR(255) NOT NULL, date_de_creation TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315EE7927C74 ON utilisateurs (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315E4BA1FA51 ON utilisateurs (cle_1)');
        $this->addSql('COMMENT ON COLUMN utilisateurs.date_de_creation IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE details_commandes ADD CONSTRAINT FK_4FD424F78BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A6C83CD9F FOREIGN KEY (offres_id) REFERENCES offres (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE commandes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE details_commandes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE images_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE offres_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateurs_id_seq CASCADE');
        $this->addSql('ALTER TABLE commandes DROP CONSTRAINT FK_35D4282CFB88E14F');
        $this->addSql('ALTER TABLE details_commandes DROP CONSTRAINT FK_4FD424F78BF5C2E6');
        $this->addSql('ALTER TABLE images DROP CONSTRAINT FK_E01FBE6A6C83CD9F');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE details_commandes');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE offres');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
