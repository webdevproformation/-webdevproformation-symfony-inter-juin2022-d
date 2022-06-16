<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613113915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, titre, contenu, publie, dt_creation FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) DEFAULT NULL, contenu CLOB NOT NULL, publie BOOLEAN NOT NULL, dt_creation DATETIME NOT NULL)');
        $this->addSql('INSERT INTO article (id, titre, contenu, publie, dt_creation) SELECT id, titre, contenu, publie, dt_creation FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, titre, contenu, publie, dt_creation FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, contenu CLOB NOT NULL, publie BOOLEAN NOT NULL, dt_creation DATETIME NOT NULL)');
        $this->addSql('INSERT INTO article (id, titre, contenu, publie, dt_creation) SELECT id, titre, contenu, publie, dt_creation FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
    }
}
