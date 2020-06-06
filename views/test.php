<html>
<body>
	<head>
		<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->config->item("google_key") ?>"></script>
	</head>
	<form action="<?php echo base_url("test/control") ?>">

		<label for="username">Kullanıcı Adı</label>

		<input type="text" class="form-control" id="username" placeholder="Enter username">

		<label for="userpassword">Parola</label>

		<input type="password" class="form-control" id="userpassword" placeholder="Enter password">

		<input type="hidden" name="recaptcha" id="googleRecaptcha">

		<button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Giriş Yap</button>
		
	</form>

	<footer>
		<script>
			grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo $this->config->item("google_key") ?>', {action: 'action_name'})
				.then(function(token) {
					var googleRecaptcha = document.getElementById('googleRecaptcha');
					googleRecaptcha.value = token;
				});
			});
		</script>
	</footer>
</body>
</html>
