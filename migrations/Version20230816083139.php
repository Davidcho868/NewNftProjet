<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230816083139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nft_categorie (nft_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_959E67AAE813668D (nft_id), INDEX IDX_959E67AABCF5E72D (categorie_id), PRIMARY KEY(nft_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nft_categorie ADD CONSTRAINT FK_959E67AAE813668D FOREIGN KEY (nft_id) REFERENCES nft (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nft_categorie ADD CONSTRAINT FK_959E67AABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634749051DE');
        $this->addSql('DROP INDEX IDX_497DD634749051DE ON categorie');
        $this->addSql('ALTER TABLE categorie DROP nfts_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft_categorie DROP FOREIGN KEY FK_959E67AAE813668D');
        $this->addSql('ALTER TABLE nft_categorie DROP FOREIGN KEY FK_959E67AABCF5E72D');
        $this->addSql('DROP TABLE nft_categorie');
        $this->addSql('ALTER TABLE categorie ADD nfts_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634749051DE FOREIGN KEY (nfts_id) REFERENCES nft (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_497DD634749051DE ON categorie (nfts_id)');
    }
}
