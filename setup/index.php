<?php
	date_default_timezone_set('UTC');
	$_VARS["SOCIALCITE"]["version"] = "v0.5 [Alpha]";
	if(isset($_POST) && !empty($_POST)):
		header('Content-type: application/json');
		
		echo json_encode($_POST);
	else:
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex">

		<title>SocialCite - Set-up</title>
		<link rel="shortcut icon" href="favicon.png">
		
		<!-- BEGIN jQuery -->
		<script src="//code.jquery.com/jquery-latest.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/vader/jquery-ui.css">
		<script src="//rawgit.com/furf/jquery-ui-touch-punch/master/jquery.ui.touch-punch.min.js"></script>
		<!-- END jQuery -->
		
		<!-- BEGIN Bootstrap -->
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="//oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
			<script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		<!-- END Bootstrap -->
		
		<!-- BEGIN Font Awesome -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<!-- END Font Awesome -->
		
		<!-- BEGIN setup.js -->
		<script src="setup.js"></script>
		<!-- END setup.js -->
		
		
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top nav-list" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">SocialCite</a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav" role="tablist">
						<li><a data-toggle="tab" role="tab" href="#welcome">Welcome!</a></li>
						<li>
							<a href="#" data-toggle="dropdown" class="dropdown-toggle">Configuration <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a data-toggle="tab" role="tab" href="#site">Website</a></li>
								<li><a data-toggle="tab" role="tab" href="#db">Database</a></li>
								<li><a data-toggle="tab" role="tab" href="#ftp">File Transfer</a></li>
							</ul>
						</li>
						<li><a data-toggle="tab" role="tab" href="#review">Review</a></li>
						<li class="disabled"><a data-toggle="tab" role="tab" href="#summary">Summary</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container" style="margin-top: 55px">
			<div class="tab-content">
				<div id="welcome" role="tabpanel" class="tab-pane fade in active">
					<div class="row">
						<div class="form-group col-xs-offset-6 col-xs-6">
							<a data-toggle="tab" href="#site" class="btn btn-success pull-right">Website <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
						<h1>SocialCite Set-up</h1>
					<div class="row">
						<div class="col-sm-6">
							<p>If you are viewing this page, it means you probably are wanting to install the greatest CMS&ndash;in the world! Let's get started.</p>
							<p>This set-up will install <code>SocialCite <?php echo $_VARS["SOCIALCITE"]["version"]; ?></code>. <a href="http://lawtonsoft.com/projects/socialcite/downloads" target="_blank">Check for updates.</a></p>
							<p>We have tried to keep the set-up process as simplified as possible. In just a moment, we'll ask you some questions about your website and obtain necessary information to access the server. Then all you have to do is review and let the set-up process handle the rest!</p>
						</div>
						<div class="col-sm-6">
							<img src="socialcite_logo_full.png" alt="SocialCite Logo" class="img-responsive img-circle center-block" style="max-height: 250px; margin-bottom: 20px;">
						</div>
					</div>
					<div class="row">
						<div class="form-group col-xs-offset-6 col-xs-6">
							<a data-toggle="tab" href="#site" class="btn btn-success pull-right">Website <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
				</div>
				<div id="site" role="tabpanel" class="tab-pane fade">
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#welcome" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Welcome</a>
						</div>
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#db" class="btn btn-default pull-right">Database <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
					<h1>Website</h1>
					<p>We'll start with the easy stuff...</p>
					<form>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="siteName">Name</label>
									<input type="text" class="form-control" id="siteName" placeholder="SocialCite" required aria-describedby="siteNameStatus">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="siteNameStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Display name for the website. Keep it short and succinct, as this will be used to display in prominent parts of your website. Recommended: No more than 15 characters.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="siteTagLine">Tag Line <small>(Optional)</small></label>
									<input type="text" class="form-control" id="siteTagLine" placeholder="A LawtonSoft project" aria-describedby="siteTagLineStatus">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="siteTagLineStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Tag line to describe the website. Keep it short and succinct, as this will be used to display in prominent parts of your website. Recommended: No more than 25 characters.</p>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-sm-6">
								<div class="checkbox has-success has-feedback">
									<label class="control-label" for="siteUserlessSystem">
										<input type="checkbox" id="siteUserlessSystem" placeholder="Administrator" aria-describedby="siteUserlessSystemStatus" pattern="^\w+$"> <strong>Userless System <small>(Optional)</small></strong>
									</label>
									<span id="siteUserlessSystemStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Check if you wish to be automatically signed into the system without a password. <strong>Only use this is you are using a <code>localhost</code> or are secured by other means (e.g., Apache web login authentication).</strong></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="siteAdministratorName">Administrator Username <small>(Optional)</small></label>
									<input type="text" class="form-control" id="siteAdministratorName" placeholder="Administrator" aria-describedby="siteAdministratorNameStatus" pattern="^\w+$" data-default="Administrator">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="siteAdministratorNameStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Username for the default SocialCite administrator. Defaults to <code>Administrator</code>. <strong>Do not forget this password.</strong> There will be no way to recover unless you create other users with administrative privileges.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="siteAdministratorPassword">Administrator Password</label>
									<input type="password" class="form-control" id="siteAdministratorPassword" placeholder="paSSw0rd" required aria-describedby="siteAdministratorPasswordStatus" pattern=".{6}">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="siteAdministratorPasswordStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Password to access the default SocialCite administrator. Must be 6 or more characters.</p>
							</div>
						</div>
						<hr>
						<p>And now, to the nitty gritty...</p>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="siteFram3w0rkPath">Fram3w0rk path</label>
									<input type="text" class="form-control" id="siteFram3w0rkPath" placeholder="/var/www/html/Fram3w0rk/" required aria-describedby="siteFram3w0rkPathStatus" pattern="^(\.{0,2}\/|[a-z]\:\\).*">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="siteFram3w0rkPathStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>File path to Fram3w0rk. You can install Fram3w0rk locally under the same directory. <strong>This is a requirement for this set-up tool to work.</strong> Upon an invalid or incompatible version of Fram3w0rk, this set-up will return an error.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="siteCookieDomain">Cookie Domain</label>
									<input type="text" class="form-control" id="siteCookieDomain" placeholder=".example.com" required aria-describedby="siteCookieDomainStatus" pattern="^\.?(\w+.)+\w+">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="siteCookieDomainStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Specify the cookie domain. In most cases, this is your domain preceeded by a cookie. <strong>Warning! Do not forget this password.</strong></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="siteCookieDomain">Cookie Path</label>
									<input type="text" class="form-control" id="siteCookiePath" placeholder="/" required aria-describedby="siteCookiePathStatus" pattern="^/.*">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="siteCookiePathStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Specify the cookie path. In most cases, this is <code>/</code>.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="siteCookieTimeout">Cookie Timeout</label>
									<input type="text" class="form-control" id="siteCookieTimeout" placeholder="10080" required aria-describedby="siteCookieTimeoutStatus" pattern="^\d+$">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="siteCookieTimeoutStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Specify the time a cookie timeout (i.e., how long a user should be logged in for). <strong>Warning! Do not set for too short of a duration (e.g., 1 minute). This will make it very difficult to access and change this setting later.</strong></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="checkbox has-success has-feedback">
									<label class="control-label" for="siteCookieSecured">
										<input type="checkbox" id="siteCookieSecured" placeholder="Administrator" aria-describedby="siteCookieSecuredStatus" pattern="^\w+$"> <strong>Secured Cookies</strong>
									</label>
									<span id="siteCookieSecuredStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Specify if the cookie should be sent over a secured transaction. It is highly recommended to if possible. However, <strong>you should not enable this if you do not have a secure.</strong></p>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#welcome" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Welcome</a>
						</div>
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#db" class="btn btn-default pull-right">Database <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
				</div>
				<div id="db" role="tabpanel" class="tab-pane fade">
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#site" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Website</a>
						</div>
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#ftp" class="btn btn-default pull-right">File Transfer <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
					<h1>Database</h1>
					<form>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="dbType">Database Type</label>
									<select class="form-control" id="dbType" required>
										<option value="">&nbsp;</option>
										<option value="mysql">MySQL</option>
										<option value="postgresql">PostgreSQL</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Database server type. For most set-ups, <code>MySQL</code> will be the default. In the event that you do not know the database type, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="dbHost">Host</label>
									<input type="url" class="form-control" id="dbHost" placeholder="http://127.0.0.1/ or https://example.com/" required aria-describedby="dbHostStatus" pattern="^(https?://.+|\w+.*)">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="dbHostStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Host to access the database server. For most set-ups, <code>localhost</code> or <code>127.0.0.1</code> will be the host. In the event that you do not know the host, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="dbPort">Port <small>(Optional)</small></label>
									<input type="number" class="form-control" id="dbPort" min="0" size="6" value="0" aria-describedby="dbPortStatus">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="dbPortStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Port to access the database server. For most set-ups, the port can be left to the default. In the event that you cannot connect and you do not know the port, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="dbUser">User</label>
									<input type="text" class="form-control" id="dbUser" placeholder="root" required aria-describedby="dbUserStatus" pattern="^\w+$">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="dbUserStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>User to access the database server. For most set-ups, <code>root</code>, <code>admin</code> or <code>webadmin</code> will be the default username. However, it is highly recommended <em>not</em> to use these usernames, as it can be a security concern. In the event that you do not know the user, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="dbPassword">Password <small>(Optional)</small></label>
									<input type="password" class="form-control" id="dbPassword" placeholder="paSSw0rd" aria-describedby="dbPasswordStatus">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="dbPasswordStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Password to access the database server, if the database (user) has a password. If you do not already have a password set-up for your user and your user has public access, it is highly recommended that you set one up immediately for security purposes.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="dbDatabase">Database Name <small>(Optional)</small></label>
									<input type="text" class="form-control" id="dbDatabase" placeholder="socialcite" aria-describedby="dbDatabaseStatus" data-default="socialcite">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="dbDatabaseStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Database to store SocialCite data in. If the database does not exist, the process will attempt to create. <strong>This will require proper user privileges.</strong> Defaults to <code>socialcite</code>.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="text-center"><button type="button" class="btn btn-warning text-center" disabled>Test Connection</button></div>
							</div>
							<div class="col-sm-6">
								<p>Click this button to test the database connection. It will determine if it has the privileges necessary to create the account.</p>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#site" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Website</a>
						</div>
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#ftp" class="btn btn-default pull-right">File Transfer <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
				</div>
				<div id="ftp" role="tabpanel" class="tab-pane fade">
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#db" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Database</a>
						</div>
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#review" class="btn btn-default pull-right">Review <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
					<h1>File Transfer</h1>
					<form>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="ftpType">FTP Type</label>
									<select class="form-control" id="ftpType" required>
										<option value="">&nbsp;</option>
										<option value="ftp">FTP</option>
										<option value="sftp">SFTP</option>
										<option value="ftps">FTPS</option>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<p>FTP type. In the event that you do not know the FTP type, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="ftpHost">Host</label>
									<input type="url" class="form-control" id="ftpHost" placeholder="http://127.0.0.1/ or https://example.com/" required aria-describedby="ftpHostStatus" pattern="^(https?://.+|\w+.*)">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="ftpHostStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Host to access the file server. For most set-ups, <code>localhost</code> or <code>127.0.0.1</code> will be the host. In the event that you do not know the host, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="ftpPort">Port</label>
									<input type="number" class="form-control" id="ftpPort" min="0" size="6" value="0" aria-describedby="ftpPortStatus">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="ftpPortStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Port to access the file server. For most set-ups, the port can be left to the default. In the event that you cannot connect and you do not know the port, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="ftpUser">User</label>
									<input type="text" class="form-control" id="ftpUser" placeholder="root" required aria-describedby="ftpUserStatus" pattern="^\w+$">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="ftpUserStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>User to access the file server. For most set-ups, <code>root</code>, <code>admin</code> or <code>webadmin</code> will be the default username. However, it is highly recommended <em>not</em> to use these usernames, as it can be a security concern. In the event that you do not know the user, contact your hosting provider.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-success has-feedback">
									<label class="control-label" for="ftpPassword">Password <small>(Optional)</small></label>
									<input type="password" class="form-control" id="ftpPassword" placeholder="paSSw0rd" aria-describedby="ftpPasswordStatus">
									<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
									<span id="ftpPasswordStatus" class="sr-only">success</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Password to access the file server, if your FTP (user) has a password. If you do not already have a password set-up for your user and your user has public access, it is highly recommended that you set one up immediately for security purposes.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group has-warning has-feedback">
									<label class="control-label" for="ftpDirectory">Website Directory</label>
									<input type="text" class="form-control" id="ftpDirectory" placeholder="/var/www/html/" required aria-describedby="ftpDirectoryStatus" pattern="^(\.{0,2}\/|[a-z]\:\\).*">
									<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>
									<span id="ftpDirectoryStatus" class="sr-only">warning</span>
								</div>
							</div>
							<div class="col-sm-6">
								<p>Directory to store SocialCite data in. If the directory does not exist, the process will attempt to create. <strong>This will require proper user privileges.</strong></p>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="text-center"><button type="button" class="btn btn-warning text-center" disabled>Test Connection</button></div>
							</div>
							<div class="col-sm-6">
								<p>Click this button to test the FTP connection. It will determine if it has the privileges necessary to connect and access the appropriate directory.</p>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#db" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Database</a>
						</div>
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#review" class="btn btn-default pull-right">Review <span class="glyphicon glyphicon-arrow-right"></span></a>
						</div>
					</div>
				</div>
				<div id="review" role="tabpanel" class="tab-pane fade">
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#ftp" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> File Transfer</a>
						</div>
					</div>
					<h1>Review</h1>
					<p>Please review all of your settings here. You can go back at any point before the process start to make the necessary changes. If an error is encountered, the process will stop and return.</p>
					<div id="tables"></div>
					<div class="progress-bar progress-bar-striped active hidden" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
					<button class="btn btn-primary disabled" id="initiate">Set-up Your Website</button>
				</div>
				<div id="success" role="tabpanel" class="tab-pane fade">
					<div class="row">
						<div class="form-group col-xs-6">
							<a data-toggle="tab" href="#welcome"><span class="glyphicon glyphicon-arrow-left"></span> Welcome</a>
						</div>
					</div>
					<h1>Success</h1>
					<p>Congratulations! Now check out your new website!</p>
					<a href="#" class="btn btn-success">Go!</a>
				</div>
			</div>
			<br>
			<footer class="well well-sm">
				<p><a target="_blank" href="http://lawtonsoft.com/projects/socialcite">SocialCite</a> <?php echo $_VARS["SOCIALCITE"]["version"]; ?><br>
				&copy; <?php echo date("Y"); ?> | <span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">LawtonSoft.com</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nd/4.0/">Creative Commons Attribution-NoDerivatives 4.0 International License</a>.</p>
				<a rel="license" href="http://creativecommons.org/licenses/by-nd/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nd/4.0/88x31.png"></a>
			</footer>
		</div>
		<div id="modal01" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h4 class="modal-title">&nbsp;</h4></div><div class="modal-body"></div><div class="modal-footer"><button type="button" class="btn" data-dismiss="modal">Close</button></div></div></div></div>
	</body>
</html>
<?php endif; ?>
