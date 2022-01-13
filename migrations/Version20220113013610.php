<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220113013610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114DE18E50B');
        $this->addSql('DROP INDEX IDX_38FA4114DE18E50B ON product_option');
        $this->addSql('ALTER TABLE product_option CHANGE product_id_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA41144584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_38FA41144584665A ON product_option (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA41144584665A');
        $this->addSql('DROP INDEX IDX_38FA41144584665A ON product_option');
        $this->addSql('ALTER TABLE product_option CHANGE product_id product_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_38FA4114DE18E50B ON product_option (product_id_id)');
    }
}
