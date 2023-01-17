<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117163936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actors (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, biography LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actors_spectacles (actors_id INT NOT NULL, spectacles_id INT NOT NULL, INDEX IDX_5BC7A2B27168CF59 (actors_id), INDEX IDX_5BC7A2B2F26D12FD (spectacles_id), PRIMARY KEY(actors_id, spectacles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, news_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content LONGTEXT NOT NULL, INDEX IDX_5F9E962AA76ED395 (user_id), INDEX IDX_5F9E962AB5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emails (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message VARCHAR(255) NOT NULL, user VARCHAR(255) NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, news_id INT NOT NULL, INDEX IDX_AC6340B3A76ED395 (user_id), INDEX IDX_AC6340B3B5A459A0 (news_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content LONGTEXT NOT NULL, image_name VARCHAR(255) NOT NULL, is_published TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, important INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_1DD39950F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE newsletter (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, sub_title VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', active TINYINT(1) NOT NULL, text_position VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spectacle_comments (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, spectacle_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', content VARCHAR(1000) NOT NULL, INDEX IDX_B527BA4DA76ED395 (user_id), INDEX IDX_B527BA4DC682915D (spectacle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spectacles (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, period VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spectacles_actors (spectacles_id INT NOT NULL, actors_id INT NOT NULL, INDEX IDX_E4AA3EFBF26D12FD (spectacles_id), INDEX IDX_E4AA3EFB7168CF59 (actors_id), PRIMARY KEY(spectacles_id, actors_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, spectacle_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, purchased_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', persons INT NOT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_54469DF4A76ED395 (user_id), INDEX IDX_54469DF4C682915D (spectacle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', image_name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actors_spectacles ADD CONSTRAINT FK_5BC7A2B27168CF59 FOREIGN KEY (actors_id) REFERENCES actors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actors_spectacles ADD CONSTRAINT FK_5BC7A2B2F26D12FD FOREIGN KEY (spectacles_id) REFERENCES spectacles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3B5A459A0 FOREIGN KEY (news_id) REFERENCES news (id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_1DD39950F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE spectacle_comments ADD CONSTRAINT FK_B527BA4DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE spectacle_comments ADD CONSTRAINT FK_B527BA4DC682915D FOREIGN KEY (spectacle_id) REFERENCES spectacles (id)');
        $this->addSql('ALTER TABLE spectacles_actors ADD CONSTRAINT FK_E4AA3EFBF26D12FD FOREIGN KEY (spectacles_id) REFERENCES spectacles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spectacles_actors ADD CONSTRAINT FK_E4AA3EFB7168CF59 FOREIGN KEY (actors_id) REFERENCES actors (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4C682915D FOREIGN KEY (spectacle_id) REFERENCES spectacles (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actors_spectacles DROP FOREIGN KEY FK_5BC7A2B27168CF59');
        $this->addSql('ALTER TABLE actors_spectacles DROP FOREIGN KEY FK_5BC7A2B2F26D12FD');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AA76ED395');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AB5A459A0');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3B5A459A0');
        $this->addSql('ALTER TABLE news DROP FOREIGN KEY FK_1DD39950F675F31B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE spectacle_comments DROP FOREIGN KEY FK_B527BA4DA76ED395');
        $this->addSql('ALTER TABLE spectacle_comments DROP FOREIGN KEY FK_B527BA4DC682915D');
        $this->addSql('ALTER TABLE spectacles_actors DROP FOREIGN KEY FK_E4AA3EFBF26D12FD');
        $this->addSql('ALTER TABLE spectacles_actors DROP FOREIGN KEY FK_E4AA3EFB7168CF59');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4A76ED395');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4C682915D');
        $this->addSql('DROP TABLE actors');
        $this->addSql('DROP TABLE actors_spectacles');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE emails');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE newsletter');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE spectacle_comments');
        $this->addSql('DROP TABLE spectacles');
        $this->addSql('DROP TABLE spectacles_actors');
        $this->addSql('DROP TABLE tickets');
        $this->addSql('DROP TABLE user');
    }
}
