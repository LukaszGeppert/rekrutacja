<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250327174944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add new WiseB2B supplier';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO supplier (id, is_active, sys_insert_date, sys_update_date, entity_hash, sort_order, payload_bag, id_external, symbol, tax_number, email, phone, registered_trade_name, dtype) VALUES
                        ((SELECT nextval('supplier_id_seq')), true, NOW(), NOW(), null, 0, null, null, 'WiseB2B', '1234567890', 'przykladowy_jan_kowalski@example.com', '000111999', 'WiseB2B Sp. z o.o.', '')");

        $this->addSql("INSERT INTO global_address (id, is_active, sys_insert_date, sys_update_date, entity_hash, sort_order, payload_bag, entity_name, field_name, entity_id, name, street, house_number, apartment_number, city, postal_code, country_code, state) VALUES
                        ((SELECT nextval('global_address_id_seq')), true, NOW(), NOW(), null, 0, null, 'supplier', 'address', (SELECT currval('supplier_id_seq')), '', 'Przykładowa', '44', null, 'Warszawa', '00-000', 'pl', null)");
    }

    public function down(Schema $schema): void
    {
        // one way migration
    }
}
