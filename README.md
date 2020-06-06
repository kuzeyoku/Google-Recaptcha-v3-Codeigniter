# Google-Recaptcha-v3-Codeigniter
Codeigniter Kütüphanesinde Kullanabileceğiniz Google Recaptcha Sistemi

# Hesap Oluşturma
Google hesabınız ile aşağıdaki bağlantıda üyelik oluşturup site bilgileri girildikten sonra karşınıza 2 adet kod gelecektir. Birincisi Site anahtarı ikincisi gizli anahtar.

https://www.google.com/recaptcha/intro/v3.html

# Config
Kşağıdaki kodlar config.php dosyasının en altına eklenir. Bu kodları isterseniz admin panelinizden de yönetecek şekilde ayarlayabilirsiniz. Bir önceki işlemde kayıt olduğumuzda bize verilen kodları burada ilgili yerlere ekliyoruz.

	$config['google_key'] = 'Site Anahtarı';

	$config['google_secret'] = 'Gizli Anahtar';

# Helper
İşlemi en basit şekilde kullanabilmek için helperda fonksiyon tanımlıyoruz. 

	function recaptcha($response)
	{
	    $CI =& get_instance();
	    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
	    $secret = $CI->config->item("google_secret");
	    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $secret . '&response=' . $response);
	    $recaptcha = json_decode($recaptcha);
	    if ($recaptcha->success == TRUE) {
		return $recaptcha->score >= 0.5 ? TRUE : FALSE;
	    } else {
		return FALSE;
	    }
	}

Fonksiyon formdan gelen doğrulama anahtarını gönderdiğimizde bize true yada false şeklinde cevap verecek. Kriterimiz sorgunun başarılı olması ve doğrulama puanının 0.5 yada daha büyük olması. 0.5 değerini değiştirebilir yada iptal edebilirsiniz. Burada 2 veri var birincisi formdan gelen anahtar, diğeride config.php dosyamızdan gelen $CI->config->item("google_secret") gizli anahtar. İlgili tanımlamaları yaptık herşey hazır.

# Views 
Fonksiyonu kullanabilmek için elimizde bir veri olması gerek ve bu sistemi sayfamıza dahil etmeliyiz. İlgili views de head ve footer kısmına eklenecek kodlar aşağıdaki şekilde.
Head kısmına eklenecek kod;
	
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $this->config->item("google_key") ?>"></script>

Yine burada $this->config->item("google_key") değeri config.php den çekiliyor.
Footer kısmına eklenecek kod;

		<script>
			grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo $this->config->item("google_key") ?>', {action: 'action_name'})
				.then(function(token) {
					var googleRecaptcha = document.getElementById('googleRecaptcha');
					googleRecaptcha.value = token;
				});
			});
		</script>

Aynı şekilde burdada $this->config->item("google_key") değerini config.php den alıp id'si 'googleRecaptcha' olan gizli inputa doğrulama anahtarını value olarak eklemiş oluyoruz.

	<form action="<?php echo base_url("test/control") ?>" method="post">

		<label for="username">Kullanıcı Adı</label>

		<input type="text" class="form-control" id="username" placeholder="Enter username">

		<label for="userpassword">Parola</label>

		<input type="password" class="form-control" id="userpassword" placeholder="Enter password">

		<input type="hidden" name="recaptcha" id="googleRecaptcha">

		<button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Giriş Yap</button>
		
	</form>
  
  Formumuz ve gizli inputumuz tanımlandı artık herşey hazır controller'a post edebiliriz.
  
  # Controller
  
	  public function control()
	  {
	    $recaptcha = recaptcha(trim($this->input->post("recaptcha")));
	    if ($recaptcha == TRUE) {
	      echo "Doğrulama Başarılı";
	    } else {
	      echo "Doğrulama Başarısız";
	    } 
	  }
  
  İlgili metoda post işlemini gerçekleştirdiğimizde ve ilgili inputun değerini helper'da oluşturduğumuz fonksiyona parametre olarak gönderdiğimizde anahtarı kontrol ederek bize TRUE yada FALSE şeklinde cevap verecektir. Buna göre koşulu belirleyip hata mesajı yada diğer işlemleri gerçekleştirebiliriz...



