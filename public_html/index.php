<?php
include( dirname(__FILE__) . "/../app/__init.php" );
include( dirname(__FILE__) . "/../app/auth.php" );

$user = checkAuth();
?>

<!DOCTYPE html>
<html>
<head>
    <title> Calendar component</title>
    <meta name="description" content="Full view calendar component for twitter bootstrap with year, month, week, day views.">
    <meta name="keywords" content="jQuery,Bootstrap,Calendar,HTML,CSS,JavaScript,responsive,month,week,year,day">
    <meta name="author" content="">
    <meta charset="UTF-8">

    <link rel="stylesheet" href="components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="components/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/calendar.css">
    <link rel="stylesheet" href="css/dashboard.css">

    <script type="text/javascript" src="components/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="components/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="components/moment/locale/ru.js"></script>
    <script type="text/javascript" src="components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="components/jstimezonedetect/jstz.js"></script>
    <script type="text/javascript" src="components/jquery-validation/dist/jquery.validate.min.js"></script>

    <script type="text/javascript" src="js/language/ru-RU.js"></script>
    <script type="text/javascript" src="js/calendar.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
</head>
<body>
<div class="container">
    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Автосервис</a>
        </div>
        <button class="btn btn-success navbar-btn" data-toggle="modal" data-target="#createEvent">Создать</button>
        <button class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#listEvents">Список событий</button>
        <button class="btn btn-warning navbar-btn" data-toggle="modal" data-target="#report">Отчет</button>
        <button class="btn btn-danger navbar-btn btn-exit">Exit</button>
        <p class="navbar-text navbar-right">Привет: <a href="#" class="navbar-link"><?php echo $user->name; ?></a></p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12 page-header">
            <div class="pull-right form-inline">
                <div class="btn-group">
                    <button class="btn btn-primary" data-calendar-nav="prev"><< Назад</button>
                    <button class="btn" data-calendar-nav="today">Сегодня</button>
                    <button class="btn btn-primary" data-calendar-nav="next">Вперед >></button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-warning" data-calendar-view="year">Год</button>
                    <button class="btn btn-warning active" data-calendar-view="month">Месяц</button>
                    <button class="btn btn-warning" data-calendar-view="week">Неделя</button>
                    <button class="btn btn-warning" data-calendar-view="day">День</button>
                </div>
            </div>
            <h3></h3>
            <small>Рабочий период</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="calendar"></div>
        </div>
    </div>
</div>


<div class="modal fade" id="event-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Редактирование события</h3>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger btn-remove">Удалить</a>
                <a href="#" class="btn btn-warning btn-change">Изменить</a>
                <a href="#" data-dismiss="modal" class="btn btn-primary">Закрыть</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create-->
<div class="modal fade" id="createEvent">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="createEventLabel">Создать событие</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal " id="createEventForm">

                    <!-- Ремонтный пост-->
                    <div class="form-group">
                        <label for="repairPost" class="col-sm-4 control-label">Ремонтный пост</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="repairPost" name="repairPost" required="required"></select>
                        </div>
                    </div>

                    <!-- Заказчик-->
                    <div class="form-group">
                        <label for="customer" class="col-sm-4 control-label">Заказчик</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input type="text" class="form-control" name="customer" id="customer" placeholder="ФИО" required="required">
                            </div>
                            <span class="glyphicon form-control-feedback"></span>
                        </div>
                    </div>

                    <!-- Вид ремонта-->
                    <div class="form-group">
                        <label for="typeOfRepair" class="col-sm-4 control-label">Вид ремонта</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="typeOfRepair" name="typeOfRepair" required="required"></select>
                        </div>
                    </div>

                    <!-- Транспортное средство-->
                    <div class="form-group">
                        <label for="avtoModel" class="col-sm-4 control-label">Транспортное средство</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="avtoModel" name="avtoModel" required="required"></select>
                        </div>
                    </div>

                    <!-- Пробег-->
                    <div class="form-group">
                        <label for="mileage" class="col-sm-4 control-label">Пробег</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mileage" name="mileage" placeholder="км">
                        </div>
                    </div>

                    <!-- Гос номер-->
                    <div class="form-group">
                        <label for="gosNumber" class="col-sm-4 control-label">Государственный номер</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="gosNumber" name="gosNumber" placeholder="">
                        </div>
                    </div>

                    <!-- VIN-->
                    <div class="form-group">
                        <label for="vin" class="col-sm-4 control-label">VIN</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="vin" name="vin" placeholder="">
                        </div>
                    </div>

                    <!-- Начало в-->
                    <div class="form-group">
                        <label for="startdatetime" class="col-sm-4 control-label">Начало в:</label>
                        <div class='input-group date col-sm-8'>
                            <input type='text' class="form-control" id="startdatetime" name="startdatetime" required="required" />
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Окончание в-->
                    <div class="form-group">
                        <label for="enddatetime" class="col-sm-4 control-label">Окончание в:</label>
                        <div class='input-group date col-sm-8'>
                            <input type='text' class="form-control" id="enddatetime" name="enddatetime" required="required"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="submit" name="sendBtn" id="sendBtn" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal List Events-->
<div class="modal fade" id="listEvents" tabindex="-1" role="dialog" aria-labelledby="listEventsLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="listEventsLabel">Список событий за текущий период</h4>
            </div>
            <div class="modal-body">
                <div id="eventlist">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>