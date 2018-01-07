<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Set nullable columns on user table
 */
class Version20180107011828 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE about_me about_me VARCHAR(2000) DEFAULT NULL, CHANGE education education VARCHAR(200) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE location location VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE about_me about_me VARCHAR(2000) NOT NULL COLLATE utf8_unicode_ci, CHANGE education education VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, CHANGE age age INT NOT NULL, CHANGE location location VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
    }
}
