<?php
class ControllerCommonWelcome extends Controller {
	public function index() {
		$this->load->language('common/welcome');

		$data['text_greeting'] = $this->language->get('text_greeting');

		$data['user_point_status'] = false;

		// $data['poin_reward'] = 0;
		// $data['poin_balance'] = 0;
		// $data['poin_cashback'] = 0;

		if ($this->customer->isLogged()) {
			//Bonk06
			$data['text_greeting'] = sprintf($this->language->get('text_logged'), $this->customer->getFirstName()); //Bonk
			
			$data['reward_status'] = $this->config->get('reward_status');
			$data['balance_status'] = $this->config->get('credit_status') && $this->customer->getBalance() > 0;
			
			if ($data['reward_status'] || $data['balance_status']) {
				$data['user_point_status'] = true;
			}

			if ($data['reward_status']) {
				$data['reward'] = $this->url->link('account/reward');
				$data['text_reward'] = $this->language->get('text_reward');
				$data['poin_reward'] = (int)$this->customer->getRewardPoints();
			}

			if ($data['balance_status']) {

				$data['balance'] = $this->url->link('account/transaction');
				$data['text_balance'] = $this->language->get('text_balance');
				$data['poin_balance'] = $this->currency->format($this->customer->getBalance(), $this->session->data['currency']);
			}
			
			//Bonk04
			$data['cashback_status'] = $this->config->get('cashback_status');
			if ($data['cashback_status']) {
				
				$cashback_valid = $this->config->get('cashback_valid');
				$data['user_point_status'] = true;

				$this->load->model('common/welcome');
				$results = $this->model_common_welcome->getVouchersByEmail($this->customer->getEmail(), $this->config->get('cashback_voucher_theme_id'));

				$cashback_voucher = 0;

				foreach ($results as $result) {
					if (!$this->model_common_welcome->getVoucherHistoriesTotalById($result['voucher_id'])) {
						if ($result['date_diff'] <= $cashback_valid) {
							$cashback_voucher += $result['amount'];
						}	
					}
				}
				
				$data['help_cashback'] = $this->language->get('help_cashback');
				$data['text_cashback'] = $this->language->get('text_cashback');
				$data['poin_cashback'] = $this->currency->format($cashback_voucher, $this->session->data['currency']);
				
			} else {
				$data['poin_cashback'] = 0;
			}
		} else {
			$url_login = $this->url->link('account/login', '', true);
			$text_login = '<a href="' . $url_login . '">' . $this->language->get('text_login') . '</a>';
			$url_register = $this->url->link('account/register', '', true);
			$text_register = '<a href="' . $url_register . '">' . $this->language->get('text_register') . '</a>';
			$data['text_sign_in'] = sprintf($this->language->get('text_sign_in'), $text_login, $text_register);

			$data['google_login'] = $this->config->get('google_login_status');

			if ($data['google_login']) {
				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}
	
				if (is_file(DIR_IMAGE . $this->config->get('google_login_button_image'))) {
					$data['google_button'] = $server . 'image/' . $this->config->get('google_login_button_image');
				} else {
					$data['google_button'] = '';
				}
		
				# Login by Google
				//Make object of Google API Client for call Google API
				$google_client = new Google_Client();
				//Set the OAuth 2.0 Client ID
				$google_client->setClientId($this->config->get('google_login_client_id'));
				//Set the OAuth 2.0 Client Secret key
				$google_client->setClientSecret($this->config->get('google_login_secret'));
				//Set the OAuth 2.0 Redirect URI
				$google_client->setRedirectUri($this->config->get('google_login_redirect_uri'));
	
				$google_client->addScope('email');
				$google_client->addScope('profile');
	
				$data['login'] = $google_client->createAuthUrl();
			}
		}
		
		return $this->load->view('common/welcome', $data);
	}
}