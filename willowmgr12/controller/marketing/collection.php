<?php
class ControllerMarketingCollection extends Controller
{
	private $field_data = [
		'invoice',
		'customer_id',
		'name',
		'account',
		'date_start',
		'date_end'
	];

	public function index()
	{
		$this->load->language('marketing/collection');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/collection');

		foreach ($this->field_data as $field) {
			if (isset($this->request->get['filter_' . $field])) {
				$filter[$field] = $this->request->get['filter_' . $field];
			} else {
				$filter[$field] = null;
			}
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		foreach ($this->field_data as $field) {
			if (isset($this->request->get['filter_' . $field])) {
				$url .= '&filter_' . $field . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $field], ENT_QUOTES, 'UTF-8'));
			}
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
			'href' => $this->url->link('marketing/collection', 'token=' . $this->session->data['token'], true)
		);

		$data['export'] = $this->url->link('marketing/collection/export', 'token=' . $this->session->data['token'] . $url, true);

		$data['collections'] = [];
		$limit = $this->config->get('config_limit_admin');

		$filter_data = [
			'filter'	=> $filter,
			'sort'		=> $sort,
			'order'		=> $order,
			'start'		=> ($page - 1) * $limit,
			'limit'		=> $limit
		];

		$collection_total = $this->model_marketing_collection->getTotalCollections($filter_data);

		$results = $this->model_marketing_collection->getCollections($filter_data);

		foreach ($results as $result) {
			$data['collections'][] = [
				'collection_id'	=> $result['collection_id'],
				'invoice'		=> $result['invoice'],
				'total'			=> $this->currency->format($result['total'], $this->config->get('config_currency')),
				'customer_id'	=> $result['customer_id'],
				'name'			=> $result['name'],
				'account'		=> $result['account'],
				'date_added'	=> date($this->language->get('date_format_short'), strtotime($result['date_added'])),
			];
		}

		$language_items = array(
			'heading_title',
			'text_list',
			'text_no_results',
			'entry_invoice',
			'entry_customer_id',
			'entry_name',
			'entry_total',
			'entry_account',
			'entry_date_start',
			'entry_date_end',
			'column_invoice',
			'column_customer_id',
			'column_name',
			'column_total',
			'column_account',
			'column_date_added',
			'button_export',
			'button_filter'
		);
		foreach ($language_items as $language_item) {
			$data[$language_item] = $this->language->get($language_item);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->session->data['error'])) {
			$data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$data['error'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		foreach ($this->field_data as $field) {
			if (isset($this->request->get['filter_' . $field])) {
				$url .= '&filter_' . $field . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $field], ENT_QUOTES, 'UTF-8'));
			}
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_invoice'] = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . '&sort=invoice' . $url, true);
		$data['sort_total'] = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . '&sort=total' . $url, true);
		$data['sort_customer_id'] = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . '&sort=customer_id' . $url, true);
		$data['sort_name'] = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_account'] = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . '&sort=account' . $url, true);
		$data['sort_date_added'] = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, true);

		$url = '';

		foreach ($this->field_data as $field) {
			if (isset($this->request->get['filter_' . $field])) {
				$url .= '&filter_' . $field . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $field], ENT_QUOTES, 'UTF-8'));
			}
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $collection_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($collection_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($collection_total - $limit)) ? $collection_total : ((($page - 1) * $limit) + $limit), $collection_total, ceil($collection_total / $limit));

		$data['filter'] = $filter;
		$data['json_field_data'] = json_encode($this->field_data);

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('marketing/collection_list', $data));
	}

	public function export()
	{
		$this->load->language('marketing/collection');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		foreach ($this->field_data as $field) {
			if (isset($this->request->get['filter_' . $field])) {
				$url .= '&filter_' . $field . '=' . urlencode(html_entity_decode($this->request->get['filter_' . $field], ENT_QUOTES, 'UTF-8'));
			}
		}
		
		if (!$this->user->hasPermission('modify', 'marketing/collection')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->response->redirect($this->url->link('marketing/collection', 'token=' . $this->session->data['token'] . $url, true));
		} else {
			$this->load->model('marketing/collection');

			$language_items = array(
				'heading_title',
				'text_list',
				'text_no_results',
				'column_no',
				'column_invoice',
				'column_customer_id',
				'column_name',
				'column_total',
				'column_account',
				'column_status',
				'column_date_added'
			);
			foreach ($language_items as $language_item) {
				$data[$language_item] = $this->language->get($language_item);
			}

			foreach ($this->field_data as $field) {
				if (isset($this->request->get['filter_' . $field])) {
					$filter[$field] = $this->request->get['filter_' . $field];
				} else {
					$filter[$field] = null;
				}
			}

			if (isset($this->request->get['sort'])) {
				$sort = $this->request->get['sort'];
			} else {
				$sort = 'date_added';
			}

			if (isset($this->request->get['order'])) {
				$order = $this->request->get['order'];
			} else {
				$order = 'DESC';
			}

			$output = '';
			$i = 1;

			$filter_data = [
				'filter'	=> $filter,
				'sort'		=> $sort,
				'order'		=> $order,
			];

			$collection_total = $this->model_marketing_collection->getTotalCollections($filter_data);

			$results = $this->model_marketing_collection->getCollections($filter_data);

			$output .= $data['heading_title'] . '|>';
			$output .= $data['text_list'] . '||||||' . sprintf($this->language->get('text_record'), $collection_total, date($this->language->get('date_format_short'))) . '|>|>';

			$output .= $data['column_no'] . '|' . $data['column_invoice'] . '|' . $data['column_total'] . '|' . $data['column_customer_id'] . '|' . $data['column_name'] . '|' . $data['column_account'] . '|' . $data['column_date_added'] . '|' . $data['column_status'] . '|>';

			foreach ($results as $result) {
				$output .= $i . '|' . $result['invoice'] . '|' . $result['total'] . '|' . $result['customer_id'] . '|' . $result['name'] . '|\'' . $result['account'] . '|' . date($this->language->get('date_format_short'), strtotime($result['date_added'])) . '|>';

				$i++;
			}

			$output = str_replace(array("\x00", "\x0a", "\x0d", "\x1a"), array('\0', '\n', '\r', '\Z'), $output);
			$output = str_replace(array("\n", "\r", "\t"), array('\n', '\r', '\t'), $output);
			$output = str_replace('\\', '\\\\', $output);
			$output = str_replace('\'', '\\\'', $output);
			$output = str_replace('\\\n', '\n', $output);
			$output = str_replace('\\\r', '\r', $output);
			$output = str_replace('\\\t', '\t', $output);

			$output = str_replace('|>', "\n", $output);
			$output = str_replace('|', "\t", $output);
			$output = str_replace("\'", "'", $output);

			$filename = 'Promo_HUT_BCA_65_' . date('d_m_y');

			$this->response->addheader('Pragma: public');
			$this->response->addheader('Expires: 0');
			$this->response->addheader('Content-Description: File Transfer');
			$this->response->addheader('Content-Type: application/octet-stream');
			$this->response->addheader('Content-Disposition: attachment; filename=' . $filename . '.xls');
			$this->response->addheader('Content-Transfer-Encoding: binary');
			$this->response->setOutput($output);
			
			// $output = str_replace("\n", '<br>', $output);
			// echo $output;
		}
	}
}
