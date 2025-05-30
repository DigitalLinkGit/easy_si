<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530175708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table DROP FOREIGN KEY FK_B89643D9886DEE8F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_B89643D9886DEE8F ON data_table
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table DROP interaction_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table ADD interaction_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table ADD CONSTRAINT FK_B89643D9886DEE8F FOREIGN KEY (interaction_id) REFERENCES interaction (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_B89643D9886DEE8F ON data_table (interaction_id)
        SQL);
    }
}
