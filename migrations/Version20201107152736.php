<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201107152736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, raison_social VARCHAR(50) NOT NULL, siret VARCHAR(20) NOT NULL, adresse VARCHAR(50) DEFAULT NULL, cp VARCHAR(10) DEFAULT NULL, ville VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salarie (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(20) NOT NULL, date_naissance DATE NOT NULL, adresse VARCHAR(50) DEFAULT NULL, cp VARCHAR(20) DEFAULT NULL, ville VARCHAR(30) DEFAULT NULL, date_embauche DATE NOT NULL, INDEX IDX_828E3A1AA4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE salarie ADD CONSTRAINT FK_828E3A1AA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE salarie DROP FOREIGN KEY FK_828E3A1AA4AEAFEA');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE salarie');
    }
}
