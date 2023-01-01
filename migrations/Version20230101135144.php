<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230101135144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE porteur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE porteur_bien (porteur_id INT NOT NULL, bien_id INT NOT NULL, INDEX IDX_7D1B5B005176442D (porteur_id), INDEX IDX_7D1B5B00BD95B80F (bien_id), PRIMARY KEY(porteur_id, bien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE porteur_bien ADD CONSTRAINT FK_7D1B5B005176442D FOREIGN KEY (porteur_id) REFERENCES porteur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE porteur_bien ADD CONSTRAINT FK_7D1B5B00BD95B80F FOREIGN KEY (bien_id) REFERENCES bien (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE porteur_bien DROP FOREIGN KEY FK_7D1B5B005176442D');
        $this->addSql('ALTER TABLE porteur_bien DROP FOREIGN KEY FK_7D1B5B00BD95B80F');
        $this->addSql('DROP TABLE porteur');
        $this->addSql('DROP TABLE porteur_bien');
    }
}
