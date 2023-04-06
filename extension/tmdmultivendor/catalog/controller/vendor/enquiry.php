<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class enquiry extends \Opencart\System\Engine\Controller {
	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		$this->load->language('extension/tmdmultivendor/vendor/enquiry');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/enquiry');

        $url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
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
			'href' => $this->url->link('common/home')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/enquiry'.$url)
		];

		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|delete');

       	$data['list'] = $this->getList();

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/enquiry', $data));
	}

	public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/enquiry');

		$this->response->setOutput($this->getList());
	}


	protected function getList(): string {

       $this->load->language('extension/tmdmultivendor/vendor/enquiry');
		$this->load->model('extension/tmdmultivendor/vendor/enquiry');


		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = '';
		}
		
		
		if (isset($this->request->get['filter_enqname'])) {
			$filter_enqname = $this->request->get['filter_enqname'];
		} else {
			$filter_enqname = '';
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
	
		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
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

		$url = '';
        

        if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}
	
		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
		}
		

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}


		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list',$url);


		$data['enquires'] = array();

		$filter_data = array(
			'vendor_id' 		=> $this->vendor->getId(),
			/* 12 02 2020 */			
			
			/* 12 02 2020 */
			'filter_product'    => $filter_product,
			'filter_enqname'       => $filter_enqname,			
			'filter_date_added' => $filter_date_added,
			'sort'              => $sort,
			'order'             => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);



		$this->load->model('extension/tmdmultivendor/vendor/product');
		$this->load->model('extension/tmdmultivendor/vendor/enquiry');
		$enquiry_total = $this->model_extension_tmdmultivendor_vendor_enquiry->getTotalgetEnquiries($filter_data);
		$results = $this->model_extension_tmdmultivendor_vendor_enquiry->getEnquiries($filter_data);
		/* 28 01 2020 */
		$vendor_id= $this->vendor->getId();		
		/* 28 01 2020 */
		foreach ($results as $result) {
			$product_info = $this->model_extension_tmdmultivendor_vendor_product->getProduct($result['product_id'], $vendor_id);


			if(!empty($product_info)){
				$pname = $product_info['name'];
			} else {
				$pname = '';
			}

			$customer_info = $this->model_extension_tmdmultivendor_vendor_enquiry->getCustomer($result['customer_id']);
			/* 19 02 2020 */
			if(!empty($customer_info['firstname'])){
				$cname = '<span class="label label-success">'.$customer_info['firstname'].' '.$customer_info['lastname'].'</span>';
			} else {
				$cname = '<span class="label label-info">'.$this->language->get('text_guest').'</span>';
			}
			/* 19 02 2020 */
			$data['enquires'][] = array(
				'inquiry_id'   => $result['inquiry_id'],
				'name'         => $result['name'],
				'email'         => $result['email'],
				'pname'        => $pname,
				'cname'        => $cname,
				'description' => html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'),
				'status'       => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'date_added'   => $result['date_added'],
				// <!--07-03-2019 update-->
				'producturl'   =>  $this->url->link('product/product','product_id=' . $result['product_id'] . $url, true)
				// <!--07-03-2019 update-->
			);
		}
		
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
		
	
		
		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
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

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'sort=name' . $url, true);
		$data['sort_email'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list', 'sort=email' . $url, true);
		$data['sort_product'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list','sort=product' . $url, true);
		$data['sort_customer'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list','sort=customer' . $url, true);
		$data['sort_status'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list','sort=status' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/tmdmultivendor/vendor/enquiry|list','sort=date_added' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

	

		if (isset($this->request->get['filter_enqname'])) {
			$url .= '&filter_enqname=' . urlencode(html_entity_decode($this->request->get['filter_enqname'], ENT_QUOTES, 'UTF-8'));
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
			'total' => $enquiry_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/enquiry|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($enquiry_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($enquiry_total - $this->config->get('config_pagination_admin'))) ? $enquiry_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $enquiry_total, ceil($enquiry_total / $this->config->get('config_pagination_admin')));
		
		/* 28 01 2020 */
		
		
		$data['filter_product'] = $filter_product;
		

		$data['filter_enqname'] = $filter_enqname;

		
		
		$data['filter_date_added'] = $filter_date_added;

		$data['sort'] = $sort;
		$data['order'] = $order;
		/* tmd vendor2 customer condtion  */
		$data['vendor2customer'] = $this->config->get('vendor_vendor2customer');
		/* tmd vendor2 customer condtion  */
		
		return $this->load->view('extension/tmdmultivendor/vendor/enquiry_list', $data);
	}

	/* update function 12 02 2020 */
	public function autocomplete(){
		
		if (isset($this->request->get['filter_enqname'])) {
			$filter_enqname = $this->request->get['filter_enqname'];
		} else {
			$filter_enqname = '';
		}
	
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
		$this->load->model('extension/tmdmultivendor/vendor/enquiry');
			
		$filter_data = array(
		'sort'  => $sort,
		'order' => $order,
		'filter_enqname' => $filter_enqname,
		'start'            => 0,
		'limit'            => 5
		);
		$enqnames = $this->model_extension_tmdmultivendor_vendor_enquiry->getEnquiries($filter_data);
		foreach ($enqnames as $enqname) {

		$json[] = array(
		'inquiry_id'  => $enqname['inquiry_id'],
		'name'              => strip_tags(html_entity_decode($enqname['name'], ENT_QUOTES, 'UTF-8'))
		);
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
}
