<?php
class ControllerReportSaleCashback extends Controller {
	public function index() {
		$this->load->language('report/sale_cashback');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = intval($this->request->get['page']);
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('report/sale_cashback', 'token=' . $this->session->data['token'] . $url, true)
		);

		$filter_data = array(
			'filter_date_start'		=> $filter_date_start,
			'filter_date_end'		=> $filter_date_end,
			'filter_customer'	   	=> $filter_customer,
			'filter_order_status_id'=> $filter_order_status_id,
			'start'             	=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             	=> $this->config->get('config_limit_admin')
		);

		$this->load->model('report/cashback');

		$data['report'] = $this->url->link('report/sale_cashback/report', 'token=' . $this->session->data['token'] . $url, true);

		$order_total = $this->model_report_cashback->getTotalOrders($filter_data);

		$results = $this->model_report_cashback->getOrders($filter_data);

		$cashback_voucher_theme_id = $this->config->get('cashback_voucher_theme_id');
		$cashback_valid = $this->config->get('cashback_valid') * 86400;

		foreach ($results as $result) {
			$cashback_voucher = $this->model_report_cashback->getVoucherByPrefixCode($result['order_id'] . 'C', $cashback_voucher_theme_id);
				
			if ($cashback_voucher) {
				$code = substr($cashback_voucher['code'],0 ,6) . 'xxxx';
				$amount = $this->currency->format($cashback_voucher['amount'], $result['currency_code'], $result['currency_value']);
				$date_expired = date($this->language->get('date_format_short'), strtotime($cashback_voucher['date_added']) + $cashback_valid);
				$cashback_status = ($cashback_voucher['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));

				$used = $this->model_report_cashback->getVoucherHistory($cashback_voucher['voucher_id']);
				
				if ($used) {
					$used_order_id = $used['order_id'];
				} else {
					$used_order_id = '';
				}
				
			} else {
				$code = '';
				$amount = '';
				$date_expired = '';
				
				$cashback_status = '';
				$used_order_id = '';
			}

			$data['orders'][] = array(
				'order_id'      	=> $result['order_id'],
				'customer'      	=> $result['customer'],
				'order_status'  	=> $result['order_status'],
				'order_status_id'	=> $result['order_status_id'],//Bonk04
				'total'         	=> $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'code'				=> $code,
				'amount'			=> $amount,
				'date_expired'    	=> $date_expired,
				'cashback_status'	=> $cashback_status,
				'used_order_id'		=> $used_order_id
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');
		$data['text_all_status'] = $this->language->get('text_all_status');

		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_date_expired'] = $this->language->get('column_date_expired');
		$data['column_cashback_status'] = $this->language->get('column_cashback_status');
		$data['column_used_order_id'] = $this->language->get('column_used_order_id');

		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_report_print'] = $this->language->get('button_report_print');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/sale_cashback', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_order_status_id'] = $filter_order_status_id;
		$data['filter_customer'] = $filter_customer;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('report/sale_cashback', $data));
	}
	
	public function report() {
		$this->load->language('report/sale_cashback');

		$data['title'] = $this->language->get('text_report');

		if ($this->request->server['HTTPS']) {
			$data['base'] = HTTPS_SERVER;
		} else {
			$data['base'] = HTTP_SERVER;
		}

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}

		if (isset($this->request->get['page'])) {
			$page = intval($this->request->get['page']);
		} else {
			$page = 1;
		}

		$filter_data = array(
			'filter_date_start'		=> $filter_date_start,
			'filter_date_end'		=> $filter_date_end,
			'filter_customer'	   	=> $filter_customer,
			'filter_order_status_id'=> $filter_order_status_id,
			'start'             	=> ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'             	=> $this->config->get('config_limit_admin')
		);

		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$filtered = $this->language->get('text_filtered');
		$filtered .= $this->language->get('entry_date_start') . ": " . $filter_date_start . '|';
		$filtered .= $this->language->get('entry_date_end') . ": " . $filter_date_end . '|';
		$filtered .= $this->language->get('entry_customer') . ": " . $filter_customer . '|';
		$filtered .= $this->language->get('entry_status') . ": " . $filter_order_status_id . '|';
		$data['filtered'] = $filtered;
		
		$data['direction'] = $this->language->get('direction');
		$data['lang'] = $this->language->get('code');

		$data['text_report'] = $this->language->get('text_report');
		
		$data['column_order_id'] = $this->language->get('column_order_id');
		$data['column_customer'] = $this->language->get('column_customer');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_total'] = $this->language->get('column_total');
		$data['column_date_added'] = $this->language->get('column_date_added');
		$data['column_code'] = $this->language->get('column_code');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_date_expired'] = $this->language->get('column_date_expired');
		$data['column_cashback_status'] = $this->language->get('column_cashback_status');
		$data['column_used_order_id'] = $this->language->get('column_used_order_id');

		$this->load->model('report/cashback');

		$order_total = $this->model_report_cashback->getTotalOrders($filter_data);

		$results = $this->model_report_cashback->getOrders($filter_data);

		$cashback_voucher_theme_id = $this->config->get('cashback_voucher_theme_id');
		$cashback_valid = $this->config->get('cashback_valid') * 86400;

		foreach ($results as $result) {
			$cashback_voucher = $this->model_report_cashback->getVoucherByPrefixCode($result['order_id'] . 'C', $cashback_voucher_theme_id);
				
			if ($cashback_voucher) {
				$code = substr($cashback_voucher['code'],0 ,6) . 'xxxx';
				$amount = $this->currency->format($cashback_voucher['amount'], $result['currency_code'], $result['currency_value']);
				$date_expired = date($this->language->get('date_format_short'), strtotime($cashback_voucher['date_added']) + $cashback_valid);
				$cashback_status = ($cashback_voucher['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));

				$used = $this->model_report_cashback->getVoucherHistory($cashback_voucher['voucher_id']);
				
				if ($used) {
					$used_order_id = $used['order_id'];
				} else {
					$used_order_id = '';
				}
				
			} else {
				$code = '';
				$amount = '';
				$date_expired = '';
				
				$cashback_status = '';
				$used_order_id = '';
			}

			$data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'order_status'  => $result['order_status'],
				'order_status_id'=> $result['order_status_id'],//Bonk04
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'code'			=> $code,
				'amount'			=> $amount,
				'date_expired'    => $date_expired,
				'cashback_status'	=> $cashback_status,
				'used_order_id'	=> $used_order_id
			);
		}


		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('report/sale_cashback/report', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($order_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($order_total - $this->config->get('config_limit_admin'))) ? $order_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $order_total, ceil($order_total / $this->config->get('config_limit_admin')));

		$this->response->setOutput($this->load->view('report/sale_cashback_report', $data));
	}
}
