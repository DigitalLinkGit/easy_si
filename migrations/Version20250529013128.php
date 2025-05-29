<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529013128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance DROP FOREIGN KEY FK_67D3438B1F1F2A24
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance DROP FOREIGN KEY FK_67D3438B4797E6A8
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE old_capture_element_instance
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD role_id INT DEFAULT NULL, DROP role
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD CONSTRAINT FK_C05A2A4D60322AC FOREIGN KEY (role_id) REFERENCES role (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C05A2A4D60322AC ON participant_assignment (role_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE old_capture_element_instance (id INT AUTO_INCREMENT NOT NULL, capture_instance_id INT DEFAULT NULL, element_id INT DEFAULT NULL, respondent_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, validator_email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, link_token VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, link_expires_at DATETIME NOT NULL, status VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_67D3438B1F1F2A24 (element_id), INDEX IDX_67D3438B4797E6A8 (capture_instance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance ADD CONSTRAINT FK_67D3438B1F1F2A24 FOREIGN KEY (element_id) REFERENCES capture_element (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE old_capture_element_instance ADD CONSTRAINT FK_67D3438B4797E6A8 FOREIGN KEY (capture_instance_id) REFERENCES capture_instance (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment DROP FOREIGN KEY FK_C05A2A4D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C05A2A4D60322AC ON participant_assignment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD role VARCHAR(100) NOT NULL, DROP role_id
        SQL);
    }
}
