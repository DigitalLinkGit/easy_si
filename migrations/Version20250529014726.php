<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250529014726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE capture_role (capture_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_E555EB5D6B301384 (capture_id), INDEX IDX_E555EB5DD60322AC (role_id), PRIMARY KEY(capture_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_role ADD CONSTRAINT FK_E555EB5D6B301384 FOREIGN KEY (capture_id) REFERENCES capture (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_role ADD CONSTRAINT FK_E555EB5DD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_role DROP FOREIGN KEY FK_E555EB5D6B301384
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE capture_role DROP FOREIGN KEY FK_E555EB5DD60322AC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE capture_role
        SQL);
    }
}
