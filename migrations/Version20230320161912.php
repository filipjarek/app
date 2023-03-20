<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320161912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE name name VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE grade ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE name name VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE firstname firstname VARCHAR(50) NOT NULL, CHANGE lastname lastname VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE subject ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE name name VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE teacher_task ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE username username VARCHAR(50) NOT NULL, CHANGE firstname firstname VARCHAR(50) NOT NULL, CHANGE lastname lastname VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classroom DROP created_at, DROP updated_at, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE grade DROP created_at, DROP updated_at, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE student DROP created_at, DROP updated_at, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE subject DROP created_at, DROP updated_at, CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE task DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE teacher_task DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at, CHANGE username username VARCHAR(180) NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL, CHANGE lastname lastname VARCHAR(255) NOT NULL');
    }
}
