<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210911173316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assessment (id INT AUTO_INCREMENT NOT NULL, template_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, start DATETIME NOT NULL, finish DATETIME NOT NULL, time_restriction_start DATETIME NOT NULL, time_restriction_stop DATETIME NOT NULL, is_need_confirmation TINYINT(1) NOT NULL, time_restriction_confirm_start DATETIME DEFAULT NULL, time_restriction_confirm_stop DATETIME DEFAULT NULL, INDEX IDX_F7523D705DA0FB8 (template_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_session (id INT AUTO_INCREMENT NOT NULL, evaluator_id INT NOT NULL, evaluated_id INT NOT NULL, assessment_id INT NOT NULL, start_date_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', complete_date_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_completed TINYINT(1) NOT NULL, INDEX IDX_7ABA441A43575BE2 (evaluator_id), INDEX IDX_7ABA441A7C954B00 (evaluated_id), INDEX IDX_7ABA441ADD3DD5F1 (assessment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE 
         
         (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, question INT NOT NULL, answer_date_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_answered TINYINT(1) NOT NULL, INDEX IDX_22B2369F613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_template (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assessment_template_assessment_question (assessment_template_id INT NOT NULL, assessment_question_id INT NOT NULL, INDEX IDX_243BCF57D3A5C28F (assessment_template_id), INDEX IDX_243BCF57C8583B88 (assessment_question_id), PRIMARY KEY(assessment_template_id, assessment_question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluated (id INT AUTO_INCREMENT NOT NULL, evaluated_id INT NOT NULL, INDEX IDX_7B30C5D47C954B00 (evaluated_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluated_assessment (evaluated_id INT NOT NULL, assessment_id INT NOT NULL, INDEX IDX_6A02DEC07C954B00 (evaluated_id), INDEX IDX_6A02DEC0DD3DD5F1 (assessment_id), PRIMARY KEY(evaluated_id, assessment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluator (id INT AUTO_INCREMENT NOT NULL, evaluator_id INT NOT NULL, INDEX IDX_750B980F43575BE2 (evaluator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluator_assessment (evaluator_id INT NOT NULL, assessment_id INT NOT NULL, INDEX IDX_B378F0FA43575BE2 (evaluator_id), INDEX IDX_B378F0FADD3DD5F1 (assessment_id), PRIMARY KEY(evaluator_id, assessment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluator_evaluated (evaluator_id INT NOT NULL, evaluated_id INT NOT NULL, INDEX IDX_55D03CB843575BE2 (evaluator_id), INDEX IDX_55D03CB87C954B00 (evaluated_id), PRIMARY KEY(evaluator_id, evaluated_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_assessment (id INT AUTO_INCREMENT NOT NULL, evaluator_id INT NOT NULL, evaluated_id INT NOT NULL, assessment_id INT NOT NULL, approved TINYINT(1) NOT NULL, INDEX IDX_5035FB9C43575BE2 (evaluator_id), INDEX IDX_5035FB9C7C954B00 (evaluated_id), INDEX IDX_5035FB9CDD3DD5F1 (assessment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assessment ADD CONSTRAINT FK_F7523D705DA0FB8 FOREIGN KEY (template_id) REFERENCES assessment_template (id)');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441A43575BE2 FOREIGN KEY (evaluator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441A7C954B00 FOREIGN KEY (evaluated_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE assessment_session ADD CONSTRAINT FK_7ABA441ADD3DD5F1 FOREIGN KEY (assessment_id) REFERENCES assessment (id)');
        $this->addSql('ALTER TABLE assessment_session_question ADD CONSTRAINT FK_22B2369F613FECDF FOREIGN KEY (session_id) REFERENCES assessment_session (id)');
        $this->addSql('ALTER TABLE assessment_template_assessment_question ADD CONSTRAINT FK_243BCF57D3A5C28F FOREIGN KEY (assessment_template_id) REFERENCES assessment_template (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assessment_template_assessment_question ADD CONSTRAINT FK_243BCF57C8583B88 FOREIGN KEY (assessment_question_id) REFERENCES assessment_question (id) ON DELETE CASCADE');
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
        $this->addSql('ALTER TABLE assessment_session DROP FOREIGN KEY FK_7ABA441ADD3DD5F1');
        $this->addSql('ALTER TABLE evaluated_assessment DROP FOREIGN KEY FK_6A02DEC0DD3DD5F1');
        $this->addSql('ALTER TABLE evaluator_assessment DROP FOREIGN KEY FK_B378F0FADD3DD5F1');
        $this->addSql('ALTER TABLE user_assessment DROP FOREIGN KEY FK_5035FB9CDD3DD5F1');
        $this->addSql('ALTER TABLE assessment_session_question DROP FOREIGN KEY FK_22B2369F613FECDF');
        $this->addSql('ALTER TABLE assessment DROP FOREIGN KEY FK_F7523D705DA0FB8');
        $this->addSql('ALTER TABLE assessment_template_assessment_question DROP FOREIGN KEY FK_243BCF57D3A5C28F');
        $this->addSql('ALTER TABLE evaluated_assessment DROP FOREIGN KEY FK_6A02DEC07C954B00');
        $this->addSql('ALTER TABLE evaluator_evaluated DROP FOREIGN KEY FK_55D03CB87C954B00');
        $this->addSql('ALTER TABLE evaluator_assessment DROP FOREIGN KEY FK_B378F0FA43575BE2');
        $this->addSql('ALTER TABLE evaluator_evaluated DROP FOREIGN KEY FK_55D03CB843575BE2');
        $this->addSql('DROP TABLE assessment');
        $this->addSql('DROP TABLE assessment_session');
        $this->addSql('DROP TABLE assessment_session_question');
        $this->addSql('DROP TABLE assessment_template');
        $this->addSql('DROP TABLE assessment_template_assessment_question');
        $this->addSql('DROP TABLE evaluated');
        $this->addSql('DROP TABLE evaluated_assessment');
        $this->addSql('DROP TABLE evaluator');
        $this->addSql('DROP TABLE evaluator_assessment');
        $this->addSql('DROP TABLE evaluator_evaluated');
        $this->addSql('DROP TABLE user_assessment');
    }
}
