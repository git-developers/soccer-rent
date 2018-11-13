<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171012210304 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE profile (id_increment INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_has_role (profile_id INT NOT NULL, role_id INT NOT NULL, INDEX IDX_F35F3084CCFA12B8 (profile_id), INDEX IDX_F35F3084D60322AC (role_id), PRIMARY KEY(profile_id, role_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id_increment INT AUTO_INCREMENT NOT NULL, code VARCHAR(45) DEFAULT NULL, name VARCHAR(150) NOT NULL, slug VARCHAR(150) DEFAULT NULL, image TEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bet (id_increment INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, matchKey VARCHAR(45) DEFAULT NULL, team_home VARCHAR(45) DEFAULT NULL, team_away VARCHAR(45) DEFAULT NULL, team_home_score INT DEFAULT NULL, team_away_score INT DEFAULT NULL, token VARCHAR(45) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D044D5D4A76ED395 (user_id), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva (id_increment INT AUTO_INCREMENT NOT NULL, point_of_sale_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, inicio DATETIME DEFAULT NULL, fin DATETIME DEFAULT NULL, time VARCHAR(80) DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, INDEX fk_reserva_point_of_sale1_idx (point_of_sale_id), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE point_of_sale (id_increment INT AUTO_INCREMENT NOT NULL, point_of_sale_id INT DEFAULT NULL, code VARCHAR(45) DEFAULT NULL, name VARCHAR(100) DEFAULT NULL, slug VARCHAR(100) NOT NULL, latitude NUMERIC(11, 8) DEFAULT NULL, longitude NUMERIC(11, 8) DEFAULT NULL, description TEXT DEFAULT NULL, image TEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX fk_point_of_sale_point_of_sale1_idx (point_of_sale_id), UNIQUE INDEX code_UNIQUE (code), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_has_product (id_increment INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, product_id INT DEFAULT NULL, stock INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX fk_category_has_product_product1_idx (product_id), INDEX fk_category_has_product_category1_idx (category_id), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id_increment INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) DEFAULT NULL, slug VARCHAR(100) NOT NULL, group_rol VARCHAR(100) DEFAULT NULL, group_rol_tag VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id_increment INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(45) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D044D5D4A76ED395 (user_id), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE point_of_sale_has_product (id_increment INT AUTO_INCREMENT NOT NULL, point_of_sale_id INT DEFAULT NULL, product_id INT DEFAULT NULL, stock INT DEFAULT NULL, stock_min INT DEFAULT NULL, stock_max INT DEFAULT NULL, description TEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX fk_point_of_sale_has_product_product1_idx (product_id), INDEX fk_point_of_sale_has_product_point_of_sale1_idx (point_of_sale_id), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id_increment INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, code VARCHAR(45) DEFAULT NULL, name VARCHAR(150) DEFAULT NULL, slug VARCHAR(150) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX fk_category_category1_idx (category_id), UNIQUE INDEX code_UNIQUE (code), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report_point_of_sale_and_product (id_increment INT AUTO_INCREMENT NOT NULL, point_of_sale_has_product_id INT DEFAULT NULL, time_delivery DATETIME DEFAULT NULL, stock_out INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX fk_report_point_of_sale_and_product_point_of_sale_has_produ_idx (point_of_sale_has_product_id), PRIMARY KEY(id_increment)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', client_id INT DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, device_code VARCHAR(100) DEFAULT NULL, dni VARCHAR(8) DEFAULT NULL, name VARCHAR(100) NOT NULL, last_name VARCHAR(100) DEFAULT NULL, dob DATE DEFAULT NULL, address VARCHAR(100) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, last_access DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), INDEX FK_8D93D649CCFA12B8 (profile_id), UNIQUE INDEX email_UNIQUE (email), UNIQUE INDEX username_UNIQUE (username), UNIQUE INDEX dni_UNIQUE (dni), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_has_point_of_sale (user_id INT NOT NULL, point_of_sale_id INT NOT NULL, INDEX IDX_AD4176D6A76ED395 (user_id), INDEX IDX_AD4176D66B7E9A73 (point_of_sale_id), PRIMARY KEY(user_id, point_of_sale_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_has_role ADD CONSTRAINT FK_F35F3084CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id_increment)');
        $this->addSql('ALTER TABLE profile_has_role ADD CONSTRAINT FK_F35F3084D60322AC FOREIGN KEY (role_id) REFERENCES role (id_increment)');
        $this->addSql('ALTER TABLE bet ADD CONSTRAINT FK_FBF0EC9BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B6B7E9A73 FOREIGN KEY (point_of_sale_id) REFERENCES point_of_sale (id_increment)');
        $this->addSql('ALTER TABLE point_of_sale ADD CONSTRAINT FK_F7A7B1FA6B7E9A73 FOREIGN KEY (point_of_sale_id) REFERENCES point_of_sale (id_increment)');
        $this->addSql('ALTER TABLE category_has_product ADD CONSTRAINT FK_3202E1D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id_increment)');
        $this->addSql('ALTER TABLE category_has_product ADD CONSTRAINT FK_3202E1D4584665A FOREIGN KEY (product_id) REFERENCES product (id_increment)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE point_of_sale_has_product ADD CONSTRAINT FK_63AAC6456B7E9A73 FOREIGN KEY (point_of_sale_id) REFERENCES point_of_sale (id_increment)');
        $this->addSql('ALTER TABLE point_of_sale_has_product ADD CONSTRAINT FK_63AAC6454584665A FOREIGN KEY (product_id) REFERENCES product (id_increment)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C112469DE2 FOREIGN KEY (category_id) REFERENCES category (id_increment)');
        $this->addSql('ALTER TABLE report_point_of_sale_and_product ADD CONSTRAINT FK_72D879C3BBB3B046 FOREIGN KEY (point_of_sale_has_product_id) REFERENCES point_of_sale_has_product (id_increment)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id_increment)');
        $this->addSql('ALTER TABLE user_has_point_of_sale ADD CONSTRAINT FK_AD4176D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_has_point_of_sale ADD CONSTRAINT FK_AD4176D66B7E9A73 FOREIGN KEY (point_of_sale_id) REFERENCES point_of_sale (id_increment)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE profile_has_role DROP FOREIGN KEY FK_F35F3084CCFA12B8');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('ALTER TABLE category_has_product DROP FOREIGN KEY FK_3202E1D4584665A');
        $this->addSql('ALTER TABLE point_of_sale_has_product DROP FOREIGN KEY FK_63AAC6454584665A');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B6B7E9A73');
        $this->addSql('ALTER TABLE point_of_sale DROP FOREIGN KEY FK_F7A7B1FA6B7E9A73');
        $this->addSql('ALTER TABLE point_of_sale_has_product DROP FOREIGN KEY FK_63AAC6456B7E9A73');
        $this->addSql('ALTER TABLE user_has_point_of_sale DROP FOREIGN KEY FK_AD4176D66B7E9A73');
        $this->addSql('ALTER TABLE profile_has_role DROP FOREIGN KEY FK_F35F3084D60322AC');
        $this->addSql('ALTER TABLE report_point_of_sale_and_product DROP FOREIGN KEY FK_72D879C3BBB3B046');
        $this->addSql('ALTER TABLE category_has_product DROP FOREIGN KEY FK_3202E1D12469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C112469DE2');
        $this->addSql('ALTER TABLE bet DROP FOREIGN KEY FK_FBF0EC9BA76ED395');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D4A76ED395');
        $this->addSql('ALTER TABLE user_has_point_of_sale DROP FOREIGN KEY FK_AD4176D6A76ED395');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE profile_has_role');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE bet');
        $this->addSql('DROP TABLE reserva');
        $this->addSql('DROP TABLE point_of_sale');
        $this->addSql('DROP TABLE category_has_product');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE point_of_sale_has_product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE report_point_of_sale_and_product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_has_point_of_sale');
    }
}
