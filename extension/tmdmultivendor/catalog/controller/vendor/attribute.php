<?php
namespace Opencart\Catalog\Controller\extension\Tmdmultivendor\Vendor;
class attribute extends \Opencart\System\Engine\Controller {

	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', 'SSL'));
		}
		$this->load->language('extension/tmdmultivendor/vendor/attribute');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/attribute');

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/attribute')
		);	

       	$data['list'] = $this->getList();

		$this->load->model('localisation/language');
            
	    $data['add'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|getForm' . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|delete');
		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/attribute', $data));
	}


	public function list(): void {

		$this->load->language('extension/tmdmultivendor/vendor/attribute');

		$this->response->setOutput($this->getList());
	}


	protected function getList() {
		 $this->load->model('extension/tmdmultivendor/vendor/attribute');
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ad.name';
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/attribute')
		);

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|list',$url);

		$data['attributes'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'vendor_id'  => $this->vendor->getId(),
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);

		$attribute_total = $this->model_extension_tmdmultivendor_vendor_attribute->getTotalAttributes($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_attribute->getAttributes($filter_data);

		foreach ($results as $result) {
			$data['attributes'][] = array(
				'attribute_id'    => $result['attribute_id'],
				'name'            => $result['name'],
				'attribute_group' => $result['attribute_group'],
				'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('extension/tmdmultivendor/vendor/attribute|getForm','attribute_id=' . $result['attribute_id'] . $url, 'SSL')
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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|list','sort=ad.name' . $url, 'SSL');
		$data['sort_attribute_group'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|list','sort=attribute_group' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|list','sort=a.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $attribute_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/attribute|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($attribute_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($attribute_total - $this->config->get('config_pagination_admin'))) ? $attribute_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $attribute_total, ceil($attribute_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;	


		   return $this->load->view('extension/tmdmultivendor/vendor/attribute_list', $data);
	}

	public function getForm() {

		$this->load->language('extension/tmdmultivendor/vendor/attribute');
		
		$this->document->setTitle($this->language->get('heading_title'));
		$data['text_form'] = !isset($this->request->get['attribute_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
	

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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/attribute', '', true)
		);

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/attribute|save', 'language=' . $this->config->get('config_language'));
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/attribute', $url);

		

	
		if (isset($this->request->get['attribute_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/attribute');

			$attribute_info = $this->model_extension_tmdmultivendor_vendor_attribute->getAttribute($this->request->get['attribute_id']);
		}


		if (isset($this->request->get['attribute_id'])) {
			$data['attribute_id'] = $this->request->get['attribute_id'];
		} else {
			$data['attribute_id'] = 0;
		}
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		
		if (isset($this->request->post['attribute_description'])) {
			$data['attribute_description'] = $this->request->post['attribute_description'];
		} elseif (isset($this->request->get['attribute_id'])) {
			$data['attribute_description'] = $this->model_extension_tmdmultivendor_vendor_attribute->getAttributeDescriptions($this->request->get['attribute_id']);
		} else {
			$data['attribute_description'] = array();
		}

		if (isset($this->request->post['attribute_group_id'])) {
			$data['attribute_group_id'] = $this->request->post['attribute_group_id'];
		} elseif (!empty($attribute_info)) {
			$data['attribute_group_id'] = $attribute_info['attribute_group_id'];
		} else {
			$data['attribute_group_id'] = '';
		}

		$this->load->model('extension/tmdmultivendor/vendor/attribute_group');

		$filter1=array(
			'vendor_id'  => $this->vendor->getId()
		);

		$data['attribute_groups'] = $this->model_extension_tmdmultivendor_vendor_attribute_group->getAttributeGroups($filter1);
		
		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($attribute_info)) {
			$data['sort_order'] = $attribute_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}


		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');
	
		
		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/attribute_form', $data));
	}


	public function save(): void {
		$this->load->language('extension/tmdmultivendor/vendor/attribute');

	     $json = [];

		

		foreach ($this->request->post['attribute_description'] as $language_id => $value) {
			if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 128)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}
		}

    

	   if (isset($json['error']) && !isset($json['error']['warning'])) {

			$json['error']['warning'] = $this->language->get('error_warning');
		}


		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/attribute');

			if (!$this->request->post['attribute_id']) {
				$json['attribute_id'] = $this->model_extension_tmdmultivendor_vendor_attribute->addAttribute($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_attribute->editAttribute($this->request->post['attribute_id'], $this->request->post);
			}

		$json['success'] = $this->language->get('text_success');
			 
        // $json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/attribute', 'language=' . $this->config->get('config_language'), true);

		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
       
	}


	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/attribute');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		
		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/attribute');

			foreach ($selected as $attribute_id) {
				$this->model_extension_tmdmultivendor_vendor_attribute->deleteAttribute($attribute_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}



	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/tmdmultivendor/vendor/attribute');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'vendor_id'   => $this->vendor->getId(),
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_extension_tmdmultivendor_vendor_attribute->getAttributes($filter_data);

			

			foreach ($results as $result) {
				$json[] = array(
					'attribute_id'    => $result['attribute_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'attribute_group' => $result['attribute_group']
				);
			}
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
