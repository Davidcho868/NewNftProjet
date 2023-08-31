<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230818070433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE acheter_nft DROP FOREIGN KEY FK_C95993A0E813668D');
        $this->addSql('ALTER TABLE acheter_nft DROP FOREIGN KEY FK_C95993A0FB96A1CA');
        $this->addSql('ALTER TABLE acheter_user DROP FOREIGN KEY FK_743A97F3A76ED395');
        $this->addSql('ALTER TABLE acheter_user DROP FOREIGN KEY FK_743A97F3FB96A1CA');
        $this->addSql('DROP TABLE acheter');
        $this->addSql('DROP TABLE acheter_nft');
        $this->addSql('DROP TABLE acheter_user');
        $this->addSql('ALTER TABLE image ADD path VARCHAR(255) DEFAULT NULL, DROP lien_image, DROP nom_image, DROP description, CHANGE updated_at updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE nft DROP INDEX IDX_D9C7463C3DA5256D, ADD UNIQUE INDEX UNIQ_D9C7463C3DA5256D (image_id)');
        $this->addSql('ALTER TABLE nft ADD user_id INT DEFAULT NULL, CHANGE image_id image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9C7463CA76ED395 ON nft (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acheter (id INT AUTO_INCREMENT NOT NULL, date_achat DATE NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE acheter_nft (acheter_id INT NOT NULL, nft_id INT NOT NULL, INDEX IDX_C95993A0E813668D (nft_id), INDEX IDX_C95993A0FB96A1CA (acheter_id), PRIMARY KEY(acheter_id, nft_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE acheter_user (acheter_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_743A97F3A76ED395 (user_id), INDEX IDX_743A97F3FB96A1CA (acheter_id), PRIMARY KEY(acheter_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE acheter_nft ADD CONSTRAINT FK_C95993A0E813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acheter_nft ADD CONSTRAINT FK_C95993A0FB96A1CA FOREIGN KEY (acheter_id) REFERENCES acheter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acheter_user ADD CONSTRAINT FK_743A97F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acheter_user ADD CONSTRAINT FK_743A97F3FB96A1CA FOREIGN KEY (acheter_id) REFERENCES acheter (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nft DROP INDEX UNIQ_D9C7463C3DA5256D, ADD INDEX IDX_D9C7463C3DA5256D (image_id)');
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463CA76ED395');
        $this->addSql('DROP INDEX IDX_D9C7463CA76ED395 ON nft');
        $this->addSql('ALTER TABLE nft DROP user_id, CHANGE image_id image_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD lien_image VARCHAR(255) NOT NULL, ADD nom_image VARCHAR(255) NOT NULL, ADD description VARCHAR(255) NOT NULL, DROP path, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
