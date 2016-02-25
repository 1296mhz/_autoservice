<?php
include(dirname(__FILE__) . "/libs/__init.php");
include(dirname(__FILE__) . "/libs/auth.php");
include(dirname(__FILE__) . "/libs/Router.php");

use \NoahBuscher\Macaw\Macaw;

// роли пользователей
class RoleTypes
{
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_RAT = 'rat';
}

// декораторы для рендера шабона
class ViewDecorators
{
    public static $ROLE_NAMES = [
        RoleTypes::ROLE_ADMIN => 'Администратор',
        RoleTypes::ROLE_MANAGER => 'Мастер приемщик',
        RoleTypes::ROLE_RAT => 'Автомеханик',
    ];

    public static function decorateRole( $role )
    {
        return array_key_exists($role, ViewDecorators::$ROLE_NAMES) ? ViewDecorators::$ROLE_NAMES[ $role ] : "Гость";
    }
}

function makeSourceResponse( $queryResult )
{
    $result = [];

    foreach( $queryResult as $key => $value )
    {
        array_push( $result, (object)$value );
    }

    return $result;
}

function fetchSource( $source, $field, $query, $existFields )
{
    if( !in_array($field, $existFields) || !isset($query) )
    {
        return [];
    }

    return makeSourceResponse( $source::retrieveByField($field, "%" . urldecode($query) . "%", SimpleOrm::FETCH_MANY) );
}

// главная страница
Macaw::get('/', function()
{
    Application::sendHTMLString( Application::template(dirname(__FILE__) . "/templates/index.html", [
        'user' => checkAuth()
    ]));
});

// Поиск по пользователям
Macaw::post('/customer_sources/(:any)/(:any)', function($field, $query)
{
    $user = checkAuth();

    Application::sendJson( fetchSource('Customer', $field, $query, [ "name", "phone" ]) );
});

// Поиск по пользователям
Macaw::post('/customer_car_sources/(:any)/(:any)', function($field, $query)
{
    $user = checkAuth();

    Application::sendJson( fetchSource('CustomerCar', $field, $query, [ "vin", "gv_number" ]) );
});

// Поиск по пользователям
Macaw::post('/users/(:any)/(:any)', function($field, $query)
{
    $user = checkAuth();

    Application::sendJson( fetchSource('User', $field, $query, [ "name" ]) );
});

// создание события
Macaw::post('/create_event', function()
{
    $user = checkAuth();

    $gump = new GUMP();
   // $_POST = $gump->sanitize($_POST);

    if( !isset($_POST["formData"]) )
    {
        Application::sendJson( [
            "err" => "UNDEFINED_FORM_DATA"
        ]);
    }

    if( !isset($_POST["eventData"]) )
    {
        Application::sendJson( [
            "err" => "UNDEFINED_EVENT_DATA"
        ]);
    }

    if( !isset($_POST["eventData"]["user_target_id"]) )
    {
        Application::sendJson( [
            "err" => "UNDEFINED_TARGET_USER"
        ]);
    }

    $customer_id     = $_POST["eventData"]["customer_id"];
    $customer_car_id = $_POST["eventData"]["customer_car_id"];

    $gump->validation_rules(array(
        'repair_post_id' => 'required|integer',
        'repair_type_id' => 'required|integer',
        'user_target_id' => 'required|integer',
        'startdatetime' => 'required',
        'enddatetime' => 'required',
        'customer_car_gv_number' => 'required',
        'customer_car_mileage' => 'integer',
        'customer_car_name' => 'required',
        'customer_car_vin' => 'required',
        'customer_name' => 'required',
        'customer_phone' => 'required'
    ));

    $gump->filter_rules(array(
        'customer_car_gv_number' => 'trim|sanitize_string',
        'customer_car_name'      => 'trim|sanitize_string',
        'customer_car_vin'       => 'trim|sanitize_string',
        'customer_name'          => 'trim|sanitize_string',
        'customer_phone'         => 'trim|sanitize_string'
    ));

    $validated_data = $gump->run( $gump->sanitize($_POST["formData"]) );

    if( $validated_data )
    {
        $customer_car = null;
        $customer = null;

        // добавляем авто
        if( !isset($customer_car_id) )
        {
            $customer_car = new CustomerCar();
        }
        else
        {
            $customer_car = CustomerCar::retrieveByPK($customer_car_id);
        }

        $customer_car->gv_number = $validated_data["customer_car_gv_number"];
        $customer_car->mileage = $validated_data["customer_car_mileage"];
        $customer_car->name = $validated_data["customer_car_name"];
        $customer_car->vin = $validated_data["customer_car_vin"];

        try
        {
            $customer_car->save();
            $customer_car_id = $customer_car->id;
        } catch( Exception $ex )
        {
            Application::sendJson( [
                "err" => "ERROR_SAVE_TO_DATABASE"
            ]);
        }

        // добавляем заказчика
        if( !isset($customer_id) )
        {
            $customer = new Customer();
        }
        else
        {
            $customer = Customer::retrieveByPK($customer_id);
        }

        $customer->name = $validated_data["customer_name"];
        $customer->phone = $validated_data["customer_phone"];

        try
        {
            $customer->save();
            $customer_id = $customer->id;
        } catch( Exception $ex )
        {
            Application::sendJson( [
                "err" => "ERROR_SAVE_TO_DATABASE"
            ]);
        }

        // проверяем что сохранилось в базу (хуета : переделать)
        if( $customer_car_id || $customer_id )
        {
            try
            {
                $new_event = new GreaseRatEvent();

                $new_event->repair_post_id = $validated_data["repair_post_id"];
                $new_event->repair_type_id = $validated_data["repair_type_id"];
                $new_event->user_owner_id  = $user->id;
                $new_event->user_target_id = $validated_data["user_target_id"];

                $new_event->state = 0;
                $new_event->customer_id     = $customer_id;
                $new_event->customer_car_id = $customer_car_id;

                $new_event->startdatetime = $validated_data["startdatetime"];
                $new_event->enddatetime   = $validated_data["enddatetime"];

                $new_event->save();

                Application::sendJson( [ event => $new_event ] );

            } catch(Exception $ex)
            {
                Application::sendJson( [
                    "err" => "ERROR_SAVE_TO_DATABASE"
                ]);
            }
        }
        else
        {
            Application::sendJson( [
                "err" => "ERROR_SAVE_TO_DATABASE"
            ]);
        }
    }
    else
    {
        Application::sendJson( [
            "err" => "VALIDATE_FORM_ERROR",
            "data" => $gump->get_readable_errors(),
            "POST" => $_POST
        ]);
    }

    Application::sendJson( [
        "err" => "INTERNAL_ERROR"
    ]);
});

// выход из системы
Macaw::get('logout', function()
{
    if( exitUser() )
    {
        setAuthHeaders();
    }
});

// список событий
Macaw::post('events', function()
{
    $user = checkAuth();

    $utc_fix = "-2 hours";

    $startdatetime = "";
    $enddatetime   = "";

    if( isset($_POST["from"]) )
    {
        $startdatetime = $_POST["from"];
    }

    if( isset($_POST["to"]) )
    {
        $enddatetime = $_POST["to"];
    }

    $sql = "SELECT * FROM :table WHERE startdatetime >= '" . $startdatetime . "' AND enddatetime <= '" . $enddatetime . "'";
    $greaseRatEvents = GreaseRatEvent::sql($sql);

    function decorateEventName( $event )
    {
        return "Запись №: " . $event->id . " с " . $event->startdatetime . " по " . $event->enddatetime;
    }

    $eventsData = [];
    foreach( $greaseRatEvents as $event )
    {
        array_push($eventsData, array(
            'id' => $event->id,
            'title' => decorateEventName( $event ),
            'class' => 'event-important',
            'start' => strtotime($utc_fix, strtotime($event->startdatetime) ) . '000',
            'end' => strtotime($utc_fix, strtotime($event->enddatetime) ) . '000',
            'event' => $event
        ));
    }

    Application::sendJson( [
        'success' => 1,
        'result' => $eventsData
    ]);
});

// редактирование события
Macaw::post('event_actions', function()
{
    $user = checkAuth();

    if( !isset($_POST['action']) )
    {
        Application::sendJson( [
            "err" => "UNDEFINED_ACTION"
        ]);
    }

    $action = $_POST['action'];

    if( !isset($_POST['id']) )
    {
        Application::sendJson( [
            "err" => "UNDEFINED_EVENT_ID"
        ]);
    }

    $event = GreaseRatEvent::retrieveByPK(intval($_POST['id']));

    if( !$event )
    {
        Application::sendJson( [
            "err" => "UNDEFINED_EVENT"
        ]);
    }

    switch($action)
    {
        case "DELETE":
        {
            $event->delete();
            break;
        }

        case "MOVE":
        {
            if( !isset($_POST['startdatetime']) )
            {
                Application::sendJson( [
                    "err" => "UNDEFINED_START_TIME"
                ]);
            }

            if( !isset($_POST['enddatetime']) )
            {
                Application::sendJson( [
                    "err" => "UNDEFINED_END_TIME"
                ]);
            }

            $event->startdatetime = $_POST["startdatetime"];
            $event->enddatetime   = $_POST["enddatetime"];
            $event->save();
            break;
        }
        default:
        {
            Application::sendJson( [
                "err" => "UNDEFINED_ACTION"
            ]);
        }
    }

    Application::sendJson( [
        "err" => "OK"
    ]);
});

Macaw::error(function()
{
    echo '404 :: Not Found';
});


Macaw::dispatch();