<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250604154517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE render_result (id INT AUTO_INCREMENT NOT NULL, element_id INT NOT NULL, name VARCHAR(64) NOT NULL, expression LONGTEXT NOT NULL, INDEX IDX_303726891F1F2A24 (element_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE render_result ADD CONSTRAINT FK_303726891F1F2A24 FOREIGN KEY (element_id) REFERENCES capture_element (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE render_result DROP FOREIGN KEY FK_303726891F1F2A24
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE render_result
        SQL);
    }
}
