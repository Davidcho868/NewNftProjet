<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230812080525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT AUTO_INCREMENT NOT NULL, date_achat DATE NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acheter_nft (acheter_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_C95993A0FB96A1CA (acheter_id), INDEX IDX_C95993A0E813668D (nft_id), PRIMARY KEY(acheter_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acheter_user (acheter_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_743A97F3FB96A1CA (acheter_id), INDEX IDX_743A97F3A76ED395 (user_id), PRIMARY KEY(acheter_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, ligne1 VARCHAR(255) NOT NULL, ligne2 VARCHAR(255) NOT NULL, ligne3 VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nfts_id INT DEFAULT NULL, nom_categorie VARCHAR(255) NOT NULL, INDEX IDX_497DD634749051DE (nfts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eth (id INT AUTO_INCREMENT NOT NULL, cours_eth DOUBLE PRECISION NOT NULL, jour_du_cours DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, lien_image VARCHAR(255) NOT NULL, nom_image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nft (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, eth_id INT DEFAULT NULL, valeur_euro DOUBLE PRECISION NOT NULL, prix_eth DOUBLE PRECISION NOT NULL, is_en_vente TINYINT(1) NOT NULL, INDEX IDX_D9C7463C3DA5256D (image_id), INDEX IDX_D9C7463C823BBA8B (eth_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acheter_nft ADD CONSTRAINT FK_C95993A0FB96A1CA FOREIGN KEY (acheter_id) REFERENCES acheter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acheter_nft ADD CONSTRAINT FK_C95993A0E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acheter_user ADD CONSTRAINT FK_743A97F3FB96A1CA FOREIGN KEY (acheter_id) REFERENCES acheter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acheter_user ADD CONSTRAINT FK_743A97F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634749051DE FOREIGN KEY (nfts_id) REFERENCES nft (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C823BBA8B FOREIGN KEY (eth_id) REFERENCES eth (id)');
        $this->addSql('ALTER TABLE user ADD adresses_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64985E14726 FOREIGN KEY (adresses_id) REFERENCES adresse (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64985E14726 ON user (adresses_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64985E14726');
        $this->addSql('ALTER TABLE acheter_nft DROP FOREIGN KEY FK_C95993A0FB96A1CA');
        $this->addSql('ALTER TABLE acheter_nft DROP FOREIGN KEY FK_C95993A0E813668D');
        $this->addSql('ALTER TABLE acheter_user DROP FOREIGN KEY FK_743A97F3FB96A1CA');
        $this->addSql('ALTER TABLE acheter_user DROP FOREIGN KEY FK_743A97F3A76ED395');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634749051DE');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C3DA5256D');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C823BBA8B');
        $this->addSql('DROP TABLE acheter');
        $this->addSql('DROP TABLE acheter_nft');
        $this->addSql('DROP TABLE acheter_user');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE eth');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE nft');
        $this->addSql('DROP INDEX IDX_8D93D64985E14726 ON user');
        $this->addSql('ALTER TABLE user DROP adresses_id');
    }
}
