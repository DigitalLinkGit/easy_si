<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614194510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE form_capture_response (id INT AUTO_INCREMENT NOT NULL, `values` JSON NOT NULL COMMENT '(DC2Type:json)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_capture_response (id INT AUTO_INCREMENT NOT NULL, answers JSON NOT NULL COMMENT '(DC2Type:json)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25D955AD90
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance DROP FOREIGN KEY FK_CB77D3AD4797E6A8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance DROP FOREIGN KEY FK_CB77D3AD1F1F2A24
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` DROP FOREIGN KEY FK_BDD688431C685A5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` DROP FOREIGN KEY FK_BDD68843D955AD90
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D2721DC847
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D21C685A5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D2853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D21E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE answer
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture_element_instance
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `condition`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question_instance
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_instance_id INT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, text_value LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, numeric_value DOUBLE PRECISION DEFAULT NULL, date_value DATETIME DEFAULT NULL, bool_value TINYINT(1) DEFAULT NULL, choice_values JSON DEFAULT NULL COMMENT '(DC2Type:json)', INDEX IDX_DADD4A25D955AD90 (question_instance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE capture_element_instance (id INT AUTO_INCREMENT NOT NULL, capture_instance_id INT DEFAULT NULL, element_id INT DEFAULT NULL, respondent_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, validator_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, link_token VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, link_expires_at DATETIME NOT NULL, status VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CB77D3AD4797E6A8 (capture_instance_id), INDEX IDX_CB77D3AD1F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `condition` (id INT AUTO_INCREMENT NOT NULL, next_question_instance_id INT DEFAULT NULL, question_instance_id INT NOT NULL, proposal_id INT NOT NULL, UNIQUE INDEX UNIQ_BDD688431C685A5 (next_question_instance_id), INDEX IDX_BDD68843D955AD90 (question_instance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question_instance (id INT AUTO_INCREMENT NOT NULL, previous_question_instance_id INT DEFAULT NULL, next_question_instance_id INT DEFAULT NULL, question_id INT NOT NULL, quiz_id INT DEFAULT NULL, level INT NOT NULL, render_template LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, render_title_level VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, render_title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_213801D21C685A5 (next_question_instance_id), INDEX IDX_213801D21E27F6BF (question_id), INDEX IDX_213801D2853CD175 (quiz_id), UNIQUE INDEX UNIQ_213801D2721DC847 (previous_question_instance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25D955AD90 FOREIGN KEY (question_instance_id) REFERENCES question_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance ADD CONSTRAINT FK_CB77D3AD4797E6A8 FOREIGN KEY (capture_instance_id) REFERENCES capture_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance ADD CONSTRAINT FK_CB77D3AD1F1F2A24 FOREIGN KEY (element_id) REFERENCES capture_element (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` ADD CONSTRAINT FK_BDD688431C685A5 FOREIGN KEY (next_question_instance_id) REFERENCES question_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` ADD CONSTRAINT FK_BDD68843D955AD90 FOREIGN KEY (question_instance_id) REFERENCES question_instance (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D2721DC847 FOREIGN KEY (previous_question_instance_id) REFERENCES question_instance (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D21C685A5 FOREIGN KEY (next_question_instance_id) REFERENCES question_instance (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D2853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz_capture (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D21E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE form_capture_response
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_capture_response
        SQL);
    }
}
