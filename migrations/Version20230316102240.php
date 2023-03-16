<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316102240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, harbor_id INT NOT NULL, morning_id INT DEFAULT NULL, afternoon_id INT DEFAULT NULL, INDEX IDX_E5A02990606C6CCD (harbor_id), UNIQUE INDEX UNIQ_E5A0299047BD4CB0 (morning_id), UNIQUE INDEX UNIQ_E5A02990CD03B2E (afternoon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harbor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tide (id INT AUTO_INCREMENT NOT NULL, high_height DOUBLE PRECISION NOT NULL, low_height DOUBLE PRECISION NOT NULL, high_hour DATETIME NOT NULL, low_hour DATETIME NOT NULL, coefficient DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990606C6CCD FOREIGN KEY (harbor_id) REFERENCES harbor (id)');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A0299047BD4CB0 FOREIGN KEY (morning_id) REFERENCES tide (id)');
        $this->addSql('ALTER TABLE day ADD CONSTRAINT FK_E5A02990CD03B2E FOREIGN KEY (afternoon_id) REFERENCES tide (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A02990606C6CCD');
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A0299047BD4CB0');
        $this->addSql('ALTER TABLE day DROP FOREIGN KEY FK_E5A02990CD03B2E');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE harbor');
        $this->addSql('DROP TABLE tide');
    }
}
