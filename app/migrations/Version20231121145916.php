<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121145916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classements (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, score_total INT NOT NULL, date_classement DATETIME NOT NULL, INDEX IDX_28583C73A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedbacks (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_feedback DATETIME NOT NULL, INDEX IDX_7E6C3F89A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mots (id INT AUTO_INCREMENT NOT NULL, mot VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parties (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, date_partie DATETIME NOT NULL, score_total INT NOT NULL, niveau_atteint INT NOT NULL, INDEX IDX_43631805A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, question VARCHAR(255) NOT NULL, reponse_correct VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses_utilisateurs (id INT AUTO_INCREMENT NOT NULL, partie_id INT DEFAULT NULL, question_id INT DEFAULT NULL, reponse_user VARCHAR(255) NOT NULL, est_correcte TINYINT(1) NOT NULL, points_gagnes INT NOT NULL, INDEX IDX_DF7583CFE075F7A4 (partie_id), INDEX IDX_DF7583CF1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', username VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classements ADD CONSTRAINT FK_28583C73A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedbacks ADD CONSTRAINT FK_7E6C3F89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE parties ADD CONSTRAINT FK_43631805A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponses_utilisateurs ADD CONSTRAINT FK_DF7583CFE075F7A4 FOREIGN KEY (partie_id) REFERENCES parties (id)');
        $this->addSql('ALTER TABLE reponses_utilisateurs ADD CONSTRAINT FK_DF7583CF1E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classements DROP FOREIGN KEY FK_28583C73A76ED395');
        $this->addSql('ALTER TABLE feedbacks DROP FOREIGN KEY FK_7E6C3F89A76ED395');
        $this->addSql('ALTER TABLE parties DROP FOREIGN KEY FK_43631805A76ED395');
        $this->addSql('ALTER TABLE reponses_utilisateurs DROP FOREIGN KEY FK_DF7583CFE075F7A4');
        $this->addSql('ALTER TABLE reponses_utilisateurs DROP FOREIGN KEY FK_DF7583CF1E27F6BF');
        $this->addSql('DROP TABLE classements');
        $this->addSql('DROP TABLE feedbacks');
        $this->addSql('DROP TABLE mots');
        $this->addSql('DROP TABLE parties');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE reponses_utilisateurs');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
