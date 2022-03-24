<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324010749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'complete database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE color_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE option_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shopper_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE size_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, company VARCHAR(45) NOT NULL, discount_rate DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455E7927C74 ON client (email)');
        $this->addSql('CREATE TABLE color (id INT NOT NULL, color VARCHAR(45) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, size_id INT NOT NULL, designation VARCHAR(45) NOT NULL, description TEXT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D9498DA827 ON model (size_id)');
        $this->addSql('CREATE TABLE Model_has_Option (model_id INT NOT NULL, option_id INT NOT NULL, PRIMARY KEY(model_id, option_id))');
        $this->addSql('CREATE INDEX IDX_F0862F77975B7E7 ON Model_has_Option (model_id)');
        $this->addSql('CREATE INDEX IDX_F0862F7A7C41D6F ON Model_has_Option (option_id)');
        $this->addSql('CREATE TABLE option (id INT NOT NULL, option VARCHAR(45) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, model_id INT NOT NULL, color_id INT NOT NULL, ean13 VARCHAR(13) NOT NULL, stock INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D34A04AD7975B7E7 ON product (model_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD7ADA1FB5 ON product (color_id)');
        $this->addSql('CREATE TABLE shopper (id INT NOT NULL, client_id INT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_26663F5D19EB6921 ON shopper (client_id)');
        $this->addSql('CREATE TABLE size (id INT NOT NULL, size DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9498DA827 FOREIGN KEY (size_id) REFERENCES size (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE Model_has_Option ADD CONSTRAINT FK_F0862F77975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE Model_has_Option ADD CONSTRAINT FK_F0862F7A7C41D6F FOREIGN KEY (option_id) REFERENCES option (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE shopper ADD CONSTRAINT FK_26663F5D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE shopper DROP CONSTRAINT FK_26663F5D19EB6921');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD7ADA1FB5');
        $this->addSql('ALTER TABLE Model_has_Option DROP CONSTRAINT FK_F0862F77975B7E7');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_D34A04AD7975B7E7');
        $this->addSql('ALTER TABLE Model_has_Option DROP CONSTRAINT FK_F0862F7A7C41D6F');
        $this->addSql('ALTER TABLE model DROP CONSTRAINT FK_D79572D9498DA827');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE color_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE option_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shopper_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE size_id_seq CASCADE');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE Model_has_Option');
        $this->addSql('DROP TABLE option');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE shopper');
        $this->addSql('DROP TABLE size');
    }
}
