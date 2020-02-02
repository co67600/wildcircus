<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200202205622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tournee_reservation (tournee_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_4189555DF661D013 (tournee_id), INDEX IDX_4189555DB83297E7 (reservation_id), PRIMARY KEY(tournee_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournee_reservation ADD CONSTRAINT FK_4189555DF661D013 FOREIGN KEY (tournee_id) REFERENCES tournee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournee_reservation ADD CONSTRAINT FK_4189555DB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955F661D013');
        $this->addSql('DROP INDEX IDX_42C84955F661D013 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP tournee_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tournee_reservation');
        $this->addSql('ALTER TABLE reservation ADD tournee_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955F661D013 FOREIGN KEY (tournee_id) REFERENCES tournee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_42C84955F661D013 ON reservation (tournee_id)');
    }
}
