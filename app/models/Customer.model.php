<?php
class Customer extends SimpleOrm
{
    protected static
        $table = 'customer';

    public static function getSchemaSQL()
    {
        return <<<EOT
DROP TABLE IF EXISTS `customer`;\n
CREATE TABLE `customer` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` text COLLATE utf8_unicode_ci NOT NULL,
`phone` text COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;\n
EOT;
    }
}
