<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
class option extends \Opencart\System\Engine\Controller {


	public function index() {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', true));
		}
		$this->load->language('extension/tmdmultivendor/vendor/option');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/option');


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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/option')
		);

		

       	$data['list'] = $this->getList();

		$this->load->model('localisation/language');
            
	    $data['add'] = $this->url->link('extension/tmdmultivendor/vendor/option|getForm' . $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/option|delete', 'language=' . $this->config->get('config_language'));


		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/option', $data));
	}


	public function list(): void {

		$this->load->language('extension/tmdmultivendor/vendor/option');

		$this->response->setOutput($this->getList());
	}

	
	protected function getList() {

		 $this->load->model('extension/tmdmultivendor/vendor/option');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'od.name';
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

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/option|list',$url);

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home', '', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/option', '', true)
		);

	
		$data['options'] = array();

		$filter_data = array(
			'vendor_id' => $this->vendor->getId(),
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);

		$option_total = $this->model_extension_tmdmultivendor_vendor_option->getTotalOptions($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_option->getOptions($filter_data);

		foreach ($results as $result) {
			$data['options'][] = array(
				'option_id'  => $result['option_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'edit'       => $this->url->link('extension/tmdmultivendor/vendor/option|getForm','option_id=' . $result['option_id'] . $url, true)
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

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/option|list','sort=od.name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('extension/tmdmultivendor/vendor/option|list','sort=o.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $option_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/option|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($option_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($option_total - $this->config->get('config_pagination_admin'))) ? $option_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $option_total, ceil($option_total / $this->config->get('config_pagination_admin')));


		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('extension/tmdmultivendor/vendor/option_list', $data);
	}

	public function getForm() {

		$this->load->language('extension/tmdmultivendor/vendor/option');
		
		$this->document->setTitle($this->language->get('heading_title'));
		$data['text_form'] = !isset($this->request->get['option_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
	

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/option', '', true)
		);

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/option|save', 'language=' . $this->config->get('config_language'));
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/option', $url);

		

	
		if (isset($this->request->get['option_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/option');

			$option_info = $this->model_extension_tmdmultivendor_vendor_option->getOption($this->request->get['option_id']);
		}


		if (isset($this->request->get['option_id'])) {
			$data['option_id'] = $this->request->get['option_id'];
		} else {
			$data['option_id'] = 0;
		}
		
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['option_description'])) {
			$data['option_description'] = $this->request->post['option_description'];
		} elseif (isset($this->request->get['option_id'])) {
			$data['option_description'] = $this->model_extension_tmdmultivendor_vendor_option->getOptionDescriptions($this->request->get['option_id']);
		} else {
			$data['option_description'] = array();
		}

		if (isset($this->request->post['type'])) {
			$data['type'] = $this->request->post['type'];
		} elseif (!empty($option_info)) {
			$data['type'] = $option_info['type'];
		} else {
			$data['type'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($option_info)) {
			$data['sort_order'] = $option_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		if (isset($this->request->post['option_value'])) {
			$option_values = $this->request->post['option_value'];
		} elseif (isset($this->request->get['option_id'])) {
			$option_values = $this->model_extension_tmdmultivendor_vendor_option->getOptionValueDescriptions($this->request->get['option_id']);
		} else {
			$option_values = array();
		}

		$this->load->model('tool/image');

		$data['option_values'] = array();

		foreach ($option_values as $option_value) {
			if (is_file(DIR_IMAGE . $option_value['image'])) {
				$image = $option_value['image'];
				$thumb = $option_value['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['option_values'][] = array(
				'option_value_id'          => $option_value['option_value_id'],
				'option_value_description' => $option_value['option_value_description'],
				'image'                    => $image,
				'thumb'                    => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order'               => $option_value['sort_order']
			);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');


		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/option_form', $data));
	}


	public function delete(): void {

		$this->load->language('extension/tmdmultivendor/vendor/option');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		
		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/option');

			foreach ($selected as $option_id) {
				$this->model_extension_tmdmultivendor_vendor_option->deleteOption($option_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		 
	}



	public function save(): void {

	     $json = [];

		$this->load->language('extension/tmdmultivendor/vendor/option');
		$this->load->model('catalog/product');


		foreach ($this->request->post['option_description'] as $language_id => $value) {
			if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 128)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}
		}

    if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['option_value'])) {
			$json['error']['warning'] = $this->language->get('error_type');
		}

	

		if (isset($this->request->post['option_value'])) {
			foreach ($this->request->post['option_value'] as $option_value_id => $option_value) {
				foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
					if ((strlen(trim($option_value_description['name'])) < 1) || (strlen($option_value_description['name']) > 128)) {
						$json['error']['option_value_' . $option_value_id . '_' . $language_id] = $this->language->get('error_option_value');
					}
				}
			}
		}


      
		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/option');

			if (!$this->request->post['option_id']) {
				$json['option_id'] = $this->model_extension_tmdmultivendor_vendor_option->addOption($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_option->editOption($this->request->post['option_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');

			
		}



		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	
	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->language('extension/tmdmultivendor/vendor/option');

			$this->load->model('extension/tmdmultivendor/vendor/option');

			$this->load->model('tool/image');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'vendor_id'   => $this->vendor->getId(),
				'start'       => 0,
				'limit'       => 5
			);

			$options = $this->model_extension_tmdmultivendor_vendor_option->getOptions($filter_data);

			foreach ($options as $option) {
				$option_value_data = array();

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_values = $this->model_extension_tmdmultivendor_vendor_option->getOptionValues($option['option_id']);

					foreach ($option_values as $option_value) {
						if (is_file(DIR_IMAGE . $option_value['image'])) {
							$image = $this->model_tool_image->resize($option_value['image'], 50, 50);
						} else {
							$image = $this->model_tool_image->resize('no_image.png', 50, 50);
						}

						$option_value_data[] = array(
							'option_value_id' => $option_value['option_value_id'],
							'name'            => strip_tags(html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8')),
							'image'           => $image
						);
					}

					$sort_order = array();

					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}

					array_multisort($sort_order, SORT_ASC, $option_value_data);
				}

				$type = '';

				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox') {
					$type = $this->language->get('text_choose');
				}

				if ($option['type'] == 'text' || $option['type'] == 'textarea') {
					$type = $this->language->get('text_input');
				}

				if ($option['type'] == 'file') {
					$type = $this->language->get('text_file');
				}

				if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$type = $this->language->get('text_date');
				}

				$json[] = array(
					'option_id'    => $option['option_id'],
					'name'         => strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8')),
					'category'     => $type,
					'type'         => $option['type'],
					'option_value' => $option_value_data
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
			$file1=$this->model_tool_image->resize('catalog/'.$file, 45, 45);
			$json['file1'] = $file1;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}
