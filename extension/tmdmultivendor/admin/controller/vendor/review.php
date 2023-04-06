<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;
use \Opencart\System\Helper as Helper;
class Review extends \Opencart\System\Engine\Controller { 
	public function index(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/review|form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/review|delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/review', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review');

		$this->response->setOutput($this->getList());
	}

	protected function getList(): string {
		if (isset($this->request->get['filter_category'])) {
			$filter_category = $this->request->get['filter_category'];
		} else {
			$filter_category = '';
		}

		if (isset($this->request->get['filter_vendor'])) {
			$filter_vendor = $this->request->get['filter_vendor'];
		} else {
			$filter_vendor = '';
		}

		if (isset($this->request->get['filter_author'])) {
			$filter_author = $this->request->get['filter_author'];
		} else {
			$filter_author = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.date_added';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/review|list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['reviews'] = [];

		$filter_data = [
			'filter_category'   => $filter_category,
			'filter_vendor'     => $filter_vendor,
			'filter_author'     => $filter_author,
			'filter_status'     => $filter_status,
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/review');

		$review_total = $this->model_extension_tmdmultivendor_vendor_review->getTotalReview($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_review->getReviews($filter_data);

		foreach ($results as $result) {
			$sellers = $this->model_extension_tmdmultivendor_vendor_review->getVendor($result['vendor_id']);
			if(isset($sellers['sname'])){
				$sname = $sellers['sname'];
			} else {
				$sname ='';
			}
			$customers = $this->model_extension_tmdmultivendor_vendor_review->getCustomer($result['customer_id']);
			if(isset($customers['firstname'])){
				$cname = $customers['firstname'].' '.$customers['lastname'];
			} else {
				$cname ='';
			}
			
			  /* 18-02-2020 start */
		    $this->load->model('extension/tmdmultivendor/vendor/vendor');
		   
			$textss = $result['text'];			
			if ((Helper\Utf8\strlen($textss) > 200)) {
				$text = utf8_substr(trim(strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8'))), 0, 199) .'<a class="readmore " data-bs-toggle="modal" data-bs-target="#viewfullreview'.$result['review_id'].'">'.$this->language->get('text_readmore').' <i class="fa fa-info-circle" aria-hidden="true"></i></a>';	
			} else {
				$text = $result['text'];				
			}
			
			$view = '<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewfullreview'.$result['review_id'].'"><i class="fa fa-eye"></i></a>';
			
				$reviewvalue=array();
				$rating_infos = $this->model_extension_tmdmultivendor_vendor_review->getField($result['review_id'],$result['vendor_id']);
				
				foreach($rating_infos as $rating_info){
					$reviewvalue[]=array(
						'field_name'=> $rating_info['field_name'],
						'value' 	=> $rating_info['value']						
					);
				}				
			
			/* 18-02-2020 end */
			
			$data['reviews'][] = array(
				'review_id'   => $result['review_id'],
				'date_added'  => $result['date_added'],
				'sname'       => $sname,
				'cname'       => $cname,
				/* 18 02 2020 */
				'reviewvalue' => $reviewvalue,
				'text'        => $text,
				'fulltext'    => strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')),
				/* 18 02 2020 */
				'status'      => ($result['status'] ? $this->language->get('text_enable') : $this->language->get('text_disable')),
				'edit'       => $this->url->link('extension/tmdmultivendor/vendor/review|form', 'user_token=' . $this->session->data['user_token'] . '&review_id=' . $result['review_id'] . $url)
			);

		}

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_seller']   = $this->url->link('extension/tmdmultivendor/vendor/review|list', 'user_token=' . $this->session->data['user_token'] . '&sort=seller' . $url, true);
		$data['sort_status']   = $this->url->link('extension/tmdmultivendor/vendor/review|list', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_date']     = $this->url->link('extension/tmdmultivendor/vendor/review|list', 'user_token=' . $this->session->data['user_token'] . '&sort=date' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $review_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/review|list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($review_total - $this->config->get('config_pagination_admin'))) ? $review_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $review_total, ceil($review_total / $this->config->get('config_pagination_admin')));

		$data['filter_category'] = $filter_category;
		$data['filter_vendor'] = $filter_vendor;
		$data['filter_author'] = $filter_author;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/review_list', $data);
	}

	public function form(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['review_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['filter_category'])) {
			$url .= '&filter_category=' . urlencode(html_entity_decode($this->request->get['filter_category'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor'])) {
			$url .= '&filter_vendor=' . urlencode(html_entity_decode($this->request->get['filter_vendor'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_author'])) {
			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/review|save', 'user_token=' . $this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/review', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['review_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/review');

			$review_info = $this->model_extension_tmdmultivendor_vendor_review->getReview($this->request->get['review_id']);
		}

		if (isset($this->request->get['review_id'])) {
			$data['review_id'] = (int)$this->request->get['review_id'];
		} else {
			$data['review_id'] = 0;
		}

		$this->load->model('extension/tmdmultivendor/vendor/product');
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		if (isset($review_info)) {
			$data['text'] = $review_info['text'];
		} else {
			$data['text'] = '';
		}
		
		if (!empty($review_info)) {
			$data['customer_id'] = $review_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}
				
		$this->load->model('customer/customer');
		if (!empty($review_info)) {
			$customer_info = $this->model_customer_customer->getCustomer($review_info['customer_id']);

			if ($customer_info) {
				$data['customer'] = $customer_info['firstname'].' '.$customer_info['lastname'];
			} else {
				$data['customer'] = '';
			}
		} else {
			$data['customer'] = '';
		}
		
		if (!empty($review_info)) {
			$data['vendor_id'] = $review_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}

		if (!empty($review_info)) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($review_info['vendor_id']);

			if ($vendor_info) {
				$data['vendor'] = $vendor_info['firstname'].' '.$vendor_info['lastname'];
			} else {
				$data['vendor'] = '';
			}
		} else {
			$data['vendor'] = '';
		}
				
		if (isset($review_info)) {
			$data['status'] = $review_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($review_info)) {
			$data['reviewfield'] = $this->model_extension_tmdmultivendor_vendor_review->getFieldSubmits($this->request->get['review_id']);
		} else {
			$data['reviewfield'] = array();
		}
	

		$data['review_fieldselect'] = array();
		foreach ($data['reviewfield'] as $reviewid) {
			$review_fields = $this->model_extension_tmdmultivendor_vendor_review->getReviewFielddescription($reviewid['rf_id']);
			if($review_fields['field_name']){
				$fieldname=$review_fields['field_name'];
			}else{
				$fieldname='';
			}

			$data['review_fieldselect'][]=array(
		     	 'review_id'    => $reviewid['review_id'],
		      	 'value'     	=> $reviewid['value'],
		     	 'field_name'   => $fieldname,
		     	 'rf_id'        => $reviewid['rf_id'] 
		    );
		}
		
		$this->load->model('extension/tmdmultivendor/vendor/review_field');
		$data['review_fields'] = $this->model_extension_tmdmultivendor_vendor_review_field->getReviewFields($data);

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/review_form', $data));
	}

	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/review')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if (!isset($this->request->post['customer']) || $this->request->post['customer']=='') {
			$json['error']['customer'] = $this->language->get('error_customer');
		}
		
		if (!isset($this->request->post['vendor']) || $this->request->post['vendor']=='') {
			$json['error']['vendor'] = $this->language->get('error_vendor');
		}

		if (Helper\Utf8\strlen($this->request->post['text']) < 1) {
			$json['error']['text'] = $this->language->get('error_text');
		}


		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/review');

			if (!$this->request->post['review_id']) {
				$json['review_id'] = $this->model_extension_tmdmultivendor_vendor_review->addReview($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_review->editReview($this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/review')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/review');

			foreach ($selected as $review_id) {
				$this->model_extension_tmdmultivendor_vendor_review->deleteReview($review_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete(){	
		$json = [];

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}
	
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'firstname';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		$this->load->model('extension/tmdmultivendor/vendor/vendor');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'filter_customer' => $filter_customer,
		'start'            => 0,
		'limit'            => 5
		);
		$accounts = $this->model_extension_tmdmultivendor_vendor_vendor->getCustomers($filter_data);
		foreach ($accounts as $account) {
		
		$json[] = array(
		'customer_id'  => $account['customer_id'],
		'name'              => strip_tags(html_entity_decode($account['name'], ENT_QUOTES, 'UTF-8')),
		'firstname'   => strip_tags(html_entity_decode($account['firstname'], ENT_QUOTES, 'UTF-8'))
		);
		}
		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['firstname'];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}
