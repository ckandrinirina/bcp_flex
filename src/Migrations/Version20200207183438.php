<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207183438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893243BB18');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8989312FE9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89B1E7706E');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8989312FE9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89B1E7706E');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893243BB18');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }
}
