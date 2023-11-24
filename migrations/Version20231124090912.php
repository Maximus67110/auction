<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124090912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auction_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, locale VARCHAR(5) NOT NULL, INDEX IDX_EBCD5BF32C2AC5D3 (translatable_id), UNIQUE INDEX auction_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auction_translation ADD CONSTRAINT FK_EBCD5BF32C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES auction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE auction DROP title, DROP description');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auction_translation DROP FOREIGN KEY FK_EBCD5BF32C2AC5D3');
        $this->addSql('DROP TABLE auction_translation');
        $this->addSql('ALTER TABLE auction ADD title VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL');
    }
}
