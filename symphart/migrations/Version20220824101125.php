<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824101125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD title VARCHAR(255) NOT NULL, DROP author_id, CHANGE created created DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE name isbn VARCHAR(255) NOT NULL, CHANGE book_description notes LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD name VARCHAR(255) NOT NULL, ADD author_id INT NOT NULL, DROP isbn, DROP title, CHANGE created created DATETIME DEFAULT NULL, CHANGE notes book_description LONGTEXT DEFAULT NULL');
    }
}
