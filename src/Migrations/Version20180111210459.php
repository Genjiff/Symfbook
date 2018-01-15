<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Drop id as primary key and add user1 and user2 as composite key
 */
class Version20180111210459 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friendship MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE friendship DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE friendship DROP id');
        $this->addSql('ALTER TABLE friendship ADD PRIMARY KEY (user1, user2)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friendship DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE friendship ADD id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE friendship ADD PRIMARY KEY (id)');
    }
}
