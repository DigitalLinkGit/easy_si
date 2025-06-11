<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611130621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE answer CHANGE numeric_value numeric_value DOUBLE PRECISION DEFAULT NULL, CHANGE date_value date_value DATETIME DEFAULT NULL, CHANGE choice_values choice_values JSON DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture CHANGE render_title render_title VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE render_title render_title VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE category CHANGE description description VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table CHANGE description description VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table_cell CHANGE column_name column_name VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE element CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE logo logo VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE form_field CHANGE options options JSON DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction CHANGE logic logic JSON DEFAULT NULL, CHANGE condition_label condition_label VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_role CHANGE description description VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance CHANGE render_title_level render_title_level VARCHAR(10) DEFAULT NULL, CHANGE render_title render_title VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service CHANGE endpoint endpoint VARCHAR(255) DEFAULT NULL, CHANGE auth_method auth_method VARCHAR(255) DEFAULT NULL, CHANGE method method VARCHAR(10) DEFAULT NULL, CHANGE format format VARCHAR(10) DEFAULT NULL, CHANGE direction direction VARCHAR(10) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transformation CHANGE source_key_column source_key_column VARCHAR(100) DEFAULT NULL, CHANGE target_key_column target_key_column VARCHAR(100) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition CHANGE label label VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE answer CHANGE numeric_value numeric_value DOUBLE PRECISION DEFAULT 'NULL', CHANGE date_value date_value DATETIME DEFAULT 'NULL', CHANGE choice_values choice_values LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture CHANGE render_title render_title VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element CHANGE description description VARCHAR(255) DEFAULT 'NULL', CHANGE render_title render_title VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE category CHANGE description description VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table CHANGE description description VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table_cell CHANGE column_name column_name VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE element CHANGE type type VARCHAR(255) DEFAULT 'NULL', CHANGE logo logo VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE form_field CHANGE options options LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction CHANGE logic logic LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE condition_label condition_label VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT 'NULL' COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_role CHANGE description description VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE question_instance CHANGE render_title_level render_title_level VARCHAR(10) DEFAULT 'NULL', CHANGE render_title render_title VARCHAR(255) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE service CHANGE endpoint endpoint VARCHAR(255) DEFAULT 'NULL', CHANGE auth_method auth_method VARCHAR(255) DEFAULT 'NULL', CHANGE method method VARCHAR(10) DEFAULT 'NULL', CHANGE format format VARCHAR(10) DEFAULT 'NULL', CHANGE direction direction VARCHAR(10) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transformation CHANGE source_key_column source_key_column VARCHAR(100) DEFAULT 'NULL', CHANGE target_key_column target_key_column VARCHAR(100) DEFAULT 'NULL'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transition CHANGE label label VARCHAR(255) DEFAULT 'NULL'
        SQL);
    }
}
