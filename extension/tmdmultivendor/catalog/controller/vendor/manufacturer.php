<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class Manufacturer extends \Opencart\System\Engine\Controller {
	// private $error = array();

	public function index(): void {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', 'SSL'));
		}
		$this->load->language('extension/tmdmultivendor/vendor/manufacturer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/manufacturer');

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/manufacturer')
		);

		

       	$data['list'] = $this->getList();

		 $this->load->model('localisation/language');
            
	    $data['add'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer|getForm'. $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer|delete', 'language=' . $this->config->get('config_language'));

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/manufacturer', $data));


	}

public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/manufacturer');

		$this->response->setOutput($this->getList());
	}
	

	protected function getList(): string {
        $this->load->model('extension/tmdmultivendor/vendor/manufacturer');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'm.name';
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer|list',$url);


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/manufacturer')
		);

		$data['manufacturers'] = array();

		$filter_data = array(
			'vendor_id' => $this->vendor->getId(),
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);

        $manufacturer_total = $this->model_extension_tmdmultivendor_vendor_manufacturer->getTotalManufacturers($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_manufacturer->getManufacturers($filter_data);
		
		foreach ($results as $result) {
			$data['manufacturers'][] = array(
				'manufacturer_id' => $result['manufacturer_id'],
				'name'        => $result['name'],
				'sort_order'        => $result['sort_order'],

				'edit'        => $this->url->link('extension/tmdmultivendor/vendor/manufacturer|getForm','manufacturer_id=' . $result['manufacturer_id'] . $url, 'SSL')
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

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer|list','sort=m.name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer|list','sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
       $data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $manufacturer_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/manufacturer|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($manufacturer_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($manufacturer_total - $this->config->get('config_pagination_admin'))) ? $manufacturer_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $manufacturer_total, ceil($manufacturer_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;



		
		return $this->load->view('extension/tmdmultivendor/vendor/manufacturer_list', $data);
	}

	public function getForm(): void {



        $this->load->language('extension/tmdmultivendor/vendor/manufacturer');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['manufacturer_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		$data['text_form']               = !isset($this->request->get['information_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
	
		
		


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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/manufacturer')
		);

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer|save', 'language=' . $this->config->get('config_language'));
		
		
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer', $url);


		if (isset($this->request->get['manufacturer_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/manufacturer');

	   $manufacturer_info = $this->model_extension_tmdmultivendor_vendor_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
		}



		if (isset($this->request->get['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->get['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}
		
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($manufacturer_info)) {
			$data['name'] = $manufacturer_info['name'];
		} else {
			$data['name'] = '';
		}

		

		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		if (isset($this->request->post['manufacturer_store'])) {
			$data['manufacturer_store'] = $this->request->post['manufacturer_store'];
		} elseif (isset($this->request->get['manufacturer_id'])) {
			$data['manufacturer_store'] = $this->model_extension_tmdmultivendor_vendor_manufacturer->getManufacturerStores($this->request->get['manufacturer_id']);
		} else {
			$data['manufacturer_store'] = array(0);
		}

		if (isset($this->request->post['product_seo_url'])) {
			$data['product_seo_url'] = $this->request->post['product_seo_url'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_seo_url'] = $this->model_vendor_product->getProductSeoUrls($this->request->get['product_id']);
		} else {
			$data['product_seo_url'] = array();
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($manufacturer_info)) {
			$data['image'] = $manufacturer_info['image'];
		} else {
			$data['image'] = '';
		}



		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($manufacturer_info) && is_file(DIR_IMAGE . $manufacturer_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($manufacturer_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($manufacturer_info)) {
			$data['sort_order'] = $manufacturer_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}
		
		

		$this->load->model('localisation/language');
		$this->load->model('extension/tmdmultivendor/vendor/manufacturer');

		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['manufacturer_seo_url'])) {
			$data['manufacturer_seo_url'] = $this->request->post['manufacturer_seo_url'];
		} elseif (isset($this->request->get['manufacturer_id'])) {
			$data['manufacturer_seo_url'] = $this->model_extension_tmdmultivendor_vendor_manufacturer->getManufacturerSeoUrls($this->request->get['manufacturer_id']);
		} else {
			$data['manufacturer_seo_url'] = array();
		}
				
		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/manufacturer_form', $data));
	}



	public function save(): void {

	    $json = [];

		$this->load->language('extension/tmdmultivendor/vendor/manufacturer');

		if (!$json) {
		if ((strlen($this->request->post['name']) < 1) || (strlen($this->request->post['name']) > 64)) {
			$json['error']['name'] = $this->language->get('error_name');
		}



		if ($this->request->post['manufacturer_seo_url']) {
			$this->load->model('extension/tmdmultivendor/vendor/seo_url');
			

			foreach ($this->request->post['manufacturer_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if ($keyword) {
						$seo_url_info = $this->model_extension_tmdmultivendor_vendor_seo_url->getSeoUrlsByKeyword($keyword, $store_id, $language_id);

						if ($seo_url_info && ($seo_url_info != 'manufacturer_id' || !isset($this->request->post['manufacturer_id']) || $seo_url_info['value'] != (int)$this->request->post['manufacturer_id'])) {
							$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_keyword');
						}
					} else {
						$json['error']['keyword_' . $store_id . '_' . $language_id] = $this->language->get('error_seo');
					}
				}
			}
		}

		}
       if (isset($json['error']) && !isset($json['error']['warning'])) {

			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/manufacturer');

			if (!$this->request->post['manufacturer_id']) {
				$json['manufacturer_id'] = $this->model_extension_tmdmultivendor_vendor_manufacturer->addManufacturer($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_manufacturer->editManufacturer($this->request->post['manufacturer_id'], $this->request->post);
			}

			 $json['success'] = $this->language->get('text_success');


			 // $json['redirect'] = $this->url->link('extension/tmdmultivendor/vendor/manufacturer', 'language=' . $this->config->get('config_language'), true);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/manufacturer');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		
		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/manufacturer');

			foreach ($selected as $manufacturer_id) {
				$this->model_extension_tmdmultivendor_vendor_manufacturer->deleteManufacturer($manufacturer_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}


	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/tmdmultivendor/vendor/manufacturer');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'vendor_id'   => $this->vendor->getId(),
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_extension_tmdmultivendor_vendor_manufacturer->getManufacturers($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'manufacturer_id' => $result['manufacturer_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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

	public function uploadprofileimage() {
		$this->load->language('tool/upload');
		$this->load->model('tool/image');


		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
		// Sanitize the filename
		$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

		// Validate the filename length
		if ((strlen($filename) < 3) || (strlen($filename) > 64)) {
			$json['error'] = $this->language->get('error_filename');
		}

		// Allowed file extension types
		$allowed = array();

		$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

		$filetypes = explode("\n", $extension_allowed);

		foreach ($filetypes as $filetype) {
			$allowed[] = trim($filetype);
		}

		if (!in_array(strtolower(substr(strrchr($filename, '.'), 1)), $allowed)) {
			$json['error'] = $this->language->get('error_filetype');
		}

		// Allowed file mime types
		$allowed = array();

		$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

		$filetypes = explode("\n", $mime_allowed);

		foreach ($filetypes as $filetype) {
			$allowed[] = trim($filetype);
		}

		if (!in_array($this->request->files['file']['type'], $allowed)) {
			$json['error'] = $this->language->get('error_filetype');
		}

		// Check to see if any PHP files are trying to be uploaded
		$content = file_get_contents($this->request->files['file']['tmp_name']);

		if (preg_match('/\<\?php/i', $content)) {
			$json['error'] = $this->language->get('error_filetype');
		}

		// Return any upload error
		if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
			$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
		}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json) {
			$file = md5(mt_rand()).$filename ;
			// print_r($file);die();

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_IMAGE.'catalog/' . $file);

			// Hide the uploaded file name so people can not link to it directly.
			$this->load->model('tool/upload');

			$json['success'] = $this->language->get('text_upload');
			$json['file'] ='catalog/'.$file;
			$file1=$this->model_tool_image->resize('catalog/'.$file, 100, 100);
			$json['file1'] = $file1;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}
