<?php
class ControllerCheckoutLogin extends Controller {
	public function index() {
		$this->load->language('checkout/checkout');

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
			// $google_client->setClientId('239326699932-7caq983lnj38rl0ntd3783lpk18eru30.apps.googleusercontent.com');
			//Set the OAuth 2.0 Client Secret key
			$google_client->setClientSecret($this->config->get('google_login_secret'));
			//Set the OAuth 2.0 Redirect URI
			$google_client->setRedirectUri($this->config->get('google_login_redirect_uri'));

			$google_client->addScope('email');
			$google_client->addScope('profile');

			$data['login'] = $google_client->createAuthUrl();

			// if (isset($this->request->get['code'])) {
			// 	$token = $google_client->fetchAccessTokenWithAuthCode($this->request->get['code']);

			// 	if (!isset($token['error'])) {
			// 		$google_client->setAccessToken($token['access_token']);
			// 		$google_service = new Google_Service_Oauth2($google_client);
			// 		$client_data = $google_service->userinfo->get();

			// 		$google_client->revokeToken();
			// 	}
			// }

			// if (isset($client_data)) {
			// 	$customer_info = $this->model_account_customer->getCustomerByEmail($client_data['email']);

			// 	if ($customer_info) {
			// 		$this->request->post['email'] = $client_data['email'];
			// 		$this->request->post['google_login'] = true;

			// 		if ($this->validate()) {
			// 			$validated = true;
			// 		}
			// 	} else {
			// 		$customer_data = [
			// 			'firstname'	=> $client_data['givenName'],
			// 			'lastname'	=> $client_data['familyName'],
			// 			'email' => $client_data['email'],
			// 			'telephone' => '',
			// 			'fax' => '',
			// 			'password' => token(20),
			// 			'newsletter' => '1'
			// 		];

			// 		$customer_id = $this->model_account_customer->addCustomer($customer_data);

			// 		// Clear any previous login attempts for unregistered accounts.
			// 		$this->model_account_customer->deleteLoginAttempts($client_data['email']);

			// 		$this->customer->login($client_data['email'], '', true);

			// 		unset($this->session->data['guest']);

			// 		// Add to activity log
			// 		$this->load->model('account/activity');

			// 		$activity_data = array(
			// 			'customer_id' => $customer_id,
			// 			'name'        => $customer_data['firstname'] . ' ' . $customer_data['lastname']
			// 		);

			// 		$this->model_account_activity->addActivity('register', $activity_data);

			// 		$this->response->redirect($this->url->link('account/success'));
			// 	}
			// }
		}

		$data['text_checkout_account'] = $this->language->get('text_checkout_account');
		$data['text_checkout_payment_address'] = $this->language->get('text_checkout_payment_address');
		$data['text_new_customer'] = $this->language->get('text_new_customer');
		$data['text_returning_customer'] = $this->language->get('text_returning_customer');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_guest'] = $this->language->get('text_guest');
		$data['text_i_am_returning_customer'] = $this->language->get('text_i_am_returning_customer');
		$data['text_register_account'] = $this->language->get('text_register_account');
		$data['text_forgotten'] = $this->language->get('text_forgotten');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['text_or'] = $this->language->get('text_or');

		$data['entry_email'] = $this->language->get('entry_email');
		$data['entry_password'] = $this->language->get('entry_password');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_login'] = $this->language->get('button_login');

		$data['checkout_guest'] = ($this->config->get('config_checkout_guest') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = 'register';
		}

		$data['forgotten'] = $this->url->link('account/forgotten', '', true);

		$this->response->setOutput($this->load->view('checkout/login', $data));
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
		}

		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		if (!$json) {
			$this->load->model('account/customer');

			// Check how many login attempts have been made.
			$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

			if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
				$json['error']['warning'] = $this->language->get('error_attempts');
			}

			// Check if customer has been approved.
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

			if ($customer_info && !$customer_info['approved']) {
				$json['error']['warning'] = $this->language->get('error_approved');
			}

			if (!isset($json['error'])) {
				if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
					$json['error']['warning'] = $this->language->get('error_login');

					$this->model_account_customer->addLoginAttempt($this->request->post['email']);
				} else {
					$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
				}
			}
		}

		if (!$json) {
			// Unset guest
			unset($this->session->data['guest']);

			// Default Shipping Address
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			// Wishlist
			if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
				$this->load->model('account/wishlist');

				foreach ($this->session->data['wishlist'] as $key => $product_id) {
					$this->model_account_wishlist->addWishlist($product_id);

					unset($this->session->data['wishlist'][$key]);
				}
			}

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('login', $activity_data);

			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
