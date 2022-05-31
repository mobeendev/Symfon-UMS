<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531144513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_BDAFD8C8F92F3E70 ON author');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDAFD8C8F92F3E70 ON author (country_id)');
        $this->addSql('ALTER TABLE book ADD is_booked SMALLINT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_BDAFD8C8F92F3E70 ON author');
        $this->addSql('CREATE INDEX UNIQ_BDAFD8C8F92F3E70 ON author (country_id)');
        $this->addSql('ALTER TABLE book DROP is_booked');
    }
}
