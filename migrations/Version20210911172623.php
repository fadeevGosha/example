<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210911172623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE api_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7BA2F5EBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(100) NOT NULL, body LONGTEXT DEFAULT NULL, published_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', image VARCHAR(256) DEFAULT NULL, vote_count INT NOT NULL, keywords VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_23A0E66989D9B62 (slug), INDEX IDX_23A0E66F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_tag (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_919694F97294869C (article_id), INDEX IDX_919694F9BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment (id INT AUTO_INCREMENT NOT NULL, template_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start DATETIME NOT NULL, finish DATETIME NOT NULL, time_restriction_start DATETIME NOT NULL, time_restriction_stop DATETIME NOT NULL, is_need_confirmation TINYINT(1) NOT NULL, time_restriction_confirm_start DATETIME DEFAULT NULL, time_restriction_confirm_stop DATETIME DEFAULT NULL, INDEX IDX_F7523D705DA0FB8 (template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_question (id INT AUTO_INCREMENT NOT NULL, competence_id INT NOT NULL, text VARCHAR(255) NOT NULL, question_type VARCHAR(255) NOT NULL, INDEX IDX_CA81586815761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_question_tag (assessment_question_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8BF68C39C8583B88 (assessment_question_id), INDEX IDX_8BF68C39BAD26311 (tag_id), PRIMARY KEY(assessment_question_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_session (id INT AUTO_INCREMENT NOT NULL, evaluator_id INT NOT NULL, evaluated_id INT NOT NULL, assessment_id INT NOT NULL, start_date_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', complete_date_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_completed TINYINT(1) NOT NULL, INDEX IDX_7ABA441A43575BE2 (evaluator_id), INDEX IDX_7ABA441A7C954B00 (evaluated_id), INDEX IDX_7ABA441ADD3DD5F1 (assessment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_template (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_template_assessment_question (assessment_template_id INT NOT NULL, assessment_question_id INT NOT NULL, INDEX IDX_243BCF57D3A5C28F (assessment_template_id), INDEX IDX_243BCF57C8583B88 (assessment_question_id), PRIMARY KEY(assessment_template_id, assessment_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, author_name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_9474526C7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluated (id INT AUTO_INCREMENT NOT NULL, evaluated_id INT NOT NULL, INDEX IDX_7B30C5D47C954B00 (evaluated_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluated_assessment (evaluated_id INT NOT NULL, assessment_id INT NOT NULL, INDEX IDX_6A02DEC07C954B00 (evaluated_id), INDEX IDX_6A02DEC0DD3DD5F1 (assessment_id), PRIMARY KEY(evaluated_id, assessment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluator (id INT AUTO_INCREMENT NOT NULL, evaluator_id INT NOT NULL, INDEX IDX_750B980F43575BE2 (evaluator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluator_assessment (evaluator_id INT NOT NULL, assessment_id INT NOT NULL, INDEX IDX_B378F0FA43575BE2 (evaluator_id), INDEX IDX_B378F0FADD3DD5F1 (assessment_id), PRIMARY KEY(evaluator_id, assessment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluator_evaluated (evaluator_id INT NOT NULL, evaluated_id INT NOT NULL, INDEX IDX_55D03CB843575BE2 (evaluator_id), INDEX IDX_55D03CB87C954B00 (evaluated_id), PRIMARY KEY(evaluator_id, evaluated_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_assessment (id INT AUTO_INCREMENT NOT NULL, evaluator_id INT NOT NULL, evaluated_id INT NOT NULL, assessment_id INT NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_5035FB9C43575BE2 (evaluator_id), INDEX IDX_5035FB9C7C954B00 (evaluated_id), INDEX IDX_5035FB9CDD3DD5F1 (assessment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE api_token ADD CONSTRAINT FK_7BA2F5EBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D705DA0FB8 FOREIGN KEY (template_id) REFERENCES assessment_template (id)');
        $this->addSql('ALTER TABLE assessment_question ADD CONSTRAINT FK_CA81586815761DAB FOREIGN KEY (competence_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE assessment_question_tag ADD CONSTRAINT FK_8BF68C39C8583B88 FOREIGN KEY (assessment_question_id) REFERENCES assessment_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment_question_tag ADD CONSTRAINT FK_8BF68C39BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441A43575BE2 FOREIGN KEY (evaluator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441A7C954B00 FOREIGN KEY (evaluated_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441ADD3DD5F1 FOREIGN KEY (assessment_id) REFERENCES assessment (id)');
        $this->addSql('ALTER TABLE assessment_template_assessment_question ADD CONSTRAINT FK_243BCF57D3A5C28F FOREIGN KEY (assessment_template_id) REFERENCES assessment_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment_template_assessment_question ADD CONSTRAINT FK_243BCF57C8583B88 FOREIGN KEY (assessment_question_id) REFERENCES assessment_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE evaluated ADD CONSTRAINT FK_7B30C5D47C954B00 FOREIGN KEY (evaluated_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluated_assessment ADD CONSTRAINT FK_6A02DEC07C954B00 FOREIGN KEY (evaluated_id) REFERENCES evaluated (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluated_assessment ADD CONSTRAINT FK_6A02DEC0DD3DD5F1 FOREIGN KEY (assessment_id) REFERENCES assessment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluator ADD CONSTRAINT FK_750B980F43575BE2 FOREIGN KEY (evaluator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluator_assessment ADD CONSTRAINT FK_B378F0FA43575BE2 FOREIGN KEY (evaluator_id) REFERENCES evaluator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluator_assessment ADD CONSTRAINT FK_B378F0FADD3DD5F1 FOREIGN KEY (assessment_id) REFERENCES assessment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluator_evaluated ADD CONSTRAINT FK_55D03CB843575BE2 FOREIGN KEY (evaluator_id) REFERENCES evaluator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluator_evaluated ADD CONSTRAINT FK_55D03CB87C954B00 FOREIGN KEY (evaluated_id) REFERENCES evaluated (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_assessment ADD CONSTRAINT FK_5035FB9C43575BE2 FOREIGN KEY (evaluator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_assessment ADD CONSTRAINT FK_5035FB9C7C954B00 FOREIGN KEY (evaluated_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_assessment ADD CONSTRAINT FK_5035FB9CDD3DD5F1 FOREIGN KEY (assessment_id) REFERENCES assessment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F97294869C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE assessment_session DROP FOREIGN KEY FK_7ABA441ADD3DD5F1');
        $this->addSql('ALTER TABLE evaluated_assessment DROP FOREIGN KEY FK_6A02DEC0DD3DD5F1');
        $this->addSql('ALTER TABLE evaluator_assessment DROP FOREIGN KEY FK_B378F0FADD3DD5F1');
        $this->addSql('ALTER TABLE user_assessment DROP FOREIGN KEY FK_5035FB9CDD3DD5F1');
        $this->addSql('ALTER TABLE assessment_question_tag DROP FOREIGN KEY FK_8BF68C39C8583B88');
        $this->addSql('ALTER TABLE assessment_template_assessment_question DROP FOREIGN KEY FK_243BCF57C8583B88');
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D705DA0FB8');
        $this->addSql('ALTER TABLE assessment_template_assessment_question DROP FOREIGN KEY FK_243BCF57D3A5C28F');
        $this->addSql('ALTER TABLE evaluated_assessment DROP FOREIGN KEY FK_6A02DEC07C954B00');
        $this->addSql('ALTER TABLE evaluator_evaluated DROP FOREIGN KEY FK_55D03CB87C954B00');
        $this->addSql('ALTER TABLE evaluator_assessment DROP FOREIGN KEY FK_B378F0FA43575BE2');
        $this->addSql('ALTER TABLE evaluator_evaluated DROP FOREIGN KEY FK_55D03CB843575BE2');
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F9BAD26311');
        $this->addSql('ALTER TABLE assessment_question DROP FOREIGN KEY FK_CA81586815761DAB');
        $this->addSql('ALTER TABLE assessment_question_tag DROP FOREIGN KEY FK_8BF68C39BAD26311');
        $this->addSql('ALTER TABLE api_token DROP FOREIGN KEY FK_7BA2F5EBA76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66F675F31B');
        $this->addSql('ALTER TABLE assessment_session DROP FOREIGN KEY FK_7ABA441A43575BE2');
        $this->addSql('ALTER TABLE assessment_session DROP FOREIGN KEY FK_7ABA441A7C954B00');
        $this->addSql('ALTER TABLE evaluated DROP FOREIGN KEY FK_7B30C5D47C954B00');
        $this->addSql('ALTER TABLE evaluator DROP FOREIGN KEY FK_750B980F43575BE2');
        $this->addSql('ALTER TABLE user_assessment DROP FOREIGN KEY FK_5035FB9C43575BE2');
        $this->addSql('ALTER TABLE user_assessment DROP FOREIGN KEY FK_5035FB9C7C954B00');
        $this->addSql('DROP TABLE api_token');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('DROP TABLE assessment');
        $this->addSql('DROP TABLE assessment_question');
        $this->addSql('DROP TABLE assessment_question_tag');
        $this->addSql('DROP TABLE assessment_session');
        $this->addSql('DROP TABLE assessment_template');
        $this->addSql('DROP TABLE assessment_template_assessment_question');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE evaluated');
        $this->addSql('DROP TABLE evaluated_assessment');
        $this->addSql('DROP TABLE evaluator');
        $this->addSql('DROP TABLE evaluator_assessment');
        $this->addSql('DROP TABLE evaluator_evaluated');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_assessment');
    }
}
