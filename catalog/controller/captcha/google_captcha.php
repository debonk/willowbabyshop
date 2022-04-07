<?php
class ControllerCaptchaGoogleCaptcha extends Controller
{
	public function index($error = array())
	{
		# Google Recaptcha V3
		// $this->document->addScript('https://www.google.com/recaptcha/api.js?render=' . $this->config->get('google_captcha_key'), 'header');

		$this->load->language('captcha/google_captcha');

		$data['grecaptcha_url'] = 'https://www.google.com/recaptcha/api.js?render=' . $this->config->get('google_captcha_key');

		$data['site_key'] = $this->config->get('google_captcha_key');
		$data['text_grecaptcha'] = $this->language->get('text_grecaptcha');

		$data['button_continue'] = $this->language->get('button_continue');

		if (isset($error['captcha'])) {
			$data['error_captcha'] = $error['captcha'];
		} else {
			$data['error_captcha'] = '';
		}

		return $this->load->view('captcha/google_captcha', $data);
	}

	public function validate()
	{
		$this->load->language('captcha/google_captcha');

		$url = 'https://www.google.com/recaptcha/api/siteverify';

		$request_data = [
			'secret'	=> urlencode($this->config->get('google_captcha_secret')),
			'response'	=> $this->request->post['g-recaptcha-response']
		];

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request_data);
		curl_setopt($curl, CURLOPT_TIMEOUT, 15);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
		$response_data = curl_exec($curl);

		curl_close($curl);

		$response_data = json_decode($response_data, TRUE);

		if (!$response_data || !$response_data['success'] || ($response_data['success'] && $response_data['score'] < $this->config->get('google_captcha_score'))) {
			return $this->language->get('error_captcha');
		}
	}
}
