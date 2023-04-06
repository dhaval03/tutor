<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class review extends \Opencart\System\Engine\Controller {


	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		$this->load->language('extension/tmdmultivendor/vendor/review');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/review');
		

		$data['list'] = $this->getList();

		$this->load->model('localisation/language');

		$url = '';

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review',$url)
		];

	     

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

     $this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/review', $data));

	}


	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/review');
		

		$this->response->setOutput($this->getList());
	}

	// public function add() {
	// 	$this->load->language('extension/tmdmultivendor/vendor/review');

	// 	$this->document->setTitle($this->language->get('heading_title'));

	// 	$this->load->model('extension/tmdmultivendor/vendor/review');

	// 	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	// 		$this->model_extension_tmdmultivendor_vendor_review->addReview($this->request->post);

	// 		$this->session->data['success'] = $this->language->get('text_success');

	// 		$url = '';

	// 		if (isset($this->request->get['filter_product'])) {
	// 			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
	// 		}

	// 		if (isset($this->request->get['filter_author'])) {
	// 			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
	// 		}

	// 		if (isset($this->request->get['filter_status'])) {
	// 			$url .= '&filter_status=' . $this->request->get['filter_status'];
	// 		}

	// 		if (isset($this->request->get['filter_date_added'])) {
	// 			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
	// 		}

	// 		if (isset($this->request->get['sort'])) {
	// 			$url .= '&sort=' . $this->request->get['sort'];
	// 		}

	// 		if (isset($this->request->get['order'])) {
	// 			$url .= '&order=' . $this->request->get['order'];
	// 		}

	// 		if (isset($this->request->get['page'])) {
	// 			$url .= '&page=' . $this->request->get['page'];
	// 		}

	// 		$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/review'));
	// 	}

	// 	$this->getForm();
	// }

	// public function edit() {
	// 	$this->load->language('extension/tmdmultivendor/vendor/review');

	// 	$this->document->setTitle($this->language->get('heading_title'));

	// 	$this->load->model('extension/tmdmultivendor/vendor/review');

	// 	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	// 		$this->model_extension_tmdmultivendor_vendor_review->editReview($this->request->get['review_id'], $this->request->post);

	// 		$this->session->data['success'] = $this->language->get('text_success');

	// 		$url = '';

	// 		if (isset($this->request->get['filter_product'])) {
	// 			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
	// 		}

	// 		if (isset($this->request->get['filter_author'])) {
	// 			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
	// 		}

	// 		if (isset($this->request->get['filter_status'])) {
	// 			$url .= '&filter_status=' . $this->request->get['filter_status'];
	// 		}

	// 		if (isset($this->request->get['filter_date_added'])) {
	// 			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
	// 		}

	// 		if (isset($this->request->get['sort'])) {
	// 			$url .= '&sort=' . $this->request->get['sort'];
	// 		}

	// 		if (isset($this->request->get['order'])) {
	// 			$url .= '&order=' . $this->request->get['order'];
	// 		}

	// 		if (isset($this->request->get['page'])) {
	// 			$url .= '&page=' . $this->request->get['page'];
	// 		}

	// 		$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/review'));
	// 	}

	// 	$this->getForm();
	// }

	// public function delete() {
	// 	$this->load->language('extension/tmdmultivendor/vendor/review');

	// 	$this->document->setTitle($this->language->get('heading_title'));

	// 	$this->load->model('extension/tmdmultivendor/vendor/review');
	

	// 	if (isset($this->request->post['selected'])) {
	// 		foreach ($this->request->post['selected'] as $review_id) {
	// 			$this->model_extension_tmdmultivendor_vendor_review->deleteReview($review_id);
	// 		}

	// 		$this->session->data['success'] = $this->language->get('text_success');

	// 		$url = '';

	// 		if (isset($this->request->get['filter_product'])) {
	// 			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
	// 		}

	// 		if (isset($this->request->get['filter_author'])) {
	// 			$url .= '&filter_author=' . urlencode(html_entity_decode($this->request->get['filter_author'], ENT_QUOTES, 'UTF-8'));
	// 		}

	// 		if (isset($this->request->get['filter_status'])) {
	// 			$url .= '&filter_status=' . $this->request->get['filter_status'];
	// 		}

	// 		if (isset($this->request->get['filter_date_added'])) {
	// 			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
	// 		}

	// 		if (isset($this->request->get['sort'])) {
	// 			$url .= '&sort=' . $this->request->get['sort'];
	// 		}

	// 		if (isset($this->request->get['order'])) {
	// 			$url .= '&order=' . $this->request->get['order'];
	// 		}

	// 		if (isset($this->request->get['page'])) {
	// 			$url .= '&page=' . $this->request->get['page'];
	// 		}

	// 		$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/review'));
	// 	}

	// 	$this->getList();
	// }

	protected function getList() {


		
		
		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = '';
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
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review')
		);

		$data['add'] = $this->url->link('extension/tmdmultivendor/vendor/review/add');
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/review/delete');

		$data['reviews'] = array();

		$filter_data = array(
			'vendor_id' 		=> $this->vendor->getId(),
			'filter_product'    => $filter_product,
			'filter_author'     => $filter_author,
			'filter_status'     => $filter_status,
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		);
		

		$review_total = $this->model_extension_tmdmultivendor_vendor_review->getTotalReview($this->vendor->getId());
		/* new code for review changes  name */
		$results = $this->model_extension_tmdmultivendor_vendor_review->getvendorReview($this->vendor->getId());




		foreach ($results as $result) {
            $sellers = $this->model_extension_tmdmultivendor_vendor_review->getVendor($result['vendor_id']);
            
			if(isset($sellers['firstname'])){
				$sname = $sellers['firstname'];
			} else {
				$sname ='';
			}
			$customers = $this->model_extension_tmdmultivendor_vendor_review->getCustomer($result['customer_id']);
			if(isset($customers['firstname'])){
				$cname = $customers['firstname'];
			} else {
				$cname ='';
			}
			
            /* 28-01-2020 start */
		    $this->load->model('extension/tmdmultivendor/vendor/vendor');
		   
			$textss = $result['text'];

			

			// print_r($textss);	

			if (($textss) > 120) {
				$text = '<a class="readmore " data-bs-toggle="modal" data-bs-target="#viewfullreview'.$result['review_id'].'"> '.$this->language->get('text_readmore').' <i class="fa fa-info-circle" aria-hidden="true"></i></a>';	
			} else {
				$text = $result['text'];				
			}
			
			$view = '<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewfullreview'.$result['review_id'].'"><i class="fa fa-eye"></i></a>';
			
			$reviewvalue=array();

				$rating_infos = $this->model_extension_tmdmultivendor_vendor_vendor->getField($result['review_id'],$result['vendor_id']);

				
				
				foreach($rating_infos as $rating_info){
					$reviewvalue[]=array(
						'field_name'=> $rating_info['field_name'],
						'value' 	=> $rating_info['value']						
					);
				}

		
			/* 28-01-2020 end */
			  
			$data['reviews'][] = array(
				'review_id'   => $result['review_id'],
				'sname'       => $sname,
				'cname'       => $cname,
				/* 28-01-2020 start */
				'view'        => $view,
				'reviewvalue' => $reviewvalue,
				'text'        => $text,
				'fulltext'    => strip_tags(html_entity_decode($result['text'], ENT_QUOTES, 'UTF-8')),
				/* 28-01-2020 end */
				'status'      => ($result['vstatus']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'  => ($result['date_added']),
				'edit'        => $this->url->link('extension/tmdmultivendor/vendor/review|edit','&review_id=' . $result['review_id'] . $url, true)
			);
		}

		
		/* new code for review changes  name */
		
		/* tmd vendor2 customer condtion  */
		$data['customer2vendor'] = $this->config->get('vendor_vendor2customer');
		/* tmd vendor2 customer condtion  */
		
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
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

		$data['sort_product'] = $this->url->link('extension/tmdmultivendor/vendor/review','sort=pd.name' . $url, true);
		$data['sort_author'] = $this->url->link('extension/tmdmultivendor/vendor/review', 'sort=r.author' . $url, true);
		$data['sort_rating'] = $this->url->link('extension/tmdmultivendor/vendor/review','sort=r.rating' . $url, true);
		$data['sort_status'] = $this->url->link('extension/tmdmultivendor/vendor/review','sort=r.status' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/tmdmultivendor/vendor/review','sort=r.date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
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
			'url'   => $this->url->link('catalog/product|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($review_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($review_total - $this->config->get('config_pagination_admin'))) ? $review_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $review_total, ceil($review_total / $this->config->get('config_pagination_admin')));
		
		$data['filter_product'] = $filter_product;
		$data['filter_author'] = $filter_author;
		$data['filter_status'] = $filter_status;
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;

		
		
		
		return $this->load->view('extension/tmdmultivendor/vendor/review_list', $data);
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['review_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_author'] = $this->language->get('entry_author');
		$data['entry_rating'] = $this->language->get('entry_rating');
		$data['entry_date_added'] = $this->language->get('entry_date_added');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_text'] = $this->language->get('entry_text');

		$data['help_product'] = $this->language->get('help_product');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		
		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
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
        
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/review')
		);

		if (!isset($this->request->get['review_id'])) {
			$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/review/add');
		} else {
			$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/review/edit','review_id=' . $this->request->get['review_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('extension/tmdmultivendor/vendor/review');

		if (isset($this->request->get['review_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$review_info = $this->model_extension_tmdmultivendor_vendor_review->getReview($this->request->get['review_id']);
		}
				
		if (isset($this->request->post['text'])) {
			$data['text'] = $this->request->post['text'];
		} elseif (isset($review_info)) {
			$data['text'] = $review_info['text'];
		} else {
			$data['text'] = '';
		}
		
		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($review_info)) {
			$data['customer_id'] = $review_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}

		$this->load->model('account/customer');
		if (isset($this->request->post['customer'])) {
			$data['customer'] = $this->request->post['customer'];
		} elseif (!empty($review_info)) {
			$customer_info = $this->model_account_customer->getCustomer($review_info['customer_id']);

			if ($customer_info) {
				$data['customer'] = $customer_info['firstname'];
			} else {
				$data['customer'] = '';
			}
		} else {
			$data['customer'] = '';
		}
		
		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_id'] = $this->request->post['vendor_id'];
		} elseif (!empty($review_info)) {
			$data['vendor_id'] = $review_info['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}

		$this->load->model('extension/ymdmultyivevendor/vendor');
		if (isset($this->request->post['vendor'])) {
			$data['vendor'] = $this->request->post['vendor'];
		} elseif (!empty($review_info)) {
			$vendor_info = $this->model_extension_tmdmultivendor_vendor_vendor->getVendor($review_info['vendor_id']);

			if ($vendor_info) {
				$data['vendor'] = $vendor_info['firstname'];
			} else {
				$data['vendor'] = '';
			}
		} else {
			$data['vendor'] = '';
		}
				
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (isset($review_info)) {
			$data['status'] = $review_info['status'];
		} else {
			$data['status'] = '';
		}
		
		if (isset($this->request->post['reviewfield'])) {
			$data['reviewfield'] = $this->request->post['reviewfield'];
		} elseif (isset($review_info)) {
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
        /* tmd vendor2 customer condtion  */
		$data['customer2vendor'] = $this->config->get('vendor_vendor2customer');
		/* tmd vendor2 customer condtion  */
		
	$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');
	/* 28 01 2020 comment file */
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/review_form', $data));
	}

	// protected function validateForm() {
		
	// 	if (strlen($this->request->post['text']) < 1) {
	// 		$this->error['text'] = $this->language->get('error_text');
	// 	}

	// 	return !$this->error;
	// }

}
