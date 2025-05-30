<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530175221 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table DROP FOREIGN KEY FK_FE3BA63F2621E180
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table DROP FOREIGN KEY FK_FE3BA63F886DEE8F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE interaction_data_table
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table DROP FOREIGN KEY FK_B89643D9886DEE8F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table ADD CONSTRAINT FK_B89643D9886DEE8F FOREIGN KEY (interaction_id) REFERENCES interaction (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP FOREIGN KEY FK_378DFDA7CC2B3568
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_378DFDA7CC2B3568 ON interaction
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction DROP data_table_out_id
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE interaction_data_table (interaction_id INT NOT NULL, data_table_id INT NOT NULL, INDEX IDX_FE3BA63F886DEE8F (interaction_id), INDEX IDX_FE3BA63F2621E180 (data_table_id), PRIMARY KEY(interaction_id, data_table_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table ADD CONSTRAINT FK_FE3BA63F2621E180 FOREIGN KEY (data_table_id) REFERENCES data_table (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction_data_table ADD CONSTRAINT FK_FE3BA63F886DEE8F FOREIGN KEY (interaction_id) REFERENCES interaction (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table DROP FOREIGN KEY FK_B89643D9886DEE8F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE data_table ADD CONSTRAINT FK_B89643D9886DEE8F FOREIGN KEY (interaction_id) REFERENCES interaction (id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD data_table_out_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE interaction ADD CONSTRAINT FK_378DFDA7CC2B3568 FOREIGN KEY (data_table_out_id) REFERENCES data_table (id) ON UPDATE NO ACTION ON DELETE NO ACTION
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_378DFDA7CC2B3568 ON interaction (data_table_out_id)
        SQL);
    }
}
