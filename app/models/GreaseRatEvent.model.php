<?php
class GreaseRatEvent extends SimpleOrm
{
    protected static
      $table = 'grease_rat_work';

  public static function getSchemaSQL()
  {
    return <<<EOT
DROP TABLE IF EXISTS `grease_rat_work`;\n
CREATE TABLE `grease_rat_work` (
`id` int(11) NOT NULL AUTO_INCREMENT,

`repair_post_id` int(11) NOT NULL,
`repair_type_id` int(11) NOT NULL,

`user_owner_id` int(11) NOT NULL,
`user_target_id` int(11) NOT NULL,

`state` tinyint(4) NOT NULL,

`customer_id` int(11) NOT NULL,
`customer_car_id` int(11) NOT NULL,

`startdatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
`enddatetime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',

`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;\n
EOT;
  }
}
