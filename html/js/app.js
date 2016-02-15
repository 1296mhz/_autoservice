"use strict";

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

	this.handleCalendarAfterEventsLoad = function( events )
	{
		if(!events)
		{
			return;
		}

		var list = $('#eventlist');
		list.html('');
		$.each(events, function(key, val) {
			$(document.createElement('li'))
				.html('<a href="' + val.url + '">' + val.title + '</a>')
				.appendTo(list);
		});
	};

	this.handleCalendarAfterViewLoad = function( view )
	{
		$('.page-header h3').text(this.getTitle());
		$('.btn-group button').removeClass('active');
		$('button[data-calendar-view="' + view + '"]').addClass('active');
	};

	this.handleShowEventForm = function(e)
	{
		const SERVER_URL = '/api/dataparser.php';

		var $modal = $(e.target),
			$form = $modal.find('form'),
			$saveBtn = $modal.find('#sendBtn'),
			$startWorkInput = $form.find('#startdatetime'),
			$endWorkInput = $form.find('#enddatetime'),
			$repairPostSelect = $form.find('#repairPost'),
			$typeOfRepairSelect = $form.find('#typeOfRepair'),
			$avtoModelSelect = $form.find('#avtoModel');

		var _fillSelect = function( $select, valuesDictionary )
		{
			valuesDictionary.forEach(function(option)
			{
				$select.append('<option value="' + option.id + '">' + option.name + "</option>");
			});
		};

		if( $startWorkInput.data('datetimepicker') == undefined )
		{
			console.log('create datetimepicker');

			$startWorkInput.datetimepicker({
				locale: 'ru',
				format: 'YYYY-MM-DD HH:mm'
			});
		}

		if( $endWorkInput.data('datetimepicker') == undefined )
		{
			console.log('create datetimepicker');

			$endWorkInput.datetimepicker({
				locale: 'ru',
				format: 'YYYY-MM-DD HH:mm'
			});
		}

		_fillSelect($repairPostSelect, this.staticData['repairPost']);
		_fillSelect($typeOfRepairSelect, this.staticData['typeOfRepair']);
		_fillSelect($avtoModelSelect, this.staticData['avtoModel']);


		var _handleFormDataSubmit = function(data)
		{
			console.log(data)
		};

		var _submitForm = function(data)
		{
			$.ajax({
				type : "POST",
				url : SERVER_URL,
				data : data,
				success : _handleFormDataSubmit.bind(this)
			});
		}.bind(this);

		var _handleSubmitForm = function(e)
		{
			var $form = $(e.target),
				formData = $form.serialize()/*,
				validatedata = $form.validator('validate')*/;

			e.preventDefault();

			_submitForm(formData);

		}.bind(this);

		if( $form.data('validator') == undefined )
		{
			$form.validator();
		}

		$form.off('submit').on('submit', _handleSubmitForm);

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


		$('.btn-group button[data-calendar-nav]').each(function()
		{
			var $this = $(this);
			$this.click(function()
			{
				calendar.navigate($this.data('calendar-nav'));
			});
		});

		$('.btn-group button[data-calendar-view]').each(function()
		{
			var $this = $(this);
			$this.click(function()
			{
				calendar.view($this.data('calendar-view'));
			});
		});

		$('#first_day').change(function()
		{
			var value = $(this).val();
			value = value.length ? parseInt(value) : null;
			calendar.setOptions({first_day: value});
			calendar.view();
		});

		$('#events-in-modal').change(function()
		{
			var val = $(this).is(':checked') ? $(this).val() : null;
			calendar.setOptions({modal: val});
		});

		$('#format-12-hours').change(function()
		{
			var val = $(this).is(':checked') ? true : false;
			calendar.setOptions({format12: val});
			calendar.view();
		});

		$('#show_wbn').change(function()
		{
			var val = $(this).is(':checked') ? true : false;
			calendar.setOptions({display_week_numbers: val});
			calendar.view();
		});

		$('#show_wb').change(function()
		{
			var val = $(this).is(':checked') ? true : false;
			calendar.setOptions({weekbox: val});
			calendar.view();
		});


		$('#createEvent').off('show.bs.modal').on('show.bs.modal', this.handleShowEventForm.bind(this));


/*
		$("#sendBtn").click(function()
		{
			var formData = {
				"repairPost":$("#repairPost").val()
				, "costumer":$("#costumer").val()
				, "typeOfRepair":$("#typeOfRepair").val()
				, "avtoModel":$("#avtoModel").val()
				, "mileage":$("#mileage").val()
				, "vin":$("#vin").val()
				, "startdatetime":$("#startdatetime").val()
				, "enddatetime":$("#enddatetime").val()

			};
			$.ajax({
				url:'api/dataparser.php'
				, type:'POST'
				, data:'jsonData=' + $.toJSON(formData)
				//, success: function(res) {
				//	alert(res);
				//}
			});
			return false;
		});
*/
	};

	this.loadStatic = function( callback )
	{
		$.getJSON('/api/static.json', function(data)
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