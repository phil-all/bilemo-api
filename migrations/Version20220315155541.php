<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220315155541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables from product part: product, color, hardware, product_has_color and product_has_hardware';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE color_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE hardware_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE color (id INT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE hardware (id INT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, model VARCHAR(80) NOT NULL, description TEXT NOT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE products_has_color (product_id INT NOT NULL, color_id INT NOT NULL, PRIMARY KEY(product_id, color_id))');
        $this->addSql('CREATE INDEX IDX_CFA2BB714584665A ON products_has_color (product_id)');
        $this->addSql('CREATE INDEX IDX_CFA2BB717ADA1FB5 ON products_has_color (color_id)');
        $this->addSql('CREATE TABLE products_has_hardware (product_id INT NOT NULL, hardware_id INT NOT NULL, PRIMARY KEY(product_id, hardware_id))');
        $this->addSql('CREATE INDEX IDX_88D8847A4584665A ON products_has_hardware (product_id)');
        $this->addSql('CREATE INDEX IDX_88D8847AC9CC762B ON products_has_hardware (hardware_id)');
        $this->addSql('ALTER TABLE products_has_color ADD CONSTRAINT FK_CFA2BB714584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_has_color ADD CONSTRAINT FK_CFA2BB717ADA1FB5 FOREIGN KEY (color_id) REFERENCES color (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_has_hardware ADD CONSTRAINT FK_88D8847A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_has_hardware ADD CONSTRAINT FK_88D8847AC9CC762B FOREIGN KEY (hardware_id) REFERENCES hardware (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE products_has_color DROP CONSTRAINT FK_CFA2BB717ADA1FB5');
        $this->addSql('ALTER TABLE products_has_hardware DROP CONSTRAINT FK_88D8847AC9CC762B');
        $this->addSql('ALTER TABLE products_has_color DROP CONSTRAINT FK_CFA2BB714584665A');
        $this->addSql('ALTER TABLE products_has_hardware DROP CONSTRAINT FK_88D8847A4584665A');
        $this->addSql('DROP SEQUENCE color_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE hardware_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE hardware');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE products_has_color');
        $this->addSql('DROP TABLE products_has_hardware');
    }
}
