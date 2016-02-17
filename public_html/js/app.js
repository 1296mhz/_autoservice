"use strict";

(function ( $ ) {

	$.fn.bs3FormGroupSetError = function( state )
	{
		this.removeClass("has-success");
		this.removeClass("has-warning");
		this.removeClass("has-error");

		if( state )
		{
			this.addClass(state);
		}

		return this;
	};

	$.fn.bs3GetInputFormGroup = function()
	{
		return this.closest('.form-group');
	};

}( jQuery ));


function CalendarController()
{
	this.options = {
		language: 'ru-RU',
		events_source: 'api/events.php',
		view: 'month',
		tmpl_path: 'tmpls/',
		tmpl_cache: false,
		classes:
		{
			months:
			{
				general: 'label'
			}
		}
	};

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

	/**
	 * Обработчик события : показ формы
	 * @param e
	 */
	this.handleShowEventForm = function(e)
	{
		const SERVER_URL = 'api/dataparser.php';

		var $modal = $(e.target),
			$form = $modal.find('form'),
			$saveBtn = $modal.find('#sendBtn'),
			$startWorkInput = $form.find('#startdatetime'),
			$endWorkInput = $form.find('#enddatetime'),
			$repairPostSelect = $form.find('#repairPost'),
			$typeOfRepairSelect = $form.find('#typeOfRepair'),
			$avtoModelSelect = $form.find('#avtoModel');

		// очищаем все пометки об ошибках
		$form.find('.form-group').each(function()
		{
			$(this).bs3FormGroupSetError();
		});

		/**
		 * Заполнить селект-бокс из словаря
		 * @param $select
		 * @param valuesDictionary
		 * @private
		 */
		var _fillSelect = function( $select, valuesDictionary )
		{
			$select.empty();

			valuesDictionary.forEach(function(option)
			{
				$select.append('<option value="' + option.id + '">' + option.name + "</option>");
			});
		}.bind(this);

		// настройка плагина с выбором дат
		if( $startWorkInput.data('datetimepicker') == undefined )
		{
			$startWorkInput.datetimepicker({
				locale: 'ru',
				format: 'YYYY-MM-DD HH:mm'
			});
		}

		// настройка плагина с выбором дат
		if( $endWorkInput.data('datetimepicker') == undefined )
		{
			$endWorkInput.datetimepicker({
				locale: 'ru',
				format: 'YYYY-MM-DD HH:mm'
			});
		}

		// заполение селектов
		_fillSelect($repairPostSelect, this.staticData['repairPost']);
		_fillSelect($typeOfRepairSelect, this.staticData['typeOfRepair']);
		_fillSelect($avtoModelSelect, this.staticData['avtoModel']);

		/**
		 * Обработчит ответа от сервера
		 * @param response
		 * @private
		 */
		var _handleFormDataSubmit = function(response)
		{
			if( response["err"] )
			{
				response["data"].forEach(function(field)
				{
					var $formField = $form.find("#" + field);
        			if( $formField.length > 0 )
					{
						$formField.bs3GetInputFormGroup().bs3FormGroupSetError("has-error");
					}
				});
			}
			else
			{
				alert("Событие создано!");

				this.calendar.view();

				$modal.modal('hide');
			}
		}.bind(this);

		/**
		 *  Отправка формы
		 * @type {function(this:CalendarController)}
		 * @private
		 */
		var _handleSubmitForm = function(e)
		{
			var $form = $(e.target),
				formData = $form.serialize();

			// отмена обработки события формы по умолчанию (чтобы не отправлялась браузером)
			e.preventDefault();

			// посылаем пост запрос на сервер
			$.ajax({
				type : "POST",
				url : SERVER_URL,
				data : formData,
				success : _handleFormDataSubmit.bind(this)
			});

		}.bind(this);

		// переопределение обработчика отправки формы
		$form.off('submit').on('submit', _handleSubmitForm);

		// переопределение обработчика нажатия на кнопке отправить
		$saveBtn.off('click').on('click', function(e)
		{
			$form.submit();
		});
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
			onAfterViewLoad: this.handleCalendarAfterViewLoad
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

