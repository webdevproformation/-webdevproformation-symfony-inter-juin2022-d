<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617144358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E66BCF5E72D');
        $this->addSql('DROP INDEX IDX_23A0E6660BB6FE6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, auteur_id, categorie_id, titre, contenu FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER DEFAULT NULL, categorie_id INTEGER DEFAULT NULL, titre VARCHAR(200) NOT NULL, contenu CLOB NOT NULL, CONSTRAINT FK_23A0E6660BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO article (id, auteur_id, categorie_id, titre, contenu) SELECT id, auteur_id, categorie_id, titre, contenu FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E66BCF5E72D ON article (categorie_id)');
        $this->addSql('CREATE INDEX IDX_23A0E6660BB6FE6 ON article (auteur_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auteur AS SELECT id, nom, role, actif FROM auteur');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('CREATE TABLE auteur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, image_id INTEGER DEFAULT NULL, nom VARCHAR(30) NOT NULL, role VARCHAR(10) NOT NULL, actif BOOLEAN NOT NULL, CONSTRAINT FK_55AB1403DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO auteur (id, nom, role, actif) SELECT id, nom, role, actif FROM __temp__auteur');
        $this->addSql('DROP TABLE __temp__auteur');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55AB1403DA5256D ON auteur (image_id)');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, email, contenu FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, email VARCHAR(200) NOT NULL, contenu CLOB NOT NULL, CONSTRAINT FK_67F068BC7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commentaire (id, article_id, email, contenu) SELECT id, article_id, email, contenu FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
        $this->addSql('DROP INDEX UNIQ_C53D045F60BB6FE6');
        $this->addSql('DROP INDEX UNIQ_C53D045F7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, article_id, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL, CONSTRAINT FK_C53D045F7294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO image (id, article_id, url) SELECT id, article_id, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F7294869C ON image (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_23A0E6660BB6FE6');
        $this->addSql('DROP INDEX IDX_23A0E66BCF5E72D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, auteur_id, categorie_id, titre, contenu FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, auteur_id INTEGER DEFAULT NULL, categorie_id INTEGER DEFAULT NULL, titre VARCHAR(200) NOT NULL, contenu CLOB NOT NULL)');
        $this->addSql('INSERT INTO article (id, auteur_id, categorie_id, titre, contenu) SELECT id, auteur_id, categorie_id, titre, contenu FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('CREATE INDEX IDX_23A0E6660BB6FE6 ON article (auteur_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66BCF5E72D ON article (categorie_id)');
        $this->addSql('DROP INDEX UNIQ_55AB1403DA5256D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auteur AS SELECT id, nom, role, actif FROM auteur');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('CREATE TABLE auteur (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, role VARCHAR(10) NOT NULL, actif BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO auteur (id, nom, role, actif) SELECT id, nom, role, actif FROM __temp__auteur');
        $this->addSql('DROP TABLE __temp__auteur');
        $this->addSql('DROP INDEX IDX_67F068BC7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentaire AS SELECT id, article_id, email, contenu FROM commentaire');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, email VARCHAR(200) NOT NULL, contenu CLOB NOT NULL)');
        $this->addSql('INSERT INTO commentaire (id, article_id, email, contenu) SELECT id, article_id, email, contenu FROM __temp__commentaire');
        $this->addSql('DROP TABLE __temp__commentaire');
        $this->addSql('CREATE INDEX IDX_67F068BC7294869C ON commentaire (article_id)');
        $this->addSql('DROP INDEX UNIQ_C53D045F7294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__image AS SELECT id, article_id, url FROM image');
        $this->addSql('DROP TABLE image');
        $this->addSql('CREATE TABLE image (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, article_id INTEGER DEFAULT NULL, url VARCHAR(255) NOT NULL, auteur_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO image (id, article_id, url) SELECT id, article_id, url FROM __temp__image');
        $this->addSql('DROP TABLE __temp__image');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F7294869C ON image (article_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F60BB6FE6 ON image (auteur_id)');
    }
}
