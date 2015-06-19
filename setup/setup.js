setup = {
	validate: function(obj) {
		if($(obj).attr('pattern')) {
			regex = new RegExp($(obj).attr('pattern'), "gi");
			return Boolean(regex.exec($(obj).val()));
		}
		else return true;
	},
	onChange: function(obj) { // When the user makes a change to a form
		switch($(obj).attr('id')) {
		// Required text
		case 'siteName':
		case 'siteTagLine':
		case 'siteFram3w0rkPath':
		case 'siteAdministratorName':
		case 'siteAdministratorPassword':
		case 'dbHost':
		case 'dbUser':
		case 'dbPassword':
		case 'dbDatabase':
		case 'ftpHost':
		case 'ftpUser':
		case 'ftpPassword':
		case 'ftpDirectory':
			if($(obj).val() == '' && $(obj).attr('required')) {
				$(obj).next().attr('class', 'glyphicon glyphicon-warning-sign form-control-feedback');
				$(obj).next().next().val('warning');
				$(obj).parent().attr('class', 'form-group has-warning has-feedback');
			}
			else if($(obj).val() == '' || this.validate(obj)) {
				$(obj).next().attr('class', 'glyphicon glyphicon-ok form-control-feedback');
				$(obj).next().next().val('success');
				$(obj).parent().attr('class', 'form-group has-success has-feedback');
			}
			else {
				$(obj).next().attr('class', 'glyphicon glyphicon-error-sign form-control-feedback');
				$(obj).next().next().val('error');
				$(obj).parent().attr('class', 'form-group has-error has-feedback');
			}
			break;
		// Required selects
		case 'dbType':
			if($(obj).val() == '' && $(obj).attr('required')) {
				$(obj).next().next().val('warning');
				$(obj).parent().attr('class', 'form-group has-warning has-feedback');
			}
			else {
				$(obj).next().next().val('success');
				$(obj).parent().attr('class', 'form-group has-success has-feedback');
			}
			switch($(obj).val()) {
			case 'mysql':
				$('#dbPort').val(3306);
				break;
			case 'postgresql':
				$('#dbPort').val(5432);
				break;
			}
			break;
		case 'ftpType':
			if($(obj).val() == '' && $(obj).attr('required')) {
				$(obj).next().next().val('warning');
				$(obj).parent().attr('class', 'form-group has-warning has-feedback');
			}
			else {
				$(obj).next().next().val('success');
				$(obj).parent().attr('class', 'form-group has-success has-feedback');
			}
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
			break;
		case 'dbPort':
		case 'ftpPort':
			break;
		}
	},
	initiate: function() {
	}
}
$(function() {
	$(":input").each(function() {
		$(this).on('change keyup', function() {
			setup.onChange(this);
		});
	});
});
