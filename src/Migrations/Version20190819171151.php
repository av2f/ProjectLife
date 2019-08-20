<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190819171151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(50) NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('CREATE TABLE interest_type (id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('CREATE TABLE situation (id INT AUTO_INCREMENT NOT NULL,
            type VARCHAR(50) NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('CREATE TABLE subscrib_type (id INT AUTO_INCREMENT NOT NULL,
            type VARCHAR(50) NOT NULL,
            duration SMALLINT NOT NULL,
            duration_type VARCHAR(1) NOT NULL,
            price DOUBLE PRECISION NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL,
            gender_id INT NOT NULL,
            situation_id INT DEFAULT NULL,
            pseudo VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(100) DEFAULT NULL,
            last_name VARCHAR(100) DEFAULT NULL,
            birthday_date DATE NOT NULL,
            avatar VARCHAR(255) NOT NULL,
            profession VARCHAR(255) DEFAULT NULL,
            description LONGTEXT DEFAULT NULL,
            subscribed TINYINT(1) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME DEFAULT NULL,
            INDEX IDX_8D93D649708A0E0 (gender_id), INDEX IDX_8D93D6493408E8AF (situation_id),
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493408E8AF FOREIGN KEY (situation_id) REFERENCES situation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493408E8AF');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE interest_type');
        $this->addSql('DROP TABLE situation');
        $this->addSql('DROP TABLE subscrib_type');
        $this->addSql('DROP TABLE user');
    }
}
