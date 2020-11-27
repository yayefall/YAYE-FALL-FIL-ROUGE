<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201126202613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apprenant (id INT NOT NULL, profilsortie_id INT DEFAULT NULL, statut VARCHAR(100) NOT NULL, infocomplementaire VARCHAR(255) NOT NULL, categorie VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_C4EB462EFE5BE99E (profilsortie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(100) NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, contexte VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, date_decheance DATE NOT NULL, critere_performance VARCHAR(255) NOT NULL, modalite_pedagogique VARCHAR(255) NOT NULL, modalite_evaluation VARCHAR(255) NOT NULL, statut VARCHAR(100) NOT NULL, photo VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cm (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, descriptif VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, promo_id INT DEFAULT NULL, nom VARCHAR(150) NOT NULL, date_creation DATE NOT NULL, statut VARCHAR(100) NOT NULL, type VARCHAR(255) NOT NULL, archivage INT NOT NULL, INDEX IDX_4B98C21D0C07AFF (promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competence (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(200) NOT NULL, descriptif VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competence_tag (groupe_competence_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_4E0DECF489034830 (groupe_competence_id), INDEX IDX_4E0DECF4BAD26311 (tag_id), PRIMARY KEY(groupe_competence_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competence_competence (groupe_competence_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_F64AE85C89034830 (groupe_competence_id), INDEX IDX_F64AE85C15761DAB (competence_id), PRIMARY KEY(groupe_competence_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_competence_referentiel (groupe_competence_id INT NOT NULL, referentiel_id INT NOT NULL, INDEX IDX_1569CFDB89034830 (groupe_competence_id), INDEX IDX_1569CFDB805DB139 (referentiel_id), PRIMARY KEY(groupe_competence_id, referentiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, groupe_daction VARCHAR(255) NOT NULL, critere_evaluation VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_competence (niveau_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_C058EEB2B3E9C81 (niveau_id), INDEX IDX_C058EEB215761DAB (competence_id), PRIMARY KEY(niveau_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_brief (niveau_id INT NOT NULL, brief_id INT NOT NULL, INDEX IDX_FADCE261B3E9C81 (niveau_id), INDEX IDX_FADCE261757FABFF (brief_id), PRIMARY KEY(niveau_id, brief_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profilsortie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(80) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, langue VARCHAR(255) NOT NULL, titre VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, lieu VARCHAR(100) NOT NULL, fabrique VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, reference_agate VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_formateur (promo_id INT NOT NULL, formateur_id INT NOT NULL, INDEX IDX_C5BC19F4D0C07AFF (promo_id), INDEX IDX_C5BC19F4155D8F51 (formateur_id), PRIMARY KEY(promo_id, formateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo_referentiel (promo_id INT NOT NULL, referentiel_id INT NOT NULL, INDEX IDX_638B8B6BD0C07AFF (promo_id), INDEX IDX_638B8B6B805DB139 (referentiel_id), PRIMARY KEY(promo_id, referentiel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referentiel (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, presentation VARCHAR(255) NOT NULL, programme VARCHAR(255) NOT NULL, critere_admission VARCHAR(255) NOT NULL, critere_evaluation VARCHAR(255) NOT NULL, archivage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle INT NOT NULL, descriptif VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_groupe_tag (tag_id INT NOT NULL, groupe_tag_id INT NOT NULL, INDEX IDX_2932D77FBAD26311 (tag_id), INDEX IDX_2932D77FD1EC9F2B (groupe_tag_id), PRIMARY KEY(tag_id, groupe_tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_brief (tag_id INT NOT NULL, brief_id INT NOT NULL, INDEX IDX_3D570901BAD26311 (tag_id), INDEX IDX_3D570901757FABFF (brief_id), PRIMARY KEY(tag_id, brief_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, profils_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(100) NOT NULL, nom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, telephone VARCHAR(100) NOT NULL, photo LONGBLOB DEFAULT NULL, genre VARCHAR(20) NOT NULL, archivage INT NOT NULL, Profil VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), INDEX IDX_1483A5E9B9881AFB (profils_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EFE5BE99E FOREIGN KEY (profilsortie_id) REFERENCES profilsortie (id)');
        $this->addSql('ALTER TABLE apprenant ADD CONSTRAINT FK_C4EB462EBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cm ADD CONSTRAINT FK_3C0A377EBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE groupe_competence_tag ADD CONSTRAINT FK_4E0DECF489034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_tag ADD CONSTRAINT FK_4E0DECF4BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_competence ADD CONSTRAINT FK_F64AE85C89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_competence ADD CONSTRAINT FK_F64AE85C15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_referentiel ADD CONSTRAINT FK_1569CFDB89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_competence_referentiel ADD CONSTRAINT FK_1569CFDB805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_competence ADD CONSTRAINT FK_C058EEB2B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_competence ADD CONSTRAINT FK_C058EEB215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_brief ADD CONSTRAINT FK_FADCE261B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_brief ADD CONSTRAINT FK_FADCE261757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_formateur ADD CONSTRAINT FK_C5BC19F4155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referentiel ADD CONSTRAINT FK_638B8B6BD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referentiel ADD CONSTRAINT FK_638B8B6B805DB139 FOREIGN KEY (referentiel_id) REFERENCES referentiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_tag ADD CONSTRAINT FK_2932D77FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_tag ADD CONSTRAINT FK_2932D77FD1EC9F2B FOREIGN KEY (groupe_tag_id) REFERENCES groupe_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_brief ADD CONSTRAINT FK_3D570901BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_brief ADD CONSTRAINT FK_3D570901757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B9881AFB FOREIGN KEY (profils_id) REFERENCES profils (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE niveau_brief DROP FOREIGN KEY FK_FADCE261757FABFF');
        $this->addSql('ALTER TABLE tag_brief DROP FOREIGN KEY FK_3D570901757FABFF');
        $this->addSql('ALTER TABLE groupe_competence_competence DROP FOREIGN KEY FK_F64AE85C15761DAB');
        $this->addSql('ALTER TABLE niveau_competence DROP FOREIGN KEY FK_C058EEB215761DAB');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4155D8F51');
        $this->addSql('ALTER TABLE groupe_competence_tag DROP FOREIGN KEY FK_4E0DECF489034830');
        $this->addSql('ALTER TABLE groupe_competence_competence DROP FOREIGN KEY FK_F64AE85C89034830');
        $this->addSql('ALTER TABLE groupe_competence_referentiel DROP FOREIGN KEY FK_1569CFDB89034830');
        $this->addSql('ALTER TABLE tag_groupe_tag DROP FOREIGN KEY FK_2932D77FD1EC9F2B');
        $this->addSql('ALTER TABLE niveau_competence DROP FOREIGN KEY FK_C058EEB2B3E9C81');
        $this->addSql('ALTER TABLE niveau_brief DROP FOREIGN KEY FK_FADCE261B3E9C81');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B9881AFB');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EFE5BE99E');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21D0C07AFF');
        $this->addSql('ALTER TABLE promo_formateur DROP FOREIGN KEY FK_C5BC19F4D0C07AFF');
        $this->addSql('ALTER TABLE promo_referentiel DROP FOREIGN KEY FK_638B8B6BD0C07AFF');
        $this->addSql('ALTER TABLE groupe_competence_referentiel DROP FOREIGN KEY FK_1569CFDB805DB139');
        $this->addSql('ALTER TABLE promo_referentiel DROP FOREIGN KEY FK_638B8B6B805DB139');
        $this->addSql('ALTER TABLE groupe_competence_tag DROP FOREIGN KEY FK_4E0DECF4BAD26311');
        $this->addSql('ALTER TABLE tag_groupe_tag DROP FOREIGN KEY FK_2932D77FBAD26311');
        $this->addSql('ALTER TABLE tag_brief DROP FOREIGN KEY FK_3D570901BAD26311');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE apprenant DROP FOREIGN KEY FK_C4EB462EBF396750');
        $this->addSql('ALTER TABLE cm DROP FOREIGN KEY FK_3C0A377EBF396750');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FBF396750');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE apprenant');
        $this->addSql('DROP TABLE brief');
        $this->addSql('DROP TABLE cm');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE groupe_competence');
        $this->addSql('DROP TABLE groupe_competence_tag');
        $this->addSql('DROP TABLE groupe_competence_competence');
        $this->addSql('DROP TABLE groupe_competence_referentiel');
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE livrable');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE niveau_competence');
        $this->addSql('DROP TABLE niveau_brief');
        $this->addSql('DROP TABLE profils');
        $this->addSql('DROP TABLE profilsortie');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE promo_formateur');
        $this->addSql('DROP TABLE promo_referentiel');
        $this->addSql('DROP TABLE referentiel');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_groupe_tag');
        $this->addSql('DROP TABLE tag_brief');
        $this->addSql('DROP TABLE users');
    }
}
