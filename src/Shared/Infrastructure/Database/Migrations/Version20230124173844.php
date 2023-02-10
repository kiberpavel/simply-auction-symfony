<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124173844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE buyers_buyer (id VARCHAR(26) NOT NULL, lot_id VARCHAR(26) DEFAULT NULL, user_id VARCHAR(26) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A0FEEE27A8CBA5F7 ON buyers_buyer (lot_id)');
        $this->addSql('CREATE INDEX IDX_A0FEEE27A76ED395 ON buyers_buyer (user_id)');
        $this->addSql('ALTER TABLE buyers_buyer ADD CONSTRAINT FK_A0FEEE27A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES lots_lot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE buyers_buyer ADD CONSTRAINT FK_A0FEEE27A76ED395 FOREIGN KEY (user_id) REFERENCES users_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE buyers_buyer DROP CONSTRAINT FK_A0FEEE27A8CBA5F7');
        $this->addSql('ALTER TABLE buyers_buyer DROP CONSTRAINT FK_A0FEEE27A76ED395');
        $this->addSql('DROP TABLE buyers_buyer');
    }
}
