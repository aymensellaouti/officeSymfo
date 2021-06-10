<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610104923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, classe VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, designation VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA36BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_departement (ticket_id INT NOT NULL, departement_id INT NOT NULL, INDEX IDX_ADE65D1C700047D2 (ticket_id), INDEX IDX_ADE65D1CCCF9E01E (departement_id), PRIMARY KEY(ticket_id, departement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA36BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ticket_departement ADD CONSTRAINT FK_ADE65D1C700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_departement ADD CONSTRAINT FK_ADE65D1CCCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_departement DROP FOREIGN KEY FK_ADE65D1CCCF9E01E');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA36BF700BD');
        $this->addSql('ALTER TABLE ticket_departement DROP FOREIGN KEY FK_ADE65D1C700047D2');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_departement');
    }
}
