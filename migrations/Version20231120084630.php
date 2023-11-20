<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231120084630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raise ADD auction_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE raise ADD CONSTRAINT FK_B8669B9957B8F0DE FOREIGN KEY (auction_id) REFERENCES auction (id)');
        $this->addSql('CREATE INDEX IDX_B8669B9957B8F0DE ON raise (auction_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE raise DROP FOREIGN KEY FK_B8669B9957B8F0DE');
        $this->addSql('DROP INDEX IDX_B8669B9957B8F0DE ON raise');
        $this->addSql('ALTER TABLE raise DROP auction_id');
    }
}
