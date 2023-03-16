<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316154429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE harbor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, department VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tide (id INT AUTO_INCREMENT NOT NULL, harbor_id INT DEFAULT NULL, high_height DOUBLE PRECISION NOT NULL, low_height DOUBLE PRECISION NOT NULL, high_hour DATETIME NOT NULL, low_hour DATETIME NOT NULL, coefficient DOUBLE PRECISION NOT NULL, INDEX IDX_BE56230C606C6CCD (harbor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tide ADD CONSTRAINT FK_BE56230C606C6CCD FOREIGN KEY (harbor_id) REFERENCES harbor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tide DROP FOREIGN KEY FK_BE56230C606C6CCD');
        $this->addSql('DROP TABLE harbor');
        $this->addSql('DROP TABLE tide');
    }
}
