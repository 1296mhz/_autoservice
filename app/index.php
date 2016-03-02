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

Macaw::get('/sign', function()
{
    $user = getUser();
    if( $user )
    {
        redirect("/");
    }
    else
    {
        Application::sendHTMLString( Application::template(dirname(__FILE__) . "/templates/signin.html", []));
    }
});

Macaw::post('/sign', function()
{
    $user = getUser();

    if( $user )
    {
        redirect("/");
    }
    else
    {
        $gump = new GUMP();
        $data = $gump->sanitize($_POST);

        $gump->validation_rules(array(
            'password' => 'required',
            'username' => 'required'
        ));

        $validated_data = $gump->run( $data );

        if( $validated_data && authUser( $validated_data['username'], $validated_data['password'] ) )
        {
            redirect("/");
        }
        else
        {
            redirectToLogin();
            //authUser( $validated_data['username'], $validated_data['password'] );
        }
    }
});


// выход из системы
Macaw::get('logout', function()
{
    if( exitUser() )
    {
        redirectToLogin();
    }
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

function processForm( $data, $user )
{
    $gump = new GUMP();
    $data = $gump->sanitize($data);

    $gump->validation_rules(array(
        'user_target_name' => 'required',
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
        'customer_phone' => 'required',
        'customer_id' => 'integer',
        'customer_car_id' => 'integer',
        'id' => 'integer',
        'state' => 'required|integer'
    ));

    $gump->filter_rules(array(
        'user_target_name'       => 'trim|sanitize_string',
        'customer_car_gv_number' => 'trim|sanitize_string',
        'customer_car_name'      => 'trim|sanitize_string',
        'customer_car_vin'       => 'trim|sanitize_string',
        'customer_name'          => 'trim|sanitize_string',
        'customer_phone'         => 'trim|sanitize_string'
    ));

    $customer_car_id = null;
    $customer_id = null;

    $validated_data = $gump->run( $data );

    if( $validated_data )
    {
        $customer_car = null;
        $customer = null;

        // добавляем авто
        if( !isset($validated_data['customer_car_id']) )
        {
            $customer_car = new CustomerCar();
        }
        else
        {
            $customer_car = CustomerCar::retrieveByPK($validated_data['customer_car_id']);
        }

        $customer_car->gv_number = $validated_data["customer_car_gv_number"];
        $customer_car->mileage = $validated_data["customer_car_mileage"];
        $customer_car->name = $validated_data["customer_car_name"];
        $customer_car->vin = $validated_data["customer_car_vin"];

        try
        {
            $customer_car->save();
            $customer_car_id = $customer_car->id;

            Log::toDebug(["Save CustomerCar", $customer_car_id]);

        } catch( Exception $ex )
        {
            Log::toDebug("ERROR_SAVE_TO_DATABASE");

            return [
                "err" => "ERROR_SAVE_TO_DATABASE"
            ];
        }

        // добавляем заказчика
        if( !isset($validated_data['customer_id']) )
        {
            $customer = new Customer();
        }
        else
        {
            $customer = Customer::retrieveByPK($validated_data['customer_id']);
        }

        $customer->name = $validated_data["customer_name"];
        $customer->phone = $validated_data["customer_phone"];

        try
        {
            $customer->save();
            $customer_id = $customer->id;

            Log::toDebug(["Save CustomerCar", $customer_id]);
        } catch( Exception $ex )
        {
            return [
                "err" => "ERROR_SAVE_TO_DATABASE"
            ];
        }

        try
        {
            if( !isset($validated_data['id']) )
            {
                $new_event = new GreaseRatEvent();
            }
            else
            {
                $new_event = GreaseRatEvent::retrieveByPK($validated_data['id']);
            }

            $new_event->repair_post_id  = $validated_data["repair_post_id"];
            $new_event->repair_type_id  = $validated_data["repair_type_id"];

            if( isset($user) ) $new_event->user_owner_id = $user->id;

            $new_event->user_target_id  = $validated_data["user_target_id"];
            $new_event->state           = $validated_data["state"];
            $new_event->customer_id     = $customer_id;
            $new_event->customer_car_id = $customer_car_id;
            $new_event->startdatetime   = $validated_data["startdatetime"];
            $new_event->enddatetime     = $validated_data["enddatetime"];

            $new_event->save();

            Log::toDebug(["Save rat event", $new_event->id]);

            return [ 'event' => $new_event ];
        } catch(Exception $ex)
        {
            return [
                "err" => "ERROR_SAVE_TO_DATABASE"
            ];
        }
    }
    else
    {
        return [
            "err" => "VALIDATE_FORM_ERROR",
            "errors" => $gump->errors()
        ];
    }
}

// создание события
Macaw::post('/create_event', function()
{
    Log::toDebug("CREATE EVENT ROUTE");

    $user = checkAuth();
    Application::sendJson( processForm($_POST, $user) );
});

// вспомогательные данные
Macaw::get('source', function()
{
    Log::toDebug("source");

    $user = checkAuth();

    Application::sendJson([
        "repair_post" => RepairPost::all(),
        "repair_type" => RepairType::all(),
        "state" => [
            [ "id" => 0, "name" => "Назначено" ],
            [ "id" => 1, "name" => "Выполнено" ],
            [ "id" => 2, "name" => "Отклонено" ]
        ]
    ]);
});

function PopulateEvent( $event )
{
    return [
        "user_owner_id" => User::retrieveByPK( $event->user_owner_id ),
        "user_target_id" => User::retrieveByPK( $event->user_target_id ),
        "customer_id" => Customer::retrieveByPK( $event->customer_id ),
        "customer_car_id" => CustomerCar::retrieveByPK( $event->customer_car_id )
    ];
}


function buildQueryAndEqStatement( $name, $value, $op = "=", $escape = false )
{
    if( $escape )
    {
        return " AND {$name}{$op}'{$value}' ";
    }

    return " AND {$name}{$op}{$value} ";
}

// список событий
Macaw::post('events', function()
{
    $user = checkAuth();

    $utc_fix = "-2 hours";

    $startdatetime = "";
    $enddatetime   = "";

    //$user_owner_id  = isset($_POST["user_owner_id"]);

    $repair_post_id = isset($_POST["repair_post_id"]) ? intval($_POST["repair_post_id"]) : null;
    $repair_type_id = isset($_POST["repair_type_id"]) ? intval($_POST["repair_type_id"]) : null;
    $user_target_id = isset($_POST["user_target_id"]) ? intval($_POST["user_target_id"]) : null;
    $state          = isset($_POST["state"]) ? intval($_POST["state"]) : null;

    if( isset($_POST["from"]) )
    {
        $startdatetime = $_POST["from"];
    }

    if( isset($_POST["to"]) )
    {
        $enddatetime = $_POST["to"];
    }

    Log::toDebug(print_r($_POST, true));

    $sql  = "SELECT * FROM :table WHERE 1";
    $sql .= buildQueryAndEqStatement("startdatetime", $startdatetime, ">=", true);
    $sql .= buildQueryAndEqStatement("enddatetime", $enddatetime, "<=", true);

    if( $repair_post_id != null )
    {
        $sql .= buildQueryAndEqStatement("repair_post_id", $repair_post_id, "=", false);
    }

    if( $repair_type_id != null )
    {
        $sql .= buildQueryAndEqStatement("repair_type_id", $repair_type_id, "=", false);
    }

    if( $user_target_id != null )
    {
        $sql .= buildQueryAndEqStatement("user_target_id", $user_target_id, "=", false);
    }

    if( $state != null )
    {
        $sql .= buildQueryAndEqStatement("state", $state, "=", false);
    }

    Log::toDebug($sql);

    $greaseRatEvents = GreaseRatEvent::sql($sql);

    function decorateEventName( $event, $eventData )
    {
        return "Запись №: " . $event->id . " " . $eventData["customer_car_id"]->name . " " . $eventData["customer_id"]->name;
    }

    $eventsData = [];
    foreach( $greaseRatEvents as $event )
    {
        $eventData = PopulateEvent($event);

        array_push($eventsData, array(
            'id' => $event->id,
            'title' => decorateEventName( $event, $eventData ),
            'class' => 'event-important',
            'start' => strtotime($utc_fix, strtotime($event->startdatetime) ) . '000',
            'end' => strtotime($utc_fix, strtotime($event->enddatetime) ) . '000',
            'event' => $event,
            'eventData' => $eventData
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

            Application::sendJson([
                "err" => "OK"
            ]);
            break;
        }

        case "MOVE":
        {
            if( !isset($_POST["data"]) )
            {
                Application::sendJson( [
                    "err" => "UNDEFINED_FORM_DATA"
                ]);
            }

            $_POST["data"]["id"] = intval($_POST['id']);

            Application::sendJson( processForm($_POST["data"]) );
            break;
        }

        default:
        {
            Application::sendJson( [
                "err" => "UNDEFINED_ACTION"
            ]);
            break;
        }
    }

});

Macaw::error(function()
{
    echo '404 :: Not Found';
});


Macaw::dispatch();