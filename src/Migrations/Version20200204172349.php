<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204172349 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_285F75DD89312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, presentation LONGTEXT NOT NULL, date DATE NOT NULL, place VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, tel_fixe VARCHAR(255) DEFAULT NULL, tel_autre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, speciality VARCHAR(255) DEFAULT NULL, price INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, viewers INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, event_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_16DB4F8989312FE9 (recette_id), INDEX IDX_16DB4F8971F7E88B (event_id), INDEX IDX_16DB4F89B1E7706E (restaurant_id), INDEX IDX_16DB4F893243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, tel_fixe VARCHAR(255) DEFAULT NULL, tel_autre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, speciality VARCHAR(255) DEFAULT NULL, price INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, viewers INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD89312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8971F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8971F7E88B');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893243BB18');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD89312FE9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8989312FE9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89B1E7706E');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE restaurant');
    }
}
