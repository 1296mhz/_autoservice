<?php
class RepairPost extends SimpleOrm
{
    protected static
        $table = 'repair_post';

    public static function getSchemaSQL()
    {
        return <<<EOT
DROP TABLE IF EXISTS `repair_post`;\n
CREATE TABLE `repair_post` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` text COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;\n
EOT;
    }
}
