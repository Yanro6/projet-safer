<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221231174111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD nom VARCHAR(255) DEFAULT NULL, DROP terrain_agricole, DROP prairie, DROP bois, DROP batiment, DROP exploitations');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie ADD terrain_agricole TINYINT(1) NOT NULL, ADD prairie TINYINT(1) NOT NULL, ADD bois TINYINT(1) NOT NULL, ADD batiment TINYINT(1) NOT NULL, ADD exploitations TINYINT(1) NOT NULL, DROP nom');
    }
}
