#!/bin/bash
php migrate_run.php

php add_user.php vugluskr admin 123456
php add_user.php "Залупов Григоий Семенович" manager 654321
php add_user.php "Крыса Солидольная Первая" rat 123
php add_user.php "Крыса Солидольная Вторая" rat 123
php add_user.php "Крыса Солидольная ЕщеОдна" rat 123

php add_customer.php "Петров Петр Петрович" "+792512345687"
php add_customer.php "Мандачаев Хуй Залупович" "+792512345589"
php add_customer.php "Охуевший Гандон Черезжопович" "+795812345589"
php add_customer.php "Глазозоп Ебаный Шакалович" "+795815355589"

php add_customer_car.php Car1 1 vin01-123 123
php add_customer_car.php Car2 2 vin02-456 456
php add_customer_car.php Car3 3 vin03-789 789
php add_customer_car.php Car4 4 vin04-012 012
php add_customer_car.php Car5 5 vin05-345 345
php add_customer_car.php Car6 6 vin06-678 678
php add_customer_car.php Car7 7 vin07-901 901
php add_customer_car.php Car8 8 vin08-234 234