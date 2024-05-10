<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510104201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horario (id INT AUTO_INCREMENT NOT NULL, servicio_id INT NOT NULL, diadia DATE NOT NULL, horario TIME NOT NULL, INDEX IDX_E25853A371CAA3E7 (servicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reserva_servicio (id INT AUTO_INCREMENT NOT NULL, servicio_id INT NOT NULL, nombre_cliente VARCHAR(255) NOT NULL, email_cliente VARCHAR(255) NOT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, INDEX IDX_A39A92E571CAA3E7 (servicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicio_spa (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, precio NUMERIC(5, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE horario ADD CONSTRAINT FK_E25853A371CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio_spa (id)');
        $this->addSql('ALTER TABLE reserva_servicio ADD CONSTRAINT FK_A39A92E571CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio_spa (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE horario DROP FOREIGN KEY FK_E25853A371CAA3E7');
        $this->addSql('ALTER TABLE reserva_servicio DROP FOREIGN KEY FK_A39A92E571CAA3E7');
        $this->addSql('DROP TABLE horario');
        $this->addSql('DROP TABLE reserva_servicio');
        $this->addSql('DROP TABLE servicio_spa');
    }
}
