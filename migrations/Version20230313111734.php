<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230313111734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, pwd VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_page (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, position_page VARCHAR(255) NOT NULL, text_content LONGTEXT NOT NULL, INDEX IDX_D9685BE5C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, name_page VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content_page ADD CONSTRAINT FK_D9685BE5C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE file ADD original_name VARCHAR(255) NOT NULL, ADD file_name VARCHAR(255) NOT NULL, DROP name_origine, DROP name_file');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_page DROP FOREIGN KEY FK_D9685BE5C4663E4');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE content_page');
        $this->addSql('DROP TABLE page');
        $this->addSql('ALTER TABLE file ADD name_origine VARCHAR(255) NOT NULL, ADD name_file VARCHAR(255) NOT NULL, DROP original_name, DROP file_name');
    }
}
