<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230312211642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_playlist (formation_id INT NOT NULL, playlist_id INT NOT NULL, INDEX IDX_101046DC5200282E (formation_id), INDEX IDX_101046DC6BBD148 (playlist_id), PRIMARY KEY(formation_id, playlist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_playlist ADD CONSTRAINT FK_101046DC5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_playlist ADD CONSTRAINT FK_101046DC6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_playlist DROP FOREIGN KEY FK_101046DC5200282E');
        $this->addSql('ALTER TABLE formation_playlist DROP FOREIGN KEY FK_101046DC6BBD148');
        $this->addSql('DROP TABLE formation_playlist');
    }
}
