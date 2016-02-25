<?php
class EventLog extends SimpleOrm
{
    protected static
      $table = 'event_logs';

    public static function getSchemaSQL()
    {
      return <<<EOT
DROP TABLE IF EXISTS `event_logs`;\n
CREATE TABLE `event_logs` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`eventid` int(11) NOT NULL,
`userid` int(11) NOT NULL,
`action` tinyint(4) NOT NULL,
`created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;\n
EOT;
    }
}
