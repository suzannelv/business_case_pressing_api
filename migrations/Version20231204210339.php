<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204210339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price_coefficent DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, payment_id INT NOT NULL, order_number VARCHAR(255) NOT NULL, createdat DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, code_promo VARCHAR(255) DEFAULT NULL, delivery TINYINT(1) NOT NULL, deposit_date DATETIME NOT NULL, retrieve_date DATETIME NOT NULL, INDEX IDX_ED896F466BF700BD (status_id), INDEX IDX_ED896F464C3A3BB (payment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_detail (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, product_id INT NOT NULL, order_related_id INT NOT NULL, material_id INT NOT NULL, description LONGTEXT DEFAULT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_4C7A3E37ED5CA9E6 (service_id), INDEX IDX_4C7A3E374584665A (product_id), INDEX IDX_4C7A3E37F2B83D54 (order_related_id), INDEX IDX_4C7A3E37E308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price_coefficent DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT AUTO_INCREMENT NOT NULL, zc_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, admin_role TINYINT(1) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, profile_url VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, birthday DATE NOT NULL, UNIQUE INDEX UNIQ_426EF392E7927C74 (email), INDEX IDX_426EF392C5D34BBC (zc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, zc_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, birthday DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tel VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, profile_url VARCHAR(255) DEFAULT NULL, balance DOUBLE PRECISION NOT NULL, membership TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649C5D34BBC (zc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE zip_code (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, zc VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_A1ACE158F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F466BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464C3A3BB FOREIGN KEY (payment_id) REFERENCES payment_method (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_detail ADD CONSTRAINT FK_4C7A3E37ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE product_detail ADD CONSTRAINT FK_4C7A3E374584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_detail ADD CONSTRAINT FK_4C7A3E37F2B83D54 FOREIGN KEY (order_related_id) REFERENCES order_detail (id)');
        $this->addSql('ALTER TABLE product_detail ADD CONSTRAINT FK_4C7A3E37E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392C5D34BBC FOREIGN KEY (zc_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C5D34BBC FOREIGN KEY (zc_id) REFERENCES zip_code (id)');
        $this->addSql('ALTER TABLE zip_code ADD CONSTRAINT FK_A1ACE158F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F466BF700BD');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464C3A3BB');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_detail DROP FOREIGN KEY FK_4C7A3E37ED5CA9E6');
        $this->addSql('ALTER TABLE product_detail DROP FOREIGN KEY FK_4C7A3E374584665A');
        $this->addSql('ALTER TABLE product_detail DROP FOREIGN KEY FK_4C7A3E37F2B83D54');
        $this->addSql('ALTER TABLE product_detail DROP FOREIGN KEY FK_4C7A3E37E308AC6F');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF392C5D34BBC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C5D34BBC');
        $this->addSql('ALTER TABLE zip_code DROP FOREIGN KEY FK_A1ACE158F92F3E70');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_detail');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE zip_code');
    }
}
