<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250528233200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE capture (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE capture_elements (capture_id INT NOT NULL, capture_element_id INT NOT NULL, INDEX IDX_363FCD0D6B301384 (capture_id), INDEX IDX_363FCD0DDE152EAB (capture_element_id), PRIMARY KEY(capture_id, capture_element_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE capture_element_instance (id INT AUTO_INCREMENT NOT NULL, capture_instance_id INT DEFAULT NULL, element_id INT DEFAULT NULL, respondent_email VARCHAR(255) NOT NULL, validator_email VARCHAR(255) NOT NULL, link_token VARCHAR(255) NOT NULL, link_expires_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_CB77D3AD4797E6A8 (capture_instance_id), INDEX IDX_CB77D3AD1F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE capture_instance (id INT AUTO_INCREMENT NOT NULL, capture_id INT DEFAULT NULL, INDEX IDX_30457B8E6B301384 (capture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE old_capture_element_instance (id INT AUTO_INCREMENT NOT NULL, capture_instance_id INT DEFAULT NULL, element_id INT DEFAULT NULL, respondent_email VARCHAR(255) NOT NULL, validator_email VARCHAR(255) NOT NULL, link_token VARCHAR(255) NOT NULL, link_expires_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, INDEX IDX_67D3438B4797E6A8 (capture_instance_id), INDEX IDX_67D3438B1F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE participant_assignment (id INT AUTO_INCREMENT NOT NULL, capture_instance_id INT NOT NULL, email VARCHAR(255) NOT NULL, role VARCHAR(100) NOT NULL, INDEX IDX_C05A2A44797E6A8 (capture_instance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_elements ADD CONSTRAINT FK_363FCD0D6B301384 FOREIGN KEY (capture_id) REFERENCES capture (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_elements ADD CONSTRAINT FK_363FCD0DDE152EAB FOREIGN KEY (capture_element_id) REFERENCES capture_element (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance ADD CONSTRAINT FK_CB77D3AD4797E6A8 FOREIGN KEY (capture_instance_id) REFERENCES capture_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance ADD CONSTRAINT FK_CB77D3AD1F1F2A24 FOREIGN KEY (element_id) REFERENCES capture_element (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_instance ADD CONSTRAINT FK_30457B8E6B301384 FOREIGN KEY (capture_id) REFERENCES capture (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance ADD CONSTRAINT FK_67D3438B4797E6A8 FOREIGN KEY (capture_instance_id) REFERENCES capture_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance ADD CONSTRAINT FK_67D3438B1F1F2A24 FOREIGN KEY (element_id) REFERENCES capture_element (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD CONSTRAINT FK_C05A2A44797E6A8 FOREIGN KEY (capture_instance_id) REFERENCES capture_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element ADD respondent_role_id INT DEFAULT NULL, ADD validator_role_id INT DEFAULT NULL, DROP respondent_role, DROP validator_role
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element ADD CONSTRAINT FK_33ED8BFF5D9D6CDD FOREIGN KEY (respondent_role_id) REFERENCES role (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element ADD CONSTRAINT FK_33ED8BFFB2901176 FOREIGN KEY (validator_role_id) REFERENCES role (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_33ED8BFF5D9D6CDD ON capture_element (respondent_role_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_33ED8BFFB2901176 ON capture_element (validator_role_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_elements DROP FOREIGN KEY FK_363FCD0D6B301384
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_elements DROP FOREIGN KEY FK_363FCD0DDE152EAB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance DROP FOREIGN KEY FK_CB77D3AD4797E6A8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element_instance DROP FOREIGN KEY FK_CB77D3AD1F1F2A24
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_instance DROP FOREIGN KEY FK_30457B8E6B301384
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance DROP FOREIGN KEY FK_67D3438B4797E6A8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance DROP FOREIGN KEY FK_67D3438B1F1F2A24
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment DROP FOREIGN KEY FK_C05A2A44797E6A8
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture_elements
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture_element_instance
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture_instance
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE old_capture_element_instance
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE participant_assignment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element DROP FOREIGN KEY FK_33ED8BFF5D9D6CDD
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element DROP FOREIGN KEY FK_33ED8BFFB2901176
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_33ED8BFF5D9D6CDD ON capture_element
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_33ED8BFFB2901176 ON capture_element
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_element ADD respondent_role VARCHAR(100) NOT NULL, ADD validator_role VARCHAR(100) NOT NULL, DROP respondent_role_id, DROP validator_role_id
        SQL);
    }
}
