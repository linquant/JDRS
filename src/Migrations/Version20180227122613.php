<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180227122613 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE roleplay ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE roleplay ADD CONSTRAINT FK_A7804332A76ED395 FOREIGN KEY (user_id) REFERENCES app_users (id)');
        $this->addSql('CREATE INDEX IDX_A7804332A76ED395 ON roleplay (user_id)');
        $this->addSql('ALTER TABLE app_users DROP FOREIGN KEY FK_C250282477426B8F');
        $this->addSql('DROP INDEX IDX_C250282477426B8F ON app_users');
        $this->addSql('ALTER TABLE app_users DROP roleplay_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_users ADD roleplay_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE app_users ADD CONSTRAINT FK_C250282477426B8F FOREIGN KEY (roleplay_id) REFERENCES roleplay (id)');
        $this->addSql('CREATE INDEX IDX_C250282477426B8F ON app_users (roleplay_id)');
        $this->addSql('ALTER TABLE roleplay DROP FOREIGN KEY FK_A7804332A76ED395');
        $this->addSql('DROP INDEX IDX_A7804332A76ED395 ON roleplay');
        $this->addSql('ALTER TABLE roleplay DROP user_id');
    }
}
