"use strict";



function CalendarController()
{
	this.options = {
		language: 'ru-RU',
		events_source: '/events',
		view: 'month',
		tmpl_path: 'tmpls/',
		tmpl_cache: false,
		modal : '#event-edit',
		modal_title : "Редактирование события",
		modal_type : "template",
		classes:
		{
			months:
			{
				general: 'label'
			}
		}
	};

	this.formCreateEvent = null;
	this.formEditEvent = null;

	/**
	 * Обработчик события :
	 * @param e
	 */
	this.handleCalendarAfterEventsLoad = function( events )
	{
		if(!events)
		{
			return;
		}

		var list = $('#eventlist');

		list.html('');

		$.each(events, function(key, val)
		{
			$(document.createElement('li'))
				.html('<a href="' + val.url + '">' + val.title + '</a>')
				.appendTo(list);
		});
	};

	/**
	 * Обработчик события :
	 * @param e
	 */
	this.handleCalendarAfterViewLoad = function( view )
	{
		$('.page-header h3').text(this.getTitle());
		$('.btn-group button').removeClass('active');
		$('button[data-calendar-view="' + view + '"]').addClass('active');
	};

	this.handleExitButtonClick = function(e)
	{
		e.preventDefault();
		window.location.href = '/logout';
	};

	this.formFactory = function( $form, options )
	{
		function FormController ($form, options)
		{
			this.$form = $form;
			this.$repair_post_id = $form.find('#repair_post_id');
			this.$repair_type_id = $form.find('#repair_type_id');
			this.$user_target_name = $form.find('#user_target_name');
			this.$customer_name = $form.find('#customer_name');
			this.$customer_phone = $form.find('#customer_phone');
			this.$customer_car_vin = $form.find('#customer_car_vin');
			this.$customer_car_gv_number = $form.find('#customer_car_gv_number');
			this.$customer_car_name = $form.find('#customer_car_name');
			this.$customer_car_mileage = $form.find('#customer_car_mileage');
			this.$startdatetime = $form.find('#startdatetime');
			this.$enddatetime = $form.find('#enddatetime');
			this.$state = $form.find('#state');

			this.clear();

			this.options = options;
			this.eventData = options["eventData"] || {};

			this.firstInit = false;

			this.init();
		}

		const FORM_GROUP_STATES = {
			success : "has-success",
			warning : "has-warning",
			error : "has-error"
		};

		/**
		 * Установить состояния группы формы
		 *
		 * @param $formGroup
		 * @param state
		 */
		FormController.prototype.setFormGroupState = function( $formGroup, state )
		{
			$formGroup.removeClass('has-success');
			$formGroup.removeClass('has-warning');
			$formGroup.removeClass('has-error');

			if( state )
			{
				$formGroup.addClass(state);
			}
		};

		/**
		 * Установить input режим только для чтения
		 *
		 * @param $input
		 */
		FormController.prototype.setReadOnly = function( $input )
		{
			$input.attr('readonly');
		};

		/**
		 * Установить input режим редактирования
		 *
		 * @param $input
		 */
		FormController.prototype.setReadWrite = function( $input )
		{
			$input.removeAttr('readonly');
		};

		/**
		 * Очистить поле ввода
		 *
		 * @param $input
		 */
		FormController.prototype.resetInput = function( $input )
		{
			$input.val('');
		};

		/**
		 * Заполнить поле ввода
		 *
		 * @param $input
		 */
		FormController.prototype.setInput = function( $input, value )
		{
			$input.val(value);
		};

		/**
		 * Заполнить select по словарю
		 *
		 * @param $select
		 * @param valuesDictionary
		 */
		FormController.prototype.fillSelect = function( $select, valuesDictionary )
		{
			$select.empty();
			valuesDictionary.forEach(function(option)
			{
				$select.append('<option value="' + option.id + '">' + option.name + "</option>");
			});
		};

		/**
		 * Сброс полей заказчика
		 */
		FormController.prototype.resetCustomer = function()
		{
			this.resetInput(this.$customer_name);
			this.resetInput(this.$customer_phone);
		};

		/**
		 * Сброс полей авто заказчика
		 */
		FormController.prototype.resetCustomerCar = function()
		{
			this.resetInput(this.$customer_car_vin);
			this.resetInput(this.$customer_car_gv_number);
			this.resetInput(this.$customer_car_name);
			this.resetInput(this.$customer_car_mileage);
		};

		/**
		 * Очистить форму
		 */
		FormController.prototype.clear = function()
		{
			// очищаем форму
			this.resetCustomer();
			this.resetCustomerCar();
			this.resetInput(this.$user_target_name);
			//this.resetInput(this.$state);

			this.eventData = options["eventData"] || {};

			var $self = this;
			// очищаем все пометки об ошибках
			this.$form.find('.form-group').each(function()
			{
				$self.setFormGroupState( $(this) );
			});
		};

		/**
		 * Заполение формы данными
		 *
		 * @param event
		 * @param options
         */
		FormController.prototype.set = function(event)
		{
			var eventData = event.event;
			this.clear();

			// заполение селектов
			this.fillSelect(this.$repair_post_id, this.options['repairPost']);
			this.fillSelect(this.$repair_type_id, this.options['typeOfRepair']);

			this.eventData = {
				"customer_car_id" : eventData["customer_car_id"],
				"customer_id" : eventData["customer_id"],
				"user_target_id" : eventData["customer_id"]
			};

			this.setInput( this.$state, eventData["state"]);
			this.setInput( this.$repair_post_id, eventData["repair_post_id"] );
			this.setInput( this.$repair_type_id, eventData["repair_type_id"] );
			this.setInput( this.$enddatetime, eventData["enddatetime"] );
			this.setInput( this.$startdatetime, eventData["startdatetime"] );
			this.setInput( this.$customer_name, event.eventData["customer_id"]["name"] );
			this.setInput( this.$customer_phone, event.eventData["customer_id"]["phone"] );
			this.setInput( this.$customer_car_gv_number, event.eventData["customer_car_id"]["gv_number"] );
			this.setInput( this.$customer_car_mileage, event.eventData["customer_car_id"]["mileage"] );
			this.setInput( this.$customer_car_name, event.eventData["customer_car_id"]["name"] );
			this.setInput( this.$customer_car_vin, event.eventData["customer_car_id"]["vin"] );
			this.setInput( this.$user_target_name, event.eventData["user_target_id"]["name"] );
		};

		/**
		 * Получить данные из формы
		 */
		FormController.prototype.getFormData = function()
		{
			var formData = this.$form.serializeObject();

			// копируем ид выбраного пользователя (кому назначаем задачу)
			if( this.eventData["user_target_id"] )
			{
				formData["user_target_id"] = this.eventData["user_target_id"];
			}

			if( this.eventData["customer_id"] )
			{
				formData["customer_id"] = this.eventData["customer_id"];
			}

			if( this.eventData["customer_car_id"] )
			{
				formData["customer_car_id"] = this.eventData["customer_car_id"];
			}

			formData["startdatetime"] = this.$startdatetime.data("DateTimePicker").date().format('YYYY-MM-DD HH:mm:ss');
			formData["enddatetime"]   = this.$enddatetime.data("DateTimePicker").date().format('YYYY-MM-DD HH:mm:ss');

			return formData;
		};


		/**
		 * Показать ошибки валидации
		 *
		 * @param errors
		 */
		FormController.prototype.showErrors = function(errors)
		{
			errors.forEach(function(error)
			{
				var $field = $("#" + error.field),
					$formGroup = $field.length == 1 ? $field.bs3GetInputFormGroup() : undefined;

				if( $formGroup )
				{
					this.setFormGroupState( $formGroup, FORM_GROUP_STATES.error );
				}
			}.bind(this));
		};

		/**
		 * Проверка заполнения формы
		 */
		FormController.prototype.validateForm = function()
		{

		};

		/**
		 * Инициализация формы
		 */
		FormController.prototype.init = function()
		{
			if( !this.firstInit )
			{
				// заполение селектов
				this.fillSelect(this.$repair_post_id, this.options['repairPost']);
				this.fillSelect(this.$repair_type_id, this.options['typeOfRepair']);

				this.$startdatetime.datetimepicker({
					locale: 'ru',
					format: 'YYYY-MM-DD HH:mm:ss',
					defaultDate : Date.now()
				});

				this.$enddatetime.datetimepicker({
					locale: 'ru',
					format: 'YYYY-MM-DD HH:mm:ss',
					useCurrent: false,
					defaultDate : Date.now()
				});

				this.$startdatetime.on("dp.change", function (e) {
					this.$enddatetime.data("DateTimePicker").minDate(e.date);
				}.bind(this));

				this.$enddatetime.on("dp.change", function (e) {
					this.$startdatetime.data("DateTimePicker").maxDate(e.date);
				}.bind(this));

				var _copyTypeheadData = function(field, callback, data) {
					var _data = [];
					data.forEach(function(v)
					{
						_data.push({
							id : v.id,
							name : v[field],
							_data : v
						})
					});
					callback(_data);
				};

				// инциализация автодополнения
				this.$user_target_name.typeahead({
					source: function(query, callback)
					{
						$.ajax({
							type : "POST",
							url : '/users/name/' + query,
							success : _copyTypeheadData.bind(null, "name", callback)
						});
					},
					autoSelect : true
				});

				// обработчик выбора в поле имени
				this.$user_target_name.off('change').on('change', function() {
					var current = this.$user_target_name.typeahead("getActive");
					if (current)
					{
						if (current.name == this.$user_target_name.val())
						{
							this.setFormGroupState( this.$user_target_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.eventData["user_target_id"] = current.id;
						}
						else
						{
							this.setFormGroupState( this.$user_target_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.error );
							delete this.eventData["user_target_id"];
						}
					}
				}.bind(this));

				// инциализация автодополнения
				this.$customer_name.typeahead({
					source: function(query, callback)
					{
						$.ajax({
							type : "POST",
							url : '/customer_sources/name/' + query,
							success : _copyTypeheadData.bind(null, "name", callback)
						});
					},
					autoSelect : true
				});

				// обработчик выбора в поле имени
				this.$customer_name.off('change').on('change', function()
				{
					var current = this.$customer_name.typeahead("getActive");
					if (current)
					{
						if (current.name == this.$customer_name.val())
						{
							this.$customer_phone.val( current._data["phone"] );

							// помечаем поля
							this.setFormGroupState( this.$customer_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_phone.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.eventData["customer_id"] = current.id;
						}
						else
						{
							this.setFormGroupState( this.$customer_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.warning );
							this.setFormGroupState( this.$customer_phone.bs3GetInputFormGroup() );
							this.resetInput(this.$customer_phone);
							delete this.eventData["customer_id"];
						}
					}
				}.bind(this));

				// инциализация автодополнения
				this.$customer_car_vin.typeahead({
					source: function(query, callback)
					{
						$.ajax({
							type : "POST",
							url : '/customer_car_sources/vin/' + query,
							success : _copyTypeheadData.bind(null, "vin", callback)
						});
					},
					autoSelect : true
				});

				this.$customer_car_vin.off('change').on('change', function()
				{
					var current = this.$customer_car_vin.typeahead("getActive");
					if (current)
					{
						if (current.name == this.$customer_car_vin.val())
						{
							this.$customer_car_gv_number.val( current._data["gv_number"] );
							this.$customer_car_name.val( current._data["name"] );
							this.$customer_car_mileage.val( current._data["mileage"] );

							// помечаем поля
							this.setFormGroupState( this.$customer_car_vin.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_car_gv_number.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_car_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_car_mileage.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );

							this.eventData["customer_car_id"] = current.id;
						}
						else
						{
							this.resetInput(this.$customer_car_gv_number);
							this.resetInput(this.$customer_car_name);
							this.resetInput(this.$customer_car_mileage);

							this.setFormGroupState( this.$customer_car_vin.bs3GetInputFormGroup(), FORM_GROUP_STATES.warning );
							this.setFormGroupState( this.$customer_car_gv_number.bs3GetInputFormGroup(), FORM_GROUP_STATES.warning );
							this.setFormGroupState( this.$customer_car_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.warning );
							this.setFormGroupState( this.$customer_car_mileage.bs3GetInputFormGroup(), FORM_GROUP_STATES.warning );
							delete this.eventData["customer_car_id"];
						}
					}
				}.bind(this));

				// инциализация автодополнения
				this.$customer_car_gv_number.typeahead({
					source: function(query, callback)
					{
						$.ajax({
							type : "POST",
							url : '/customer_car_sources/gv_number/' + query,
							success : _copyTypeheadData.bind(null, "gv_number", callback)
						});
					},
					autoSelect : true
				});

				this.$customer_car_gv_number.off('change').on('change', function(){
					var current = this.$customer_car_gv_number.typeahead("getActive");
					if (current)
					{
						if (current.name == this.$customer_car_gv_number.val())
						{
							this.$customer_car_vin.val( current._data["vin"] );
							this.$customer_car_name.val( current._data["name"] );
							this.$customer_car_mileage.val( current._data["mileage"] );

							// помечаем поля
							this.setFormGroupState( this.$customer_car_vin.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_car_gv_number.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_car_name.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );
							this.setFormGroupState( this.$customer_car_mileage.bs3GetInputFormGroup(), FORM_GROUP_STATES.success );

							this.eventData["customer_car_id"] = current.id;
						}
						else
						{
							this.setFormGroupState( this.$customer_car_gv_number.closest('.form-group'), FORM_GROUP_STATES.warning );
						}
					}
					else
					{
						this.setFormGroupState( this.$customer_car_gv_number.closest('.form-group'), FORM_GROUP_STATES.warning );
					}
				}.bind(this));

				this.$customer_car_mileage.off('change').on('change', function()
				{
					this.setFormGroupState( this.$customer_car_mileage.closest('.form-group'), FORM_GROUP_STATES.warning );

					this.eventData["customer_car_invalidate"] = true;
				}.bind(this));

				this.$customer_car_name.off('change').on('change', function()
				{
					this.setFormGroupState( this.$customer_car_name.closest('.form-group'), FORM_GROUP_STATES.warning );

					this.eventData["customer_car_invalidate"] = true;
				}.bind(this));

				this.$customer_car_mileage.ForceNumericOnly();

				this.firstInit = true;
			}
		};

		return new FormController( $form, options );
	};

	var self = this;

	this.handleCalendarAfterModalHidden = function()
	{
		delete self.formEditEvent;
	};

	this.handleCalendarAfterModalShown = function( events ) {

		var $modal = this.$modal,
			$form = $modal.find('form'),
			$removeBtn = $modal.find('.btn-remove'),
			$changeBtn = $modal.find('.btn-change'),
			_id = $modal.data('handled.event-id');

		if( !self.formEditEvent )
		{
			self.formEditEvent = self.formFactory($form, {
				"repairPost" : [
					{
						"id" : 0,
						"name" : "Бокс электрик"
					},
					{
						"id" : 1,
						"name" : "Бокс электрик1"
					},
					{
						"id" : 2,
						"name" : "Бокс электрик2"
					},
					{
						"id" : 3,
						"name" : "Бокс электрик3"
					}
				],
				"typeOfRepair" : [
					{
						"id" : 0,
						"name" : "Замена колес"
					},
					{
						"id" : 1,
						"name" : "Диагностика подвески"
					},
					{
						"id" : 2,
						"name" : "3D развал-схождение"
					},
					{
						"id" : 3,
						"name" : "Очистка инжектора"
					}
				]
			});

			$removeBtn.off('click').on('click', function(e)
			{
				e.preventDefault();

				const SERVER_URL = '/event_actions';

				$.ajax({
					type : "POST",
					url : SERVER_URL,
					data : {
						"action" : "DELETE",
						"id" : _id
					},
					success : function(data)
					{
						if( data["err"] == "OK" )
						{
							this.view();
							$modal.modal('hide');
						}
					}.bind(this)
				});

			}.bind(this));

			$changeBtn.off('click').on('click', function(e)
			{
				e.preventDefault();

				const SERVER_URL = '/event_actions';

				$.ajax({
					type : "POST",
					url : SERVER_URL,
					data : {
						"action" : "MOVE",
						"id" : _id,
						"data" : self.formEditEvent.getFormData()
					},
					success : function(data)
					{
						if( data["err"] == "OK" )
						{
							this.view();
							$modal.modal('hide');
						}
					}.bind(this)
				});
			}.bind(this));
		}

		events.forEach(function(event)
		{
			if( event.id == _id )
			{
				self.formEditEvent.set(event);
			}
		});
	};

	/**
	 * Обработчик события : показ формы
	 * @param e
	 */
	this.handleShowEventForm = function(e)
	{
		var $modal = $(e.target),
			$form = $modal.find('form'),
			$saveBtn = $modal.find('#sendBtn');

		const SERVER_URL = '/create_event';

		if( !this.formCreateEvent )
		{
			this.formCreateEvent = this.formFactory($form, {
				"repairPost" : [
					{
						"id" : 0,
						"name" : "Бокс электрик"
					},
					{
						"id" : 1,
						"name" : "Бокс электрик1"
					},
					{
						"id" : 2,
						"name" : "Бокс электрик2"
					},
					{
						"id" : 3,
						"name" : "Бокс электрик3"
					}
				],

				"typeOfRepair" : [
					{
						"id" : 0,
						"name" : "Замена колес"
					},
					{
						"id" : 1,
						"name" : "Диагностика подвески"
					},
					{
						"id" : 2,
						"name" : "3D развал-схождение"
					},
					{
						"id" : 3,
						"name" : "Очистка инжектора"
					}
				]
			});

			// переопределение обработчика нажатия на кнопке отправить
			$saveBtn.off('click').on('click', function(e)
			{
				// отмена обработки события формы по умолчанию (чтобы не отправлялась браузером)
				e.preventDefault();

				// посылаем пост запрос на сервер
				$.ajax({
					type : "POST",
					url : SERVER_URL,
					data : this.formCreateEvent.getFormData(),
					success : function(response) {
						if( response["err"] )
						{
							$.notify({
								// options
								message: 'Ошибка при добавлении события: ' + response["err"]
							},{
								// settings
								type: 'danger'
							});

							if( response["errors"] )
							{
								this.formCreateEvent.showErrors(response["errors"]);
							}
						}
						else
						{
							$.notify({
								// options
								message: 'Событие успешно добавлено'
							},{
								// settings
								type: 'info'
							});

							this.calendar.view();
							$modal.modal('hide');
						}
						//this.calendar.view();
					}.bind(this)
				});
			}.bind(this));
		}

		this.formCreateEvent.clear();
	};

	this.init = function()
	{
		this.currentDate = new Date();

		var month = this.currentDate.getMonthFormatted();
		var year  = this.currentDate.getFullYear();
		var day   = this.currentDate.getDate();

		var _options =
		{
			day: year+ "-" +month+ "-" +day,
			onAfterEventsLoad: this.handleCalendarAfterEventsLoad,
			onAfterViewLoad: this.handleCalendarAfterViewLoad,
			onAfterModalShown: this.handleCalendarAfterModalShown,
			onAfterModalHidden: this.handleCalendarAfterModalHidden

		};

		this.options = $.extend(this.options, _options);
		this.calendar = $('#calendar').calendar(this.options);

		$('.btn-group button[data-calendar-nav]').off('click').on('click',function(e)
		{
			var $btn = $(e.target);
			this.calendar.navigate($btn.data('calendar-nav'));
		}.bind(this));


		$('.btn-group button[data-calendar-view]').off('click').on('click',function(e)
		{
			var $btn = $(e.target);
			this.calendar.view($btn.data('calendar-view'));
		}.bind(this));

		$('#first_day').change(function()
		{
			var value = $(this).val();
			value = value.length ? parseInt(value) : null;
			this.calendar.setOptions({first_day: value});
			this.calendar.view();
		}.bind(this));

		$('#events-in-modal').change(function()
		{
			var val = $(this).is(':checked') ? $(this).val() : null;
			this.calendar.setOptions({modal: val});
		}.bind(this));

		$('#format-12-hours').change(function()
		{
			var val = $(this).is(':checked') ? true : false;
			this.calendar.setOptions({format12: val});
			this.calendar.view();
		}.bind(this));

		$('#show_wbn').change(function()
		{
			var val = $(this).is(':checked') ? true : false;
			this.calendar.setOptions({display_week_numbers: val});
			this.calendar.view();
		}.bind(this));

		$('#show_wb').change(function()
		{
			var val = $(this).is(':checked') ? true : false;
			this.calendar.setOptions({weekbox: val});
			this.calendar.view();
		}.bind(this));

		$('#createEvent').off('show.bs.modal').on('show.bs.modal', this.handleShowEventForm.bind(this));
		$('.btn-exit').off('click').on('click', this.handleExitButtonClick.bind(this));
	};

	this.loadStatic = function( callback )
	{
		$.getJSON('api/static.json', function(data)
		{
			this.staticData = data;
			callback( this.staticData );
		}.bind(this));
	};
}

CalendarController.prototype.initialize = function()
{
	this.loadStatic(function()
	{
		this.init();
	}.bind(this));
};


$( document ).ready(function()
{
	var _calendarInstance = new CalendarController();
	_calendarInstance.initialize();
});

