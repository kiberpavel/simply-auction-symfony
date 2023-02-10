<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131163111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders_order (id VARCHAR(26) NOT NULL, buyer_id VARCHAR(26) DEFAULT NULL, status VARCHAR(255) NOT NULL, end_time_for_pay TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4833C396C755722 ON orders_order (buyer_id)');
        $this->addSql('ALTER TABLE orders_order ADD CONSTRAINT FK_B4833C396C755722 FOREIGN KEY (buyer_id) REFERENCES buyers_buyer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders_order DROP CONSTRAINT FK_B4833C396C755722');
        $this->addSql('DROP TABLE orders_order');
    }
}
