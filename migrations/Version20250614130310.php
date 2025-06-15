<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250614130310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, first_name VARCHAR(100) DEFAULT NULL, last_name VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment DROP FOREIGN KEY FK_C05A2A44797E6A8
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C05A2A44797E6A8 ON participant_assignment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD internal_user_id INT DEFAULT NULL, ADD external_last_name VARCHAR(255) DEFAULT NULL, ADD external_first_name VARCHAR(255) DEFAULT NULL, ADD external_email VARCHAR(255) DEFAULT NULL, ADD external_function VARCHAR(255) DEFAULT NULL, DROP email, CHANGE role_id role_id INT NOT NULL, CHANGE capture_instance_id project_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD CONSTRAINT FK_C05A2A4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD CONSTRAINT FK_C05A2A4BF7692A3 FOREIGN KEY (internal_user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C05A2A4166D1F9C ON participant_assignment (project_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C05A2A4BF7692A3 ON participant_assignment (internal_user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment DROP FOREIGN KEY FK_C05A2A4BF7692A3
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment DROP FOREIGN KEY FK_C05A2A4166D1F9C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C05A2A4166D1F9C ON participant_assignment
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_C05A2A4BF7692A3 ON participant_assignment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD email VARCHAR(255) NOT NULL, DROP internal_user_id, DROP external_last_name, DROP external_first_name, DROP external_email, DROP external_function, CHANGE role_id role_id INT DEFAULT NULL, CHANGE project_id capture_instance_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE participant_assignment ADD CONSTRAINT FK_C05A2A44797E6A8 FOREIGN KEY (capture_instance_id) REFERENCES capture_instance (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_C05A2A44797E6A8 ON participant_assignment (capture_instance_id)
        SQL);
    }
}
