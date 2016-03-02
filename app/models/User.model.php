<?php
class User extends SimpleOrm
{
    protected static
      $table = 'users';

  public static function getSchemaSQL()
  {
    return <<<EOT
DROP TABLE IF EXISTS `users`;\n
CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` text COLLATE utf8_unicode_ci NOT NULL,
`password` text COLLATE utf8_unicode_ci NOT NULL,
`role` VARCHAR(32) COLLATE utf8_unicode_ci NOT NULL,
`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;\n
EOT;
  }
}
