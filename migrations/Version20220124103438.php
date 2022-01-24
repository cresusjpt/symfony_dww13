<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220124103438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', state TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, detail_produit_id INT NOT NULL, detail_commande_id INT NOT NULL, qte INT NOT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_2E067F93B42ECE2D (detail_produit_id), INDEX IDX_2E067F93EDE14305 (detail_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, paid_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', state TINYINT(1) NOT NULL, INDEX IDX_6D28840DBCABAE0 (paid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, appartenir_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, size VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, qte_stock INT NOT NULL, INDEX IDX_D34A04ADE977E148 (appartenir_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93B42ECE2D FOREIGN KEY (detail_produit_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F93EDE14305 FOREIGN KEY (detail_commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DBCABAE0 FOREIGN KEY (paid_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE977E148 FOREIGN KEY (appartenir_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE977E148');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93EDE14305');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DBCABAE0');
        $this->addSql('ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93B42ECE2D');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE product');
    }
}
