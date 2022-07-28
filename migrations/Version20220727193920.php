<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220727193920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video ADD author_id INT DEFAULT NULL, ADD category_id INT NOT NULL, ADD request_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C427EB8A5 FOREIGN KEY (request_id) REFERENCES request (id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2CF675F31B ON video (author_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C12469DE2 ON video (category_id)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C427EB8A5 ON video (request_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CF675F31B');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C12469DE2');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2C427EB8A5');
        $this->addSql('DROP INDEX IDX_7CC7DA2CF675F31B ON video');
        $this->addSql('DROP INDEX IDX_7CC7DA2C12469DE2 ON video');
        $this->addSql('DROP INDEX IDX_7CC7DA2C427EB8A5 ON video');
        $this->addSql('ALTER TABLE video DROP author_id, DROP category_id, DROP request_id');
    }
}
