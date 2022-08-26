<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824084024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, gender VARCHAR(1) DEFAULT \'\' NOT NULL, country INT DEFAULT 0, age INT DEFAULT 0 NOT NULL, books_count INT DEFAULT 0, notes VARCHAR(255) DEFAULT \'0\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE book_author_items');
        $this->addSql('DROP TABLE authors');
        $this->addSql('ALTER TABLE book ADD author_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_author_items (id INT AUTO_INCREMENT NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, book_id INT DEFAULT NULL, author_id INT DEFAULT NULL, INDEX book_id (book_id), INDEX author_id (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE authors (id INT AUTO_INCREMENT NOT NULL, created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, first_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, last_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE author');
        $this->addSql('ALTER TABLE book DROP author_id');
    }
}
