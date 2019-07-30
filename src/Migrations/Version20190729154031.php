<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190729154031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, numbcompt_id INT DEFAULT NULL, raison_sociale VARCHAR(255) NOT NULL, ninea INT NOT NULL, adresse VARCHAR(255) NOT NULL, phone INT NOT NULL, email VARCHAR(255) NOT NULL, statut VARCHAR(255) DEFAULT NULL, INDEX IDX_32FFA373FB88E14F (utilisateur_id), UNIQUE INDEX UNIQ_32FFA3737030EDDC (numbcompt_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, numbcompt INT DEFAULT NULL, solde INT DEFAULT NULL, UNIQUE INDEX UNIQ_CFF6526098DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, date DATE DEFAULT NULL, montant INT DEFAULT NULL, INDEX IDX_47948BBC98DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA3737030EDDC FOREIGN KEY (numbcompt_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD datenais DATE DEFAULT NULL, ADD tel INT NOT NULL, ADD profile VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526098DE13AC');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC98DE13AC');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA3737030EDDC');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE depot');
        $this->addSql('ALTER TABLE utilisateur DROP nom, DROP prenom, DROP adresse, DROP datenais, DROP tel, DROP profile');
    }
}
