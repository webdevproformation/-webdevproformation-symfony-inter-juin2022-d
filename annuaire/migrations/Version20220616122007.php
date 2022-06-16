<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616122007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, titre, contenu FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER DEFAULT NULL, titre VARCHAR(200) NOT NULL, contenu CLOB NOT NULL, CONSTRAINT FK_23A0E6660BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, titre, contenu) SELECT id, titre, contenu FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6660BB6FE6 ON article (auteur_id)');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, email, contenu FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, email VARCHAR(200) NOT NULL, contenu CLOB NOT NULL, CONSTRAINT FK_67F068BC7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commentaire (id, article_id, email, contenu) SELECT id, article_id, email, contenu FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E6660BB6FE6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, titre, contenu FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, contenu CLOB NOT NULL)');
        $this->addSql('INSERT INTO article (id, titre, contenu) SELECT id, titre, contenu FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, email, contenu FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, email VARCHAR(200) NOT NULL, contenu CLOB NOT NULL)');
        $this->addSql('INSERT INTO commentaire (id, article_id, email, contenu) SELECT id, article_id, email, contenu FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
    }
}
