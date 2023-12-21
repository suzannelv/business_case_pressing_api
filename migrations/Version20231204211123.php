<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204211123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail ADD user_id INT NOT NULL, ADD staff_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46D4D57CD FOREIGN KEY (staff_id) REFERENCES staff (id)');
        $this->addSql('CREATE INDEX IDX_ED896F46A76ED395 ON order_detail (user_id)');
        $this->addSql('CREATE INDEX IDX_ED896F46D4D57CD ON order_detail (staff_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46A76ED395');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46D4D57CD');
        $this->addSql('DROP INDEX IDX_ED896F46A76ED395 ON order_detail');
        $this->addSql('DROP INDEX IDX_ED896F46D4D57CD ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP user_id, DROP staff_id');
    }
}
