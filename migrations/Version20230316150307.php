<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316150307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE harbor (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, department VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE tide (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, harbor_id INTEGER DEFAULT NULL, high_height DOUBLE PRECISION NOT NULL, low_height DOUBLE PRECISION NOT NULL, high_hour DATETIME NOT NULL, low_hour DATETIME NOT NULL, coefficient DOUBLE PRECISION NOT NULL, CONSTRAINT FK_BE56230C606C6CCD FOREIGN KEY (harbor_id) REFERENCES harbor (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BE56230C606C6CCD ON tide (harbor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE harbor');
        $this->addSql('DROP TABLE tide');
    }
}
