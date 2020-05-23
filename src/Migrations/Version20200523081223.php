<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200523081223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE etablissement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, fixe VARCHAR(255) DEFAULT NULL, autre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, specialite VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, note INT DEFAULT NULL, etablissement_type VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, viewers INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, presentation LONGTEXT NOT NULL, date DATE NOT NULL, place VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, tel_fixe VARCHAR(255) DEFAULT NULL, tel_autre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, speciality VARCHAR(255) DEFAULT NULL, price INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, viewers INT DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3535ED96C6E55B5 (nom), UNIQUE INDEX UNIQ_3535ED95CECC7BE (adress), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, descriptions VARCHAR(255) DEFAULT NULL, INDEX IDX_AF86866FFF631228 (etablissement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, etablissement_id INT DEFAULT NULL, offre_id INT DEFAULT NULL, uri VARCHAR(255) DEFAULT NULL, photo_type VARCHAR(255) DEFAULT NULL, INDEX IDX_14B78418FF631228 (etablissement_id), INDEX IDX_14B784184CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, event_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, hotel_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_16DB4F8989312FE9 (recette_id), INDEX IDX_16DB4F8971F7E88B (event_id), INDEX IDX_16DB4F89B1E7706E (restaurant_id), INDEX IDX_16DB4F893243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recette (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, etapes LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, tel_fixe VARCHAR(255) DEFAULT NULL, tel_autre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, speciality VARCHAR(255) DEFAULT NULL, price INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, viewers INT DEFAULT NULL, latitude VARCHAR(255) DEFAULT NULL, longitude VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FFF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8989312FE9 FOREIGN KEY (recette_id) REFERENCES recette (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F893243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FFF631228');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418FF631228');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8971F7E88B');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F893243BB18');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184CC8505A');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8989312FE9');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89B1E7706E');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE recette');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE user');
    }
}
