<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240919233345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date_commande DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', statut VARCHAR(32) NOT NULL, prix_total DOUBLE PRECISION NOT NULL, agence VARCHAR(32) NOT NULL, date_retrait VARCHAR(32) NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_game (commande_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_4847306F82EA2E54 (commande_id), INDEX IDX_4847306FE48FD905 (game_id), PRIMARY KEY(commande_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, pegi INT NOT NULL, genre JSON NOT NULL, plateforme JSON NOT NULL, price DOUBLE PRECISION NOT NULL, promotion INT NOT NULL, quantity INT NOT NULL, release_date VARCHAR(32) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_panier (game_id INT NOT NULL, panier_id INT NOT NULL, INDEX IDX_59F9A03AE48FD905 (game_id), INDEX IDX_59F9A03AF77D927C (panier_id), PRIMARY KEY(game_id, panier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_24CC0DF2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, title VARCHAR(64) NOT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_16DB4F89E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, adresse VARCHAR(180) NOT NULL, codepostal VARCHAR(32) NOT NULL, ville VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', api_token VARCHAR(255) NOT NULL, first_name VARCHAR(32) NOT NULL, last_name VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ventes (id INT AUTO_INCREMENT NOT NULL, date_vente VARCHAR(32) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ventes_game (ventes_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_1A7189937D9932C (ventes_id), INDEX IDX_1A718993E48FD905 (game_id), PRIMARY KEY(ventes_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande_game ADD CONSTRAINT FK_4847306F82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_game ADD CONSTRAINT FK_4847306FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_panier ADD CONSTRAINT FK_59F9A03AE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_panier ADD CONSTRAINT FK_59F9A03AF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE ventes_game ADD CONSTRAINT FK_1A7189937D9932C FOREIGN KEY (ventes_id) REFERENCES ventes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ventes_game ADD CONSTRAINT FK_1A718993E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE commande_game DROP FOREIGN KEY FK_4847306F82EA2E54');
        $this->addSql('ALTER TABLE commande_game DROP FOREIGN KEY FK_4847306FE48FD905');
        $this->addSql('ALTER TABLE game_panier DROP FOREIGN KEY FK_59F9A03AE48FD905');
        $this->addSql('ALTER TABLE game_panier DROP FOREIGN KEY FK_59F9A03AF77D927C');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2A76ED395');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89E48FD905');
        $this->addSql('ALTER TABLE ventes_game DROP FOREIGN KEY FK_1A7189937D9932C');
        $this->addSql('ALTER TABLE ventes_game DROP FOREIGN KEY FK_1A718993E48FD905');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_game');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ventes');
        $this->addSql('DROP TABLE ventes_game');
    }
}
