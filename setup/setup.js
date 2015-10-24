// Set-up class
setup = {
	review: function() {
		$('#tables').html('');
		$('.tab-pane > form').each(function() {
			$('#tables').append('<h2>' + $(this).parent().children('h1:first').html() + '</h2>');
			$('#tables').append('<table class="table table-hover table-bordered"><tr><th>Setting</th><th>Value</th></tr></table>');
			$(this).find(':input').each(function() {
				switch($(this).prop('tagName').toLowerCase()) {
				case 'input':
				case 'textarea':
					if($(this).attr('type') == 'checkbox') setting = $(this).parent().clone().children('input').remove().end().children(0).html() + '?';
					else setting = $(this).prev().html();
					if($(this).attr('type') == 'password') value = Array($(this).val().length + 1).join('*');
					else if($(this).attr('type') == 'checkbox') value = ($(this).is(':checked') ? 'True' : 'False');
					else value = $(this).val();
					break;
				case 'select':
					setting = $(this).prev().html();
					value = $(this).find(':selected').html();
				}
				$('#tables > table:last').append('<tr><td>' + setting + '</td><td>' + value + '</td></tr>');
			});
		});
	},
	validate: function(obj) {
		bool = true;
		if($(obj).attr('pattern')) {
			regex = new RegExp($(obj).attr('pattern'), 'gi');
			if(!Boolean(regex.exec($(obj).val()))) bool = false;
		}
		else if($(obj).prop('tagName').toLowerCase() == 'input' && $.inArray($(obj).attr('type'), ['number', 'range'])) {
			if(Number($(obj).val()) == 'NaN' || Number($(obj).val()) < $(obj).attr('min') || Number($(obj).attr('max') < $(obj).val())) bool = false;
		}
		return bool;
	},
	onChange: function(obj) { // When the user makes a change to a form
		switch($(obj).prop('tagName').toLowerCase() + ($(obj).attr('type') != undefined ? ':' + $(obj).attr('type') : '')) {
		// Required text
		case 'input:text':
		case 'input:number':
		case 'input:password':
		case 'input:range':
		case 'input:url':
			// For all empty values that are required, return a warning
			if($(obj).val() == '' && $(obj).attr('required')) {
				$(obj).next().attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
				$(obj).next().next().html('warning');
				$(obj).parent().attr('class', 'form-group has-warning has-feedback');
			}
			// For all other empty or valid values, return a success
			else if($(obj).val() == '' || this.validate(obj)) {
				$(obj).next().attr('class', 'glyphicon glyphicon-ok form-control-feedback');
				$(obj).next().next().html('success');
				$(obj).parent().attr('class', 'form-group has-success has-feedback');
			}
			// For all invalid values, return an error
			else {
				$(obj).next().attr('class', 'glyphicon glyphicon-remove form-control-feedback');
				$(obj).next().next().html('error');
				$(obj).parent().attr('class', 'form-group has-error has-feedback');
			}
			break;
		case 'select':
			// For all empty values that are required, return a warning
			if($(obj).val() == '' && $(obj).attr('required')) {
				$(obj).next().next().val('warning');
				$(obj).parent().attr('class', 'form-group has-warning has-feedback');
			}
			// For all other empty or valid values, return a success
			else {
				$(obj).next().next().val('success');
				$(obj).parent().attr('class', 'form-group has-success has-feedback');
			}
			if($(obj).attr('id') == 'dbType') {
				switch($(obj).val()) {
				case 'mysql':
					$('#dbPort').val(3306);
					break;
				case 'postgresql':
					$('#dbPort').val(5432);
					break;
				}
			}
			else if($(obj).attr('id') == 'ftpType') {
				switch($(obj).val()) {
				case 'ftp':
					$('#ftpPort').val(21);
					break;
				case 'sftp':
					$('#ftpPort').val(22);
					break;
				case 'ftps':
					$('#ftpPort').val(990);
					break;
				}
			}
			break;
		case 'input:checkbox':
			if($(obj).attr('id') == 'siteUserlessSystem') {
				if($(obj).is(':checked')) {
					$('#siteAdministratorName').prop('disabled', true);
					$('#siteAdministratorPassword').prop('disabled', true);
				}
				else {
					$('#siteAdministratorName').prop('disabled', false);
					$('#siteAdministratorPassword').prop('disabled', false);
				}
			}
			break;
		default:
			console.log(obj);
		}
		// If no errors, highlight button(s) to advance user to next page
		if($(obj).closest('form').find('.has-warning, .has-error').length == 0) {
			$(obj).closest('form').parent().children(':first, :last').each(function() {$($(this).children(':last')[0]).children().removeClass('btn-default').addClass('btn-success')});
			if($.find('.tab-pane > form .has-warning, .tab-pane > form .has-error').length == 0) $('#initiate').removeClass('disabled');
		}
		else {
			$(obj).closest('form').parent().children(':first, :last').each(function() {$($(this).children(':last')[0]).children().removeClass('btn-success').addClass('btn-default')});
			$('#initiate').addClass('disabled');
		}
	},
	initiate: function() {
		
		data = {};
		$('.tab-pane > form :input').each(function() {
			switch($(this).prop('tagName').toLowerCase()) {
			case 'input':
			case 'textarea':
				setting = $(this).attr('id');
				value = ($(this).attr('type') == 'password' ? Array($(this).val().length).join('*') : $(this).val());
				break;
			case 'select':
				setting = $(this).prev().html();
				value = $(this).find(':selected').html();
			}
			data[setting] = value;
		});
		$('progress-bar').show();
		
		// Submit data
		$.ajax({
			url: 'index.php',
			method: 'POST',
			data: data,
			success: function(output) {
				console.log(output);
			}
		});
	},
	test: {
		database: function() {
			return false;
		},
		ftp: function() {
			return false;
		}
	}
}

// On load
$(function() {
	// Create review table
	setup.review();
	
	// On form changes
	$('.tab-content :input').each(function() {
		$(this).on('keyup click', function() {
			// Update individual input items respectively
			setup.onChange(this);
		});
		$(this).change(function() {
			// Update review table
			setup.review();
		});
	});
	
	// On button submit
	$('#initiate').click(function() {
		// Update individual input items respectively
		setup.initiate();
	});
});
