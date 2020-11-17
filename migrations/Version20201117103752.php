<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117103752 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD profils_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B9881AFB FOREIGN KEY (profils_id) REFERENCES profils (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9B9881AFB ON users (profils_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B9881AFB');
        $this->addSql('DROP INDEX IDX_1483A5E9B9881AFB ON users');
        $this->addSql('ALTER TABLE users DROP profils_id');
    }
}
