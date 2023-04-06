<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
class Mail extends \Opencart\System\Engine\Controller { 
	// private $error = array();
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/mail');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/mail', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/mail|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/mail|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/mail', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/mail');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'mail_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/mail|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['mails'] = [];

		$filter_data = [
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/mail');

		$mail_total = $this->model_extension_tmdmultivendor_vendor_mail->getTotalMail($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_mail->getMails($filter_data);

		foreach ($results as $result) {
			$data['mails'][] = [
				'mail_id'   => $result['mail_id'],
				'name'      => $result['name'],
				'date_added'=> $result['date_added'],
				'edit'           => $this->url->link('extension/tmdmultivendor/vendor/mail|form', 'user_token=' . $this->session->data['user_token'] . '&mail_id=' . $result['mail_id'] . $url)
			];
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/mail|list', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url);
		$data['sort_date'] = $this->url->link('extension/tmdmultivendor/vendor/mail|list', 'user_token=' . $this->session->data['user_token'] . '&sort=date' . $url);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $mail_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/mail|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($mail_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($mail_total - $this->config->get('config_pagination_admin'))) ? $mail_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $mail_total, ceil($mail_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/mail_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/mail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('view/javascript/ckeditor/ckeditor.js');
		$this->document->addScript('view/javascript/ckeditor/adapters/jquery.js');

		$data['text_form'] = !isset($this->request->get['mail_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/mail', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/mail|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/mail', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['mail_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/mail');

			$mail_info = $this->model_extension_tmdmultivendor_vendor_mail->getMail($this->request->get['mail_id']);
		}

		if (isset($this->request->get['mail_id'])) {
			$data['mail_id'] = (int)$this->request->get['mail_id'];
		} else {
			$data['mail_id'] = 0;
		}

		$data['sellertypes'] = [];
				
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellersignupmail'),
			'value' 		=> 'seller signup mail'
		];
		
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellerapprovemail'),
			'value' 		=> 'seller approve email'
		];
		
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellerdisapprovemail'),
			'value' 		=> 'seller disapprove email'
		];
		/* 18-06-2019 update */
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellerproduct'),
			'value' 		=> 'seller add product email to seller'
		];
		
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellerproductadmin'),
			'value' 		=> 'seller add product email to admin'
		];
		
		/* 18-06-2019 update */
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_productapprove'),
			'value' 		=> 'seller product approve email'
		];
		
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellerorder'),
			'value' 		=> 'customer to seller order email'
		];
		
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_orderstatusupdate'),
			'value' 		=> 'seller order status update email'
		];
		/* 18 06 2020 */
		
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_orderstatusupdateadmin'),
			'value' 		=> 'admin email on update seller order status '
		];
		/* 18 06 2020 */

		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_customerenquiry'),
			'value' 		=> 'seller and customer enquiry email'
		];
		//25-3-2019 start	
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellercontact'),
			'value' 		=> 'seller and customer contact email'
		];
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_sellerreply'),
			'value' 		=> 'seller reply email'
		];
		$data['sellertypes'][] = [
			'sellertype'    => $this->language->get('text_adminreply'),
			'value' 		=> 'admin reply email'
		];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->get['mail_id'])) {
			$data['seller_mail'] = $this->model_extension_tmdmultivendor_vendor_mail->getMailLanguage($this->request->get['mail_id']);
		} else {
			$data['seller_mail'] = [];
		}

		if (!empty($mail_info['sellertype'])) {
			$data['sellertype'] = $mail_info['sellertype'];
		} else {
			$data['sellertype'] = '';
		}
		
		if (!empty($mail_info['status'])) {
			$data['status'] = $mail_info['status'];
		} else {
			$data['status'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/mail_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/mail');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/mail')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['seller_mail'] as $language_id => $value) {
			if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 64)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}

		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/mail');

			if (!$this->request->post['mail_id']) {
				$json['mail_id'] = $this->model_extension_tmdmultivendor_vendor_mail->addMail($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_mail->editMail($this->request->post['mail_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/mail');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/mail')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/mail');

			foreach ($selected as $mail_id) {
				$this->model_extension_tmdmultivendor_vendor_mail->deleteMail($mail_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}