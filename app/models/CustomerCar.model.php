<?php
class CustomerCar extends SimpleOrm
{
    protected static
        $table = 'customer_car';

    public static function getSchemaSQL()
    {
        return <<<EOT
DROP TABLE IF EXISTS `customer_car`;\n
CREATE TABLE `customer_car` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` text COLLATE utf8_unicode_ci NOT NULL,
`mileage` int(11) NOT NULL,
`vin` text COLLATE utf8_unicode_ci NOT NULL,
`gv_number` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;\n
EOT;
    }
}
