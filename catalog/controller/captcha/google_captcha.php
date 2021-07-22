<?php
class ControllerCaptchaGoogleCaptcha extends Controller {
    public function index($error = array()) {
        $this->load->language('captcha/google_captcha');

		$data['text_captcha'] = $this->language->get('text_captcha');

		$data['entry_captcha'] = $this->language->get('entry_captcha');

        if (isset($error['captcha'])) {
			$data['error_captcha'] = $error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		$data['site_key'] = $this->config->get('google_captcha_key');

        $data['route'] = $this->request->get['route']; 

		return $this->load->view('captcha/google_captcha', $data);
    }

    public function validate() {
        $this->load->language('captcha/google_captcha');

		$url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 15);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
//		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, TRUE);
		$curlData = curl_exec($curl);

		curl_close($curl);

		$recaptcha = json_decode($curlData, TRUE);
		
		
//        $recaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($this->config->get('google_captcha_secret')) . '&response=' . $this->request->post['g-recaptcha-response'] . '&remoteip=' . $this->request->server['REMOTE_ADDR']);

//        $recaptcha = json_decode($recaptcha, true);

        if (!$recaptcha['success']) {
            return $this->language->get('error_captcha');
        }
    }
}
