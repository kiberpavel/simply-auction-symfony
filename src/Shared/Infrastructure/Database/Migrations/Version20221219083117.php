<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219083117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lots_lot (id VARCHAR(26) NOT NULL, user_id VARCHAR(26) DEFAULT NULL, status VARCHAR(255) NOT NULL, short_name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D6F76CA4A76ED395 ON lots_lot (user_id)');
        $this->addSql('ALTER TABLE lots_lot ADD CONSTRAINT FK_D6F76CA4A76ED395 FOREIGN KEY (user_id) REFERENCES users_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lots_lot DROP CONSTRAINT FK_D6F76CA4A76ED395');
        $this->addSql('DROP TABLE lots_lot');
    }
}
