<?php
include_once(dirname(__FILE__) . "/../libs/__mysql.php");

include_once(dirname(__FILE__) . "/Customer.model.php");
include_once(dirname(__FILE__) . "/CustomerCar.model.php");
include_once(dirname(__FILE__) . "/EventLog.model.php");
include_once(dirname(__FILE__) . "/GreaseRatEvent.model.php");
include_once(dirname(__FILE__) . "/RepairPost.model.php");
include_once(dirname(__FILE__) . "/RepairType.model.php");
include_once(dirname(__FILE__) . "/User.model.php");

function getMigrateQueryHeader()
{
    return <<<EOT
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';\n
EOT;
}

function migrate()
{
    global $conn;

    $sql  = getMigrateQueryHeader();
    $sql .= Customer::getSchemaSQL();
    $sql .= CustomerCar::getSchemaSQL();
    $sql .= EventLog::getSchemaSQL();
    $sql .= GreaseRatEvent::getSchemaSQL();
    $sql .= RepairPost::getSchemaSQL();
    $sql .= RepairType::getSchemaSQL();
    $sql .= User::getSchemaSQL();

    if ($conn->multi_query($sql))
    {
        do
        {
            if ($result = $conn->store_result())
            {
                while ($row = $result->fetch_row())
                {
                    printf("%s\n", $row[0]);
                }
                $result->free();
            }

            if ($conn->more_results())
            {
                printf("-----------------\n");
            }
        } while ($conn->next_result());
    }

    $conn->close();
}
