/*
* jQuery timepicker addon
* By: Trent Richardson [http://trentrichardson.com]
* Version 0.6.1
* Last Modified: 9/20/2010
*
* Copyright 2010 Trent Richardson
* Dual licensed under the MIT and GPL licenses.
* http://trentrichardson.com/Impromptu/GPL-LICENSE.txt
* http://trentrichardson.com/Impromptu/MIT-LICENSE.txt
*
* HERES THE CSS:
* #ui-timepicker-div dl{ text-align: left; }
* #ui-timepicker-div dl dt{ height: 25px; }
* #ui-timepicker-div dl dd{ margin: -25px 0 10px 65px; }
*/

(function(jQuery) {
	function Timepicker(singleton) {
		if(typeof(singleton) === 'boolean' && singleton == true) {
			this.regional = []; // Available regional settings, indexed by language code
			this.regional[''] = { // Default regional settings
				currentText: 'Now',
				ampm: false,
				timeFormat: 'hh:mm tt',
				timeOnlyTitle: 'Choose Time',
				timeText: 'Time',
				hourText: 'Hour',
				minuteText: 'Minute',
				secondText: 'Second'
			};
			this.defaults = { // Global defaults for all the datetime picker instances
				holdDatepickerOpen: true,
				showButtonPanel: true,
				timeOnly: false,
				showHour: true,
				showMinute: true,
				showSecond: false,
				showTime: true,
				stepHour: 0.05,
				stepMinute: 0.05,
				stepSecond: 0.05,
				hour: 0,
				minute: 0,
				second: 0,
				hourMin: 0,
				minuteMin: 0,
				secondMin: 0,
				hourMax: 23,
				minuteMax: 59,
				secondMax: 59,
				alwaysSetTime: true,
        timeText: 'Time',
        hourText: 'Hour',
        minuteText: 'Minute',
        secondText: 'Second'
			};
			jQuery.extend(this.defaults, this.regional['']);
		} else {
			this.defaults = jQuery.extend({}, jQuery.timepicker.defaults);
		}

	}

	Timepicker.prototype = {
		$input: null,
		$timeObj: null,
		inst: null,
		hour_slider: null,
		minute_slider: null,
		second_slider: null,
		hour: 0,
		minute: 0,
		second: 0,
		ampm: '',
		formattedDate: '',
		formattedTime: '',
		formattedDateTime: '',

		//########################################################################
		// add our sliders to the calendar
		//########################################################################
		addTimePicker: function(dp_inst) {
			var tp_inst = this;
			var currDT = this.$input.val();
			var regstr = this.defaults.timeFormat.toString()
				.replace(/h{1,2}/ig, '(\\d?\\d)')
				.replace(/m{1,2}/ig, '(\\d?\\d)')
				.replace(/s{1,2}/ig, '(\\d?\\d)')
				.replace(/t{1,2}/ig, '(am|pm|a|p)?')
				.replace(/\s/g, '\\s?') + '$';

			if (!this.defaults.timeOnly) {
				//the time should come after x number of characters and a space.  x = at least the length of text specified by the date format
				regstr = '.{' + this.defaults.dateFormat.length + ',}\\s+' + regstr;
			}

			var order = this.getFormatPositions();
			var treg = currDT.match(new RegExp(regstr, 'i'));

			if (treg) {
				if (order.t !== -1) {
					this.ampm = ((treg[order.t] === undefined || treg[order.t].length === 0) ? '' : (treg[order.t].charAt(0).toUpperCase() == 'A') ? 'AM' : 'PM').toUpperCase();
				}

				if (order.h !== -1) {
					if (this.ampm == 'AM' && treg[order.h] == '12') {
						// 12am = 0 hour
						this.hour = 0;
					} else if (this.ampm == 'PM' && treg[order.h] != '12') {
						// 12pm = 12 hour, any other pm = hour + 12
						this.hour = (parseFloat(treg[order.h]) + 12).toFixed(0);
					} else {
						this.hour = treg[order.h];
					}
				}

				if (order.m !== -1) {
					this.minute = treg[order.m];
				}

				if (order.s !== -1) {
					this.second = treg[order.s];
				}
			}

			tp_inst.timeDefined = (treg) ? true : false;

			if (typeof(dp_inst.stay_open) !== 'boolean' || dp_inst.stay_open === false) {
			// wait for datepicker to create itself.. 60% of the time it works every time..
        setTimeout(function() {
          tp_inst.injectTimePicker(dp_inst, tp_inst);
        }, 10);
      } else {
        tp_inst.injectTimePicker(dp_inst, tp_inst);
      }

		},

		//########################################################################
		// figure out position of time elements.. cause js cant do named captures
		//########################################################################
		getFormatPositions: function() {
			var finds = this.defaults.timeFormat.toLowerCase().match(/(h{1,2}|m{1,2}|s{1,2}|t{1,2})/g);
			var orders = { h: -1, m: -1, s: -1, t: -1 };

			if (finds) {
				for (var i = 0; i < finds.length; i++) {
					if (orders[finds[i].toString().charAt(0)] == -1) {
						orders[finds[i].toString().charAt(0)] = i + 1;
					}
				}
			}

			return orders;
		},

		//########################################################################
		// generate and inject html for timepicker into ui datepicker
		//########################################################################
		injectTimePicker: function(dp_inst, tp_inst) {
			var $dp = jQuery('#' + jQuery.datepicker._mainDivId);
			var opts = tp_inst.defaults;

			// Added by Peter Medeiros:
			// - Figure out what the hour/minute/second max should be based on the step values.
			// - Example: if stepMinute is 15, then minMax is 45.
			var hourMax = opts.hourMax - (opts.hourMax % opts.stepHour);
			var minMax  = opts.minuteMax - (opts.minuteMax % opts.stepMinute);
			var secMax  = opts.secondMax - (opts.secondMax % opts.stepSecond);

			// Prevent displaying twice
			if ($dp.find("div#ui-timepicker-div").length === 0) {
				var noDisplay = ' style="display:none;"';
				var html =
					'<div id="ui-timepicker-div"><dl>' +
						'<dt id="ui_tpicker_time_label"'   + ((opts.showTime)   ? '' : noDisplay) + '>'+ opts.timeText +'</dt>' +
						'<dd id="ui_tpicker_time"'         + ((opts.showTime)   ? '' : noDisplay) + '></dd>' +
						'<dt id="ui_tpicker_hour_label"'   + ((opts.showHour)   ? '' : noDisplay) + '>'+ opts.hourText +'</dt>' +
						'<dd id="ui_tpicker_hour"'         + ((opts.showHour)   ? '' : noDisplay) + '></dd>' +
						'<dt id="ui_tpicker_minute_label"' + ((opts.showMinute) ? '' : noDisplay) + '>'+ opts.minuteText +'</dt>' +
						'<dd id="ui_tpicker_minute"'       + ((opts.showMinute) ? '' : noDisplay) + '></dd>' +
						'<dt id="ui_tpicker_second_label"' + ((opts.showSecond) ? '' : noDisplay) + '>'+ opts.secondText +'</dt>' +
						'<dd id="ui_tpicker_second"'       + ((opts.showSecond) ? '' : noDisplay) + '></dd>' +
					'</dl></div>';
				$tp = jQuery(html);

				// if we only want time picker...
				if (opts.timeOnly === true) {
					$tp.prepend(
						'<div class="ui-widget-header ui-helper-clearfix ui-corner-all">' +
							'<div class="ui-datepicker-title">'+ opts.timeOnlyTitle +'</div>' +
						'</div>');
					$dp.find('.ui-datepicker-header, .ui-datepicker-calendar, .ui-datepicker-current').hide();
				}

				tp_inst.hour_slider = $tp.find('#ui_tpicker_hour').slider({
					orientation: "horizontal",
					value: tp_inst.hour,
					min: opts.hourMin,
					max: hourMax,
					step: opts.stepHour,
					slide: function(event, ui) {
						tp_inst.hour_slider.slider( "option", "value", ui.value );
						tp_inst.onTimeChange(dp_inst, tp_inst);
					}
				});

				// Updated by Peter Medeiros:
				// - Pass in Event and UI instance into slide function
				tp_inst.minute_slider = $tp.find('#ui_tpicker_minute').slider({
					orientation: "horizontal",
					value: tp_inst.minute,
					min: opts.minuteMin,
					max: minMax,
					step: opts.stepMinute,
					slide: function(event, ui) {
						// update the global minute slider instance value with the current slider value
						tp_inst.minute_slider.slider( "option", "value", ui.value );
						tp_inst.onTimeChange(dp_inst, tp_inst);
					}
				});

				tp_inst.second_slider = $tp.find('#ui_tpicker_second').slider({
					orientation: "horizontal",
					value: tp_inst.second,
					min: opts.secondMin,
					max: secMax,
					step: opts.stepSecond,
					slide: function(event, ui) {
						tp_inst.second_slider.slider( "option", "value", ui.value );
						tp_inst.onTimeChange(dp_inst, tp_inst);
					}
				});

				$dp.find('.ui-datepicker-calendar').after($tp);
				tp_inst.$timeObj = jQuery('#ui_tpicker_time');

				if (dp_inst !== null) {
					var timeDefined = tp_inst.timeDefined;
					tp_inst.onTimeChange(dp_inst, tp_inst);
					tp_inst.timeDefined = timeDefined;
				}
			}
		},

		//########################################################################
		// when a slider moves..
		// on time change is also called when the time is updated in the text field
		//########################################################################
		onTimeChange: function(dp_inst, tp_inst) {
			var hour   = tp_inst.hour_slider.slider('value');
			var minute = tp_inst.minute_slider.slider('value');
			var second = tp_inst.second_slider.slider('value');
			var ampm = (hour < 12) ? 'AM' : 'PM';
			var hasChanged = false;

			// If the update was done in the input field, this field should not be updated.
			// If the update was done using the sliders, update the input field.
			if (tp_inst.hour != hour || tp_inst.minute != minute || tp_inst.second != second || (tp_inst.ampm.length > 0 && tp_inst.ampm != ampm)) {
				hasChanged = true;
			}

			tp_inst.hour = parseFloat(hour).toFixed(0);
			tp_inst.minute = parseFloat(minute).toFixed(0);
			tp_inst.second = parseFloat(second).toFixed(0);
			tp_inst.ampm = ampm;

			tp_inst.formatTime(tp_inst);
			tp_inst.$timeObj.text(tp_inst.formattedTime);

			if (hasChanged) {
				tp_inst.updateDateTime(dp_inst, tp_inst);
				tp_inst.timeDefined = true;
			}
		},

		//########################################################################
		// format the time all pretty...
		//########################################################################
		formatTime: function(tp_inst) {
			var tmptime = tp_inst.defaults.timeFormat.toString();
			var hour12 = ((tp_inst.ampm == 'AM') ? (tp_inst.hour) : (tp_inst.hour % 12));
			hour12 = (hour12 === 0) ? 12 : hour12;

			if (tp_inst.defaults.ampm === true) {
				tmptime = tmptime.toString()
					.replace(/hh/g, ((hour12 < 10) ? '0' : '') + hour12)
					.replace(/h/g, hour12)
					.replace(/mm/g, ((tp_inst.minute < 10) ? '0' : '') + tp_inst.minute)
					.replace(/m/g, tp_inst.minute)
					.replace(/ss/g, ((tp_inst.second < 10) ? '0' : '') + tp_inst.second)
					.replace(/s/g, tp_inst.second)
					.replace(/TT/g, tp_inst.ampm.toUpperCase())
					.replace(/tt/g, tp_inst.ampm.toLowerCase())
					.replace(/T/g, tp_inst.ampm.charAt(0).toUpperCase())
					.replace(/t/g, tp_inst.ampm.charAt(0).toLowerCase());

			} else {
				tmptime = tmptime.toString()
					.replace(/hh/g, ((tp_inst.hour < 10) ? '0' : '') + tp_inst.hour)
					.replace(/h/g, tp_inst.hour)
					.replace(/mm/g, ((tp_inst.minute < 10) ? '0' : '') + tp_inst.minute)
					.replace(/m/g, tp_inst.minute)
					.replace(/ss/g, ((tp_inst.second < 10) ? '0' : '') + tp_inst.second)
					.replace(/s/g, tp_inst.second);
				tmptime = jQuery.trim(tmptime.replace(/t/gi, ''));
			}

			tp_inst.formattedTime = tmptime;
			return tp_inst.formattedTime;
		},

		//########################################################################
		// update our input with the new date time..
		//########################################################################
		updateDateTime: function(dp_inst, tp_inst) {
			//var dt = this.$input.datepicker('getDate');
			var dt = new Date(dp_inst.selectedYear, dp_inst.selectedMonth, dp_inst.selectedDay);
			var dateFmt = jQuery.datepicker._get(dp_inst, 'dateFormat');
			var formatCfg = jQuery.datepicker._getFormatConfig(dp_inst);
			this.formattedDate = jQuery.datepicker.formatDate(dateFmt, (dt === null ? new Date() : dt), formatCfg);
			var formattedDateTime = this.formattedDate;
			var timeAvailable = dt !== null && tp_inst.timeDefined;

			if(this.defaults.timeOnly === true){
				formattedDateTime = this.formattedTime;
			}
			else if (this.defaults.timeOnly !== true && (this.defaults.alwaysSetTime || timeAvailable)) {
				formattedDateTime += ' ' + this.formattedTime;
			}

			this.formattedDateTime = formattedDateTime;
			this.$input.val(formattedDateTime);
		},

		setDefaults: function(settings) {
			extendRemove(this.defaults, settings || {});
			return this;
		}
	};

	//########################################################################
	// extend timepicker to datepicker
	//########################################################################
	jQuery.fn.datetimepicker = function(o) {
		var opts = (o === undefined ? {} : o);
		var tp = new Timepicker();

		var beforeShowFunc = function(input, inst) {
			tp.hour = tp.defaults.hour;
			tp.minute = tp.defaults.minute;
			tp.second = tp.defaults.second;
			tp.ampm = '';
			tp.$input = jQuery(input);
			tp.inst = inst;
			tp.addTimePicker(inst);
			if (jQuery.isFunction(opts.beforeShow)) {
				opts.beforeShow(input, inst);
			}
		};

		var onChangeMonthYearFunc = function(year, month, inst) {
			// Update the time as well : this prevents the time from disappearing from the input field.
			tp.updateDateTime(inst, tp);
			if (jQuery.isFunction(opts.onChangeMonthYear)) {
				opts.onChangeMonthYear(year, month, inst);
			}
		};

		var onCloseFunc = function(dateText, inst) {
			tp.updateDateTime(inst, tp);
			if (jQuery.isFunction(opts.onClose)) {
				opts.onClose(dateText, inst);
			}
		};

		tp.defaults = jQuery.extend({}, tp.defaults, opts, {
			beforeShow: beforeShowFunc,
			onChangeMonthYear: onChangeMonthYearFunc,
			onClose: onCloseFunc,
			timepicker: tp // add timepicker as a property of datepicker: jQuery.datepicker._get(dp_inst, 'timepicker');
		});

		jQuery(this).datepicker(tp.defaults);

	};

	//########################################################################
	// shorthand just to use timepicker..
	//########################################################################
	jQuery.fn.timepicker = function(opts) {
		opts = jQuery.extend(opts, { timeOnly: true });
		jQuery(this).datetimepicker(opts);
	};

	//########################################################################
	// the bad hack :/ override datepicker so it doesnt close on select
	// inspired: http://stackoverflow.com/questions/1252512/jquery-datepicker-prevent-closing-picker-when-clicking-a-date/1762378#1762378
	//########################################################################
	jQuery.datepicker._base_selectDate = jQuery.datepicker._selectDate;
	jQuery.datepicker._selectDate = function (id, dateStr) {
		var target = jQuery(id);
		var inst = this._getInst(target[0]);
		inst.inline = true;
		inst.stay_open = true;
		jQuery.datepicker._base_selectDate(id, dateStr);
		inst.stay_open = false;
		inst.inline = false;
		this._notifyChange(inst);
		this._updateDatepicker(inst);
	};

	//#############################################################################################
	// second bad hack :/ override datepicker so it triggers an event when changing the input field
	// and does not redraw the datepicker on every selectDate event
	//#############################################################################################
	jQuery.datepicker._base_updateDatepicker = jQuery.datepicker._updateDatepicker;
	jQuery.datepicker._updateDatepicker = function(inst) {
		if (typeof(inst.stay_open) !== 'boolean' || inst.stay_open === false) {
			this._base_updateDatepicker(inst);
			// Reload the time control when changing something in the input text field.
			this._beforeShow(inst.input, inst);
		}
	};

	jQuery.datepicker._beforeShow = function(input, inst) {
		var beforeShow = this._get(inst, 'beforeShow');
		if (beforeShow) {
		  inst.stay_open = true;
			beforeShow.apply((inst.input ? inst.input[0] : null), [inst.input, inst]);
			inst.stay_open = false;
		}
	};

	//#######################################################################################
	// third bad hack :/ override datepicker so it allows spaces and colan in the input field
	//#######################################################################################
	jQuery.datepicker._base_doKeyPress = jQuery.datepicker._doKeyPress;
	jQuery.datepicker._doKeyPress = function(event) {
		var inst = jQuery.datepicker._getInst(event.target);
		if (jQuery.datepicker._get(inst, 'constrainInput')) {
			var dateChars = jQuery.datepicker._possibleChars(jQuery.datepicker._get(inst, 'dateFormat'));
			var chr = String.fromCharCode(event.charCode === undefined ? event.keyCode : event.charCode);
			// keyCode == 58 => ":"
			// keyCode == 32 => " "
			return event.ctrlKey || (chr < ' ' || !dateChars || dateChars.indexOf(chr) > -1 || event.keyCode == 58 || event.keyCode == 32);
		}
	};

	//#######################################################################################
	// override "Today" button to also grab the time.
	//#######################################################################################
	jQuery.datepicker._base_gotoToday = jQuery.datepicker._gotoToday;
	jQuery.datepicker._gotoToday = function(id) {
		jQuery.datepicker._base_gotoToday(id);

		var target = jQuery(id);
		var dp_inst = this._getInst(target[0]);
		var tp_inst = jQuery.datepicker._get(dp_inst, 'timepicker');

		if(tp_inst){
			var date = new Date();
			var hour = date.getHours();
			var minute = date.getMinutes();
			var second = date.getSeconds();

			//check if within min/max times..
			if( (hour < tp_inst.defaults.hourMin || hour > tp_inst.defaults.hourMax) || (minute < tp_inst.defaults.minuteMin || minute > tp_inst.defaults.minuteMax) || (second < tp_inst.defaults.secondMin || second > tp_inst.defaults.secondMax) ){
				hour = tp_inst.defaults.hourMin;
				minute = tp_inst.defaults.minuteMin;
				second = tp_inst.defaults.secondMin;
			}

			tp_inst.hour_slider.slider('value', hour );
			tp_inst.minute_slider.slider('value', minute );
			tp_inst.second_slider.slider('value', second );

			tp_inst.onTimeChange(dp_inst, tp_inst);
		}
	};

	//#######################################################################################
	// jQuery extend now ignores nulls!
	//#######################################################################################
	function extendRemove(target, props) {
		jQuery.extend(target, props);
		for (var name in props)
			if (props[name] == null || props[name] == undefined)
				target[name] = props[name];
		return target;
	};

	jQuery.timepicker = new Timepicker(true); // singleton instance
})(jQuery);


