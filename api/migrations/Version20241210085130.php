<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210085130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD user_detail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ALTER password SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER roles SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D8308E5F FOREIGN KEY (user_detail_id) REFERENCES user_detail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D8308E5F ON "user" (user_detail_id)');
        $this->addSql('ALTER TABLE user_detail DROP CONSTRAINT fk_4b5464ae9b6b5fba');
        $this->addSql('DROP INDEX uniq_4b5464ae9b6b5fba');
        $this->addSql('ALTER TABLE user_detail DROP account_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D8308E5F');
        $this->addSql('DROP INDEX UNIQ_8D93D649D8308E5F');
        $this->addSql('ALTER TABLE "user" DROP user_detail_id');
        $this->addSql('ALTER TABLE "user" ALTER roles DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER password DROP NOT NULL');
        $this->addSql('ALTER TABLE user_detail ADD account_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_detail ADD CONSTRAINT fk_4b5464ae9b6b5fba FOREIGN KEY (account_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_4b5464ae9b6b5fba ON user_detail (account_id)');
    }
}
