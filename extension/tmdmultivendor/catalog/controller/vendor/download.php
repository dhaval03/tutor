<?php
namespace Opencart\Catalog\Controller\Extension\Tmdmultivendor\Vendor;
use \Opencart\System\Helper as Helper;
class download extends \Opencart\System\Engine\Controller {
	// private $error = array();

	public function index(): void {
		if (!$this->vendor->isLogged()) {
			$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/login', '', 'SSL'));
		}
		$this->load->language('extension/tmdmultivendor/vendor/download');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/tmdmultivendor/vendor/download');

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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/download')
		);

		

       	$data['list'] = $this->getList();

		 $this->load->model('localisation/language');
            
	    $data['add'] = $this->url->link('extension/tmdmultivendor/vendor/download|getForm'. $url);
		$data['delete'] = $this->url->link('extension/tmdmultivendor/vendor/download|delete', 'language=' . $this->config->get('config_language'));

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/download', $data));


	}

public function list(): void {
		$this->load->language('extension/tmdmultivendor/vendor/download');

		$this->response->setOutput($this->getList());
	}
	

	protected function getList(): string {
        $this->load->model('extension/tmdmultivendor/vendor/download');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.name';
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


      $data['action'] = $this->url->link('extension/tmdmultivendor/vendor/download|list',$url);
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/download')
		);

		$data['downloads'] = array();

		$filter_data = array(
			'vendor_id' => $this->vendor->getId(),
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit' => $this->config->get('config_pagination_admin')
		);

		$download_total = $this->model_extension_tmdmultivendor_vendor_download->getTotalDownloads($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_download->getDownloads($filter_data);

		foreach ($results as $result) {
			$data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'edit'        => $this->url->link('extension/tmdmultivendor/vendor/download|getForm','download_id=' . $result['download_id'] . $url, 'SSL')
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

		$data['sort_name'] = $this->url->link('extension/tmdmultivendor/vendor/download|list','sort=dd.name' . $url, 'SSL');
		$data['sort_date_added'] = $this->url->link('extension/tmdmultivendor/vendor/download|list','sort=d.date_added' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
       $data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $download_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('extension/tmdmultivendor/vendor/download|list' . $url . '&page={page}')
		]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($download_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_pagination_admin')) > ($download_total - $this->config->get('config_pagination_admin'))) ? $download_total : ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), $download_total, ceil($download_total / $this->config->get('config_pagination_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		
		return $this->load->view('extension/tmdmultivendor/vendor/download_list', $data);
	}

	public function getForm(): void {

		

        $this->load->language('extension/tmdmultivendor/vendor/download');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['download_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		
		$data['text_form']               = !isset($this->request->get['information_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
	
		
		// Use the ini_get('upload_max_filesize') for the max file size
		$data['error_upload_size'] = sprintf($this->language->get('error_upload_size'), ini_get('upload_max_filesize'));

		$data['config_file_max_size'] = ((int)preg_filter('/[^0-9]/', '', ini_get('upload_max_filesize')) * 1024 * 1024);


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
			'href' => $this->url->link('extension/tmdmultivendor/vendor/download')
		);

		

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/download|save', 'language=' . $this->config->get('config_language'));
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/download', $url);


		$this->load->model('localisation/language');
     
        $data['languages'] = $this->model_localisation_language->getLanguages();
		

		if (isset($this->request->get['download_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/download');

			$download_info = $this->model_extension_tmdmultivendor_vendor_download->getDownload($this->request->get['download_id']);
		}


		if (isset($this->request->get['download_id'])) {
			$data['download_id'] = $this->request->get['download_id'];
		} else {
			$data['download_id'] = 0;
		}

		if (isset($this->request->post['download_description'])) {
			$data['download_description'] = $this->request->post['download_description'];
		} elseif (isset($this->request->get['download_id'])) {
			$data['download_description'] = $this->model_extension_tmdmultivendor_vendor_download->getDownloadDescriptions($this->request->get['download_id']);
		} else {
			$data['download_description'] = array();
		}

		if (isset($this->request->post['filename'])) {
			$data['filename'] = $this->request->post['filename'];
		} elseif (!empty($download_info)) {
			$data['filename'] = $download_info['filename'];
		} else {
			$data['filename'] = '';
		}

		if (isset($this->request->post['mask'])) {
			$data['mask'] = $this->request->post['mask'];
		} elseif (!empty($download_info)) {
			$data['mask'] = $download_info['mask'];
		} else {
			$data['mask'] = '';
		}

		$data['header'] = $this->load->controller('extension/tmdmultivendor/vendor/header');
		$data['column_left'] = $this->load->controller('extension/tmdmultivendor/vendor/column_left');
		$data['footer'] = $this->load->controller('extension/tmdmultivendor/vendor/footer');

		
		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/download_form', $data));
	}



	public function delete(): void {
		$this->load->language('extension/tmdmultivendor/vendor/download');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}
		
		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/download');
			
			foreach ($selected as $download_id) {
				$this->model_extension_tmdmultivendor_vendor_download->deleteDownload($download_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
		
	}

	public function save(): void {

	     $json = [];

		$this->load->language('extension/tmdmultivendor/vendor/download');
		if (!$json) {
       foreach ($this->request->post['download_description'] as $language_id => $value) {
			if ((strlen(trim($value['name'])) < 1) || (strlen($value['name']) > 64)) {
				$json['error']['name_' . $language_id] = $this->language->get('error_name');
			}
		}
		}

     if (isset($json['error']) && !isset($json['error']['warning'])) {

			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/download');

			if (!$this->request->post['download_id']) {
				$json['download_id'] = $this->model_extension_tmdmultivendor_vendor_download->addDownload($this->request->post);
			} else {
				$this->model_extension_tmdmultivendor_vendor_download->editDownload($this->request->post['download_id'], $this->request->post);
			}

			$json['success'] = $this->language->get('text_success');

		}



		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
        // $this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/download', ''));
	}

	public function upload(): void {
		$this->load->language('extension/tmdmultivendor/vendor/download');

		$json = array();

		// Check user has permission
		

		if (!$json) {
			if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
				// Sanitize the filename
				$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				if ((strlen($filename) < 3) || (strlen($filename) > 128)) {
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
		}

		if (!$json) {
			$file = $filename . '.' . Helper\General\token(32);

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $file);

			$json['filename'] = $file;
			$json['mask'] = $filename;

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('extension/tmdmultivendor/vendor/download');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'vendor_id'   => $this->vendor->getId(),
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_extension_tmdmultivendor_vendor_download->getDownloads($filter_data);

			

			foreach ($results as $result) {
				$json[] = array(
					'download_id' => $result['download_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
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
