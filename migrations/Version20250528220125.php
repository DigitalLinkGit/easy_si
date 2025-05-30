<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250528220125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE capture_element (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, respondent_role VARCHAR(100) NOT NULL, validator_role VARCHAR(100) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `condition` (id INT AUTO_INCREMENT NOT NULL, next_question_instance_id INT DEFAULT NULL, question_instance_id INT NOT NULL, proposal_id INT NOT NULL, UNIQUE INDEX UNIQ_BDD688431C685A5 (next_question_instance_id), INDEX IDX_BDD68843D955AD90 (question_instance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE data_table (id INT AUTO_INCREMENT NOT NULL, interaction_id INT DEFAULT NULL, service_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_B89643D9886DEE8F (interaction_id), INDEX IDX_B89643D9ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE data_table_cell (id INT AUTO_INCREMENT NOT NULL, table_id INT NOT NULL, row_index INT NOT NULL, col_index INT NOT NULL, column_name VARCHAR(255) DEFAULT NULL, value LONGTEXT DEFAULT NULL, INDEX IDX_4E64FDF0ECFF285C (table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE element (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE flow (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, starter VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE interaction (id INT AUTO_INCREMENT NOT NULL, element_in_id INT DEFAULT NULL, element_out_id INT DEFAULT NULL, flow_id INT DEFAULT NULL, data_table_out_id INT DEFAULT NULL, service_in_id INT DEFAULT NULL, service_out_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, data_name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, logic JSON DEFAULT NULL, is_conditional TINYINT(1) NOT NULL, condition_label VARCHAR(255) DEFAULT NULL, INDEX IDX_378DFDA7D4DB0AAA (element_in_id), INDEX IDX_378DFDA78D1851EE (element_out_id), INDEX IDX_378DFDA77EB60D1B (flow_id), INDEX IDX_378DFDA7CC2B3568 (data_table_out_id), INDEX IDX_378DFDA7B98B93D4 (service_in_id), INDEX IDX_378DFDA73AC85D4C (service_out_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE interaction_data_table (interaction_id INT NOT NULL, data_table_id INT NOT NULL, INDEX IDX_FE3BA63F886DEE8F (interaction_id), INDEX IDX_FE3BA63F2621E180 (data_table_id), PRIMARY KEY(interaction_id, data_table_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE proposal (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_BFE594721E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, multiple_choice TINYINT(1) NOT NULL, INDEX IDX_B6F7494E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question_instance (id INT AUTO_INCREMENT NOT NULL, previous_question_instance_id INT DEFAULT NULL, next_question_instance_id INT DEFAULT NULL, question_id INT NOT NULL, quiz_id INT DEFAULT NULL, level INT NOT NULL, UNIQUE INDEX UNIQ_213801D2721DC847 (previous_question_instance_id), UNIQUE INDEX UNIQ_213801D21C685A5 (next_question_instance_id), INDEX IDX_213801D21E27F6BF (question_id), INDEX IDX_213801D2853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE quiz_capture (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, element_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, endpoint VARCHAR(255) DEFAULT NULL, auth_method VARCHAR(255) DEFAULT NULL, method VARCHAR(10) DEFAULT NULL, format VARCHAR(10) DEFAULT NULL, direction VARCHAR(10) DEFAULT NULL, INDEX IDX_E19D9AD21F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transformation (id INT AUTO_INCREMENT NOT NULL, source_table_id INT DEFAULT NULL, target_table_id INT DEFAULT NULL, source_key_column VARCHAR(100) DEFAULT NULL, target_key_column VARCHAR(100) DEFAULT NULL, transformation_rules LONGTEXT DEFAULT NULL, INDEX IDX_F2B21A85AFDF1E8E (source_table_id), INDEX IDX_F2B21A853654F835 (target_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transition (id INT AUTO_INCREMENT NOT NULL, from_id INT DEFAULT NULL, transformation_id INT DEFAULT NULL, type VARCHAR(20) NOT NULL, label VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, order_index INT DEFAULT NULL, INDEX IDX_F715A75A78CED90B (from_id), UNIQUE INDEX UNIQ_F715A75A14FD34D2 (transformation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE transition_choice (id INT AUTO_INCREMENT NOT NULL, transition_id INT DEFAULT NULL, target_id INT DEFAULT NULL, label VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, order_index INT DEFAULT NULL, INDEX IDX_8951C528BF1A064 (transition_id), INDEX IDX_8951C52158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tutorial (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, route VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tutorial_step (id INT AUTO_INCREMENT NOT NULL, tutorial_id INT NOT NULL, number INT NOT NULL, content VARCHAR(255) NOT NULL, dom_element VARCHAR(255) NOT NULL, INDEX IDX_3C7F797189366B7B (tutorial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` ADD CONSTRAINT FK_BDD688431C685A5 FOREIGN KEY (next_question_instance_id) REFERENCES question_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` ADD CONSTRAINT FK_BDD68843D955AD90 FOREIGN KEY (question_instance_id) REFERENCES question_instance (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table ADD CONSTRAINT FK_B89643D9886DEE8F FOREIGN KEY (interaction_id) REFERENCES interaction (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table ADD CONSTRAINT FK_B89643D9ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table_cell ADD CONSTRAINT FK_4E64FDF0ECFF285C FOREIGN KEY (table_id) REFERENCES data_table (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7D4DB0AAA FOREIGN KEY (element_in_id) REFERENCES element (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA78D1851EE FOREIGN KEY (element_out_id) REFERENCES element (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA77EB60D1B FOREIGN KEY (flow_id) REFERENCES flow (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7CC2B3568 FOREIGN KEY (data_table_out_id) REFERENCES data_table (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7B98B93D4 FOREIGN KEY (service_in_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA73AC85D4C FOREIGN KEY (service_out_id) REFERENCES service (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table ADD CONSTRAINT FK_FE3BA63F886DEE8F FOREIGN KEY (interaction_id) REFERENCES interaction (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table ADD CONSTRAINT FK_FE3BA63F2621E180 FOREIGN KEY (data_table_id) REFERENCES data_table (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proposal ADD CONSTRAINT FK_BFE594721E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question ADD CONSTRAINT FK_B6F7494E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D2721DC847 FOREIGN KEY (previous_question_instance_id) REFERENCES question_instance (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D21C685A5 FOREIGN KEY (next_question_instance_id) REFERENCES question_instance (id) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D21E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance ADD CONSTRAINT FK_213801D2853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz_capture (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_capture ADD CONSTRAINT FK_99A40B45BF396750 FOREIGN KEY (id) REFERENCES capture_element (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service ADD CONSTRAINT FK_E19D9AD21F1F2A24 FOREIGN KEY (element_id) REFERENCES element (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transformation ADD CONSTRAINT FK_F2B21A85AFDF1E8E FOREIGN KEY (source_table_id) REFERENCES data_table (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transformation ADD CONSTRAINT FK_F2B21A853654F835 FOREIGN KEY (target_table_id) REFERENCES data_table (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition ADD CONSTRAINT FK_F715A75A78CED90B FOREIGN KEY (from_id) REFERENCES interaction (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition ADD CONSTRAINT FK_F715A75A14FD34D2 FOREIGN KEY (transformation_id) REFERENCES transformation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition_choice ADD CONSTRAINT FK_8951C528BF1A064 FOREIGN KEY (transition_id) REFERENCES transition (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition_choice ADD CONSTRAINT FK_8951C52158E0B66 FOREIGN KEY (target_id) REFERENCES interaction (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tutorial_step ADD CONSTRAINT FK_3C7F797189366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` DROP FOREIGN KEY FK_BDD688431C685A5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `condition` DROP FOREIGN KEY FK_BDD68843D955AD90
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table DROP FOREIGN KEY FK_B89643D9886DEE8F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table DROP FOREIGN KEY FK_B89643D9ED5CA9E6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table_cell DROP FOREIGN KEY FK_4E64FDF0ECFF285C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA7D4DB0AAA
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA78D1851EE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA77EB60D1B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA7CC2B3568
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA7B98B93D4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA73AC85D4C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table DROP FOREIGN KEY FK_FE3BA63F886DEE8F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table DROP FOREIGN KEY FK_FE3BA63F2621E180
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proposal DROP FOREIGN KEY FK_BFE594721E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E12469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D2721DC847
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D21C685A5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D21E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance DROP FOREIGN KEY FK_213801D2853CD175
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE quiz_capture DROP FOREIGN KEY FK_99A40B45BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD21F1F2A24
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transformation DROP FOREIGN KEY FK_F2B21A85AFDF1E8E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transformation DROP FOREIGN KEY FK_F2B21A853654F835
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A78CED90B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition DROP FOREIGN KEY FK_F715A75A14FD34D2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition_choice DROP FOREIGN KEY FK_8951C528BF1A064
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition_choice DROP FOREIGN KEY FK_8951C52158E0B66
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tutorial_step DROP FOREIGN KEY FK_3C7F797189366B7B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture_element
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `condition`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE data_table
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE data_table_cell
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE element
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE flow
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE interaction
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE interaction_data_table
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE proposal
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question_instance
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE quiz_capture
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE role
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE service
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transformation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transition
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE transition_choice
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tutorial
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tutorial_step
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
