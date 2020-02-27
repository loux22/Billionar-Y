<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227103634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_880E0D7679F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description_g VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, nb_play INT NOT NULL, img VARCHAR(100) NOT NULL, winnings_max INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historic (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, nb_party INT NOT NULL, total INT NOT NULL, INDEX IDX_AD52EF56E48FD905 (game_id), INDEX IDX_AD52EF56A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, phone VARCHAR(10) DEFAULT NULL, address VARCHAR(100) DEFAULT NULL, postal VARCHAR(5) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, ip_adress VARCHAR(15) DEFAULT NULL, bank INT NOT NULL, UNIQUE INDEX UNIQ_70E4FA78A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, member_id INT DEFAULT NULL, game_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_CFBDFA147597D3FE (member_id), INDEX IDX_CFBDFA14E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ranking_winning (id INT AUTO_INCREMENT NOT NULL, id_member_id INT DEFAULT NULL, id_game_id INT DEFAULT NULL, winning INT NOT NULL, date_r DATE NOT NULL, INDEX IDX_1DC3242F5A26FD9 (id_member_id), INDEX IDX_1DC32423A127075 (id_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(30) NOT NULL, lastname VARCHAR(30) NOT NULL, mail VARCHAR(50) NOT NULL, password VARCHAR(100) NOT NULL, avatar VARCHAR(100) NOT NULL, date_u DATE NOT NULL, is_active TINYINT(1) NOT NULL, pseudo VARCHAR(50) NOT NULL, age DATE NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA147597D3FE FOREIGN KEY (member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE ranking_winning ADD CONSTRAINT FK_1DC3242F5A26FD9 FOREIGN KEY (id_member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE ranking_winning ADD CONSTRAINT FK_1DC32423A127075 FOREIGN KEY (id_game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historic DROP FOREIGN KEY FK_AD52EF56E48FD905');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14E48FD905');
        $this->addSql('ALTER TABLE ranking_winning DROP FOREIGN KEY FK_1DC32423A127075');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA147597D3FE');
        $this->addSql('ALTER TABLE ranking_winning DROP FOREIGN KEY FK_1DC3242F5A26FD9');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D7679F37AE5');
        $this->addSql('ALTER TABLE historic DROP FOREIGN KEY FK_AD52EF56A76ED395');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78A76ED395');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE historic');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE ranking_winning');
        $this->addSql('DROP TABLE user');
    }
}
