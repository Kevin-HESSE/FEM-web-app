<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230802083638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE video_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, category_id INT NOT NULL, rating_id INT NOT NULL, title TEXT NOT NULL, slug TEXT NOT NULL, release_at DATE NOT NULL, is_bookmarked BOOLEAN NOT NULL, is_trending BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C12469DE2 ON video (category_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CA32EFC6 ON video (rating_id)');
        $this->addSql('COMMENT ON COLUMN video.release_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CA32EFC6 FOREIGN KEY (rating_id) REFERENCES rating (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE video_id_seq CASCADE');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2C12469DE2');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2CA32EFC6');
        $this->addSql('DROP TABLE video');
    }
}
