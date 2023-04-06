<?php
namespace Opencart\Admin\Controller\Extension\Tmdmultivendor\Vendor;

// Lib Include
require_once (DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/system.php');
require_once (DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/Psr/autoloader.php');
require_once (DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/myclabs/Enum.php');
require_once (DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/ZipStream/autoloader.php');
require_once (DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/ZipStream/ZipStream.php');
require_once (DIR_EXTENSION.'/tmdmultivendor/system/library/tmd/PhpSpreadsheet/autoloader.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Lib Include

class Shipping extends \Opencart\System\Engine\Controller {
	public function index():void {
		$this->load->language('extension/tmdmultivendor/vendor/shipping');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = '';

		if (isset($this->request->get['filter_store_name'])) {
			$url .= '&filter_store_name='.urlencode(html_entity_decode($this->request->get['filter_store_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1='.urlencode(html_entity_decode($this->request->get['filter_vendor1'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country='.$this->request->get['filter_country'];
		}

		if (isset($this->request->get['filter_zipfrom'])) {
			$url .= '&filter_zipfrom='.$this->request->get['filter_zipfrom'];
		}

		if (isset($this->request->get['filter_zipto'])) {
			$url .= '&filter_zipto='.$this->request->get['filter_zipto'];
		}

		if (isset($this->request->get['filter_weightto'])) {
			$url .= '&filter_weightto='.$this->request->get['filter_weightto'];
		}

		if (isset($this->request->get['filter_weightfrom'])) {
			$url .= '&filter_weightfrom='.$this->request->get['filter_weightfrom'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price='.$this->request->get['filter_price'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token='.$this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/shipping', 'user_token='.$this->session->data['user_token'].$url)
		];

		$data['bulkshipping'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|bulkshipping', 'user_token='.$this->session->data['user_token'].$url);
		$data['add']          = $this->url->link('extension/tmdmultivendor/vendor/shipping|form', 'user_token='.$this->session->data['user_token'].$url);
		$data['delete']       = $this->url->link('extension/tmdmultivendor/vendor/shipping|delete', 'user_token='.$this->session->data['user_token']);
	
		$data['list'] = $this->getList();

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = $this->session->data['user_token'] ;
		}

		$data['user_token'] = $tokenchage;


		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/shipping', $data));
	}

	public function list():void {
		$this->load->language('extension/tmdmultivendor/vendor/shipping');



		$this->response->setOutput($this->getList());
	}

	protected function getList():string {

		if (isset($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = 'user_token='.$this->session->data['user_token'];
		}

		if (isset($this->request->get['filter_store_name'])) {
			$filter_store_name = $this->request->get['filter_store_name'];
		} else {
			$filter_store_name = '';
		}
		/* 11 02 2020 */
		if (isset($this->request->get['filter_vendor1'])) {
			$filter_vendor1 = $this->request->get['filter_vendor1'];
		} else {
			$filter_vendor1 = '';
		}
		/* 11 02 2020 */

		if (isset($this->request->get['filter_country'])) {
			$filter_country = $this->request->get['filter_country'];
		} else {
			$filter_country = '';
		}

		if (isset($this->request->get['filter_zipfrom'])) {
			$filter_zipfrom = $this->request->get['filter_zipfrom'];
		} else {
			$filter_zipfrom = '';
		}

		if (isset($this->request->get['filter_zipto'])) {
			$filter_zipto = $this->request->get['filter_zipto'];
		} else {
			$filter_zipto = '';
		}

		if (isset($this->request->get['filter_weightto'])) {
			$filter_weightto = $this->request->get['filter_weightto'];
		} else {
			$filter_weightto = '';
		}

		if (isset($this->request->get['filter_weightfrom'])) {
			$filter_weightfrom = $this->request->get['filter_weightfrom'];
		} else {
			$filter_weightfrom = '';
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'shipping_id';
		}

		if (isset($this->request->get['filter_store_name'])) {
			$filter_store_name = $this->request->get['filter_store_name'];
		} else {
			$filter_store_name = '';
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$filter_vendor1 = $this->request->get['filter_vendor1'];
		} else {
			$filter_vendor1 = '';
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
			$page = (int) $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_store_name'])) {
			$url .= '&filter_store_name='.urlencode(html_entity_decode($this->request->get['filter_store_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1='.urlencode(html_entity_decode($this->request->get['filter_vendor1'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country='.$this->request->get['filter_country'];
		}

		if (isset($this->request->get['filter_zipfrom'])) {
			$url .= '&filter_zipfrom='.$this->request->get['filter_zipfrom'];
		}

		if (isset($this->request->get['filter_zipto'])) {
			$url .= '&filter_zipto='.$this->request->get['filter_zipto'];
		}

		if (isset($this->request->get['filter_weightto'])) {
			$url .= '&filter_weightto='.$this->request->get['filter_weightto'];
		}

		if (isset($this->request->get['filter_weightfrom'])) {
			$url .= '&filter_weightfrom='.$this->request->get['filter_weightfrom'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price='.$this->request->get['filter_price'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		$data['action'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token='.$this->session->data['user_token'].$url);

		$data['shippings'] = [];

		$filter_data = [
			'filter_store_name' => $filter_store_name,
			/* 11 02 2020 */
			'filter_vendor1' => $filter_vendor1,
			/* 11 02 2020 */
			'filter_country'    => $filter_country,
			'filter_zipto'      => $filter_zipto,
			'filter_zipfrom'    => $filter_zipfrom,
			'filter_weightto'   => $filter_weightto,
			'filter_weightfrom' => $filter_weightfrom,
			'filter_price'      => $filter_price,
			'sort'              => $sort,
			'order'             => $order,
			'start'             => ($page-1)*$this->config->get('config_pagination_admin'),
			'limit'             => $this->config->get('config_pagination_admin')
		];

		$this->load->model('extension/tmdmultivendor/vendor/shipping');

		$shipping_total = $this->model_extension_tmdmultivendor_vendor_shipping->getTotalShippping($filter_data);

		$results = $this->model_extension_tmdmultivendor_vendor_shipping->getShippings($filter_data);

		foreach ($results as $result) {

			$this->load->model('localisation/country');
			$country_info = $this->model_localisation_country->getCountry($result['country_id']);
			if (isset($country_info['name'])) {
				$country = $country_info['name'];
			} else {
				$country = '';
			}

			$vendor_info = $this->model_extension_tmdmultivendor_vendor_shipping->getVendorDescription($result['vendor_id']);
			if (isset($vendor_info['name'])) {
				$store_name = $vendor_info['name'];
			} else {
				$store_name = '';
			}

			$data['shippings'][] = [
				'shipping_id' => $result['shipping_id'],
				'country_id'  => $country,
				'zip_from'    => $result['zip_from'],

				'weight_from' => $result['weight_from'],
				'weight_to'   => $result['weight_to'],
				'price'       => $this->currency->format($result['price'], $this->config->get('config_currency')),
				'store_name'  => $store_name,
			];
		}

		$url = '';

		if (isset($this->request->get['filter_store_name'])) {
			$url .= '&filter_store_name='.urlencode(html_entity_decode($this->request->get['filter_store_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1='.urlencode(html_entity_decode($this->request->get['filter_vendor1'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country='.$this->request->get['filter_country'];
		}

		if (isset($this->request->get['filter_zipfrom'])) {
			$url .= '&filter_zipfrom='.$this->request->get['filter_zipfrom'];
		}

		if (isset($this->request->get['filter_zipto'])) {
			$url .= '&filter_zipto='.$this->request->get['filter_zipto'];
		}

		if (isset($this->request->get['filter_weightto'])) {
			$url .= '&filter_weightto='.$this->request->get['filter_weightto'];
		}

		if (isset($this->request->get['filter_weightfrom'])) {
			$url .= '&filter_weightfrom='.$this->request->get['filter_weightfrom'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price='.$this->request->get['filter_price'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		if (isset($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = $this->session->data['user_token'] ;
		}

		$data['sort_store_name'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=store_name'.$url, true);
		$data['sort_country']    = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=country'.$url, true);
		$data['sort_zipto']      = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=zipto'.$url, true);
		$data['sort_zipfrom']    = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=zipfrom'.$url, true);
		$data['sort_weightfrom'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=weightfrom'.$url, true);
		$data['sort_weightto']   = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=weightto'.$url, true);
		$data['sort_price']      = $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token=' . $tokenchage .'&sort=price'.$url, true);

		$url = '';

		if (isset($this->request->get['filter_store_name'])) {
			$url .= '&filter_store_name='.urlencode(html_entity_decode($this->request->get['filter_store_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1='.urlencode(html_entity_decode($this->request->get['filter_vendor1'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country='.$this->request->get['filter_country'];
		}

		if (isset($this->request->get['filter_zipfrom'])) {
			$url .= '&filter_zipfrom='.$this->request->get['filter_zipfrom'];
		}

		if (isset($this->request->get['filter_zipto'])) {
			$url .= '&filter_zipto='.$this->request->get['filter_zipto'];
		}

		if (isset($this->request->get['filter_weightto'])) {
			$url .= '&filter_weightto='.$this->request->get['filter_weightto'];
		}

		if (isset($this->request->get['filter_weightfrom'])) {
			$url .= '&filter_weightfrom='.$this->request->get['filter_weightfrom'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price='.$this->request->get['filter_price'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		$data['pagination'] = $this->load->controller('common/pagination', [
				'total' => $shipping_total,
				'page'  => $page,
				'limit' => $this->config->get('config_pagination_admin'),
				'url'   => $this->url->link('extension/tmdmultivendor/vendor/shipping|list', 'user_token='.$this->session->data['user_token'].$url.'&page={page}')
			]);

		$data['results'] = sprintf($this->language->get('text_pagination'), ($shipping_total)?(($page-1)*$this->config->get('config_pagination_admin'))+1:0, ((($page-1)*$this->config->get('config_pagination_admin')) > ($shipping_total-$this->config->get('config_pagination_admin')))?$shipping_total:((($page-1)*$this->config->get('config_pagination_admin'))+$this->config->get('config_pagination_admin')), $shipping_total, ceil($shipping_total/$this->config->get('config_pagination_admin')));

		$data['bulkshipping'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|bulkshipping', 'user_token=' . $tokenchage .$url, true);

		$data['filter_store_name'] = $filter_store_name;
		$data['filter_vendor1']     = $filter_vendor1;
		$data['filter_country']    = $filter_country;
		$data['filter_zipto']      = $filter_zipto;
		$data['filter_zipfrom']    = $filter_zipfrom;
		$data['filter_weightfrom'] = $filter_weightfrom;
		$data['filter_weightto']   = $filter_weightto;
		$data['filter_price']      = $filter_price;
		$data['sort']              = $sort;
		$data['order']             = $order;

		if (isset($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = $this->session->data['user_token'];
		}

		$data['user_token'] =$tokenchage;

		return $this->load->view('extension/tmdmultivendor/vendor/shipping_list', $data);
	}

	public function form():void {
		$this->load->language('extension/tmdmultivendor/vendor/shipping');

		if (isset($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = 'user_token='.$this->session->data['user_token'];
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['text_form'] = !isset($this->request->get['shipping_id'])?$this->language->get('text_add'):$this->language->get('text_edit');

		$url = '';

		if (isset($this->request->get['filter_store_name'])) {
			$url .= '&filter_store_name='.urlencode(html_entity_decode($this->request->get['filter_store_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_vendor1'])) {
			$url .= '&filter_vendor1='.urlencode(html_entity_decode($this->request->get['filter_vendor1'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_country'])) {
			$url .= '&filter_country='.$this->request->get['filter_country'];
		}

		if (isset($this->request->get['filter_zipfrom'])) {
			$url .= '&filter_zipfrom='.$this->request->get['filter_zipfrom'];
		}

		if (isset($this->request->get['filter_zipto'])) {
			$url .= '&filter_zipto='.$this->request->get['filter_zipto'];
		}

		if (isset($this->request->get['filter_weightto'])) {
			$url .= '&filter_weightto='.$this->request->get['filter_weightto'];
		}

		if (isset($this->request->get['filter_weightfrom'])) {
			$url .= '&filter_weightfrom='.$this->request->get['filter_weightfrom'];
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price='.$this->request->get['filter_price'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token='.$this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/shipping', 'user_token='.$this->session->data['user_token'].$url)
		];

		$data['save'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|save', 'user_token='.$this->session->data['user_token']);
		$data['back'] = $this->url->link('extension/tmdmultivendor/vendor/shipping', 'user_token='.$this->session->data['user_token'].$url);

		if (isset($this->request->get['shipping_id'])) {
			$this->load->model('extension/tmdmultivendor/vendor/shipping');

			$shipping_info = $this->model_extension_tmdmultivendor_vendor_shipping->getReview($this->request->get['shipping_id']);
		}

		if (isset($this->request->get['shipping_id'])) {
			$data['shipping_id'] = (int) $this->request->get['shipping_id'];
		} else {
			$data['shipping_id'] = 0;
		}

		$this->load->model('localisation/country');
		$data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['country_id'])) {
			$data['country_id'] = (int) $this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_address']['country_id'])) {
			$data['country_id'] = $this->session->data['shipping_address']['country_id'];
		} else {
			$data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$data['zone_id'] = (int) $this->request->post['zone_id'];
		} elseif (isset($this->session->data['shipping_address']['zone_id'])) {
			$data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
		} else {
			$data['zone_id'] = '';
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = (int) $this->request->post['name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['vendor_id'])) {
			$data['vendor_id'] = (int) $this->request->post['vendor_id'];
		} else {
			$data['vendor_id'] = '';
		}

		if (!empty($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = $this->session->data['user_token'];
		}

		$data['user_token'] =$tokenchage;

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/shipping_form', $data));
	}

	public function save():void {
		$this->load->language('extension/tmdmultivendor/vendor/shipping');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/shipping')) {
			$json['error']['warning'] = $this->language->get('error_permission');
		}

		if (!empty($this->request->post['vendor_id'] == '')) {
			$json['error']['vendor'] = $this->language->get('error_store');
		}

		// if ($this->request->post['country_id'] == '') {
		// 	$json['error']['country'] = $this->language->get('error_country');
		// }

		if ((strlen($this->request->post['zip_from']) < 1) || (strlen($this->request->post['zip_from']) > 64)) {
			$json['error']['zip_from'] = $this->language->get('error_zip_from');
		}

		if ((strlen($this->request->post['weight_to']) < 1) || (strlen($this->request->post['weight_to']) > 64)) {
			$json['error']['weight_to'] = $this->language->get('error_weight_to');
		}

		if ((strlen($this->request->post['weight_from']) < 1) || (strlen($this->request->post['weight_from']) > 64)) {
			$json['error']['weight_from'] = $this->language->get('error_weight_from');
		}

		if ((strlen($this->request->post['price']) < 1) || (strlen($this->request->post['price']) > 64)) {
			$json['error']['price'] = $this->language->get('error_price');
		}

		if (isset($json['error']) && !isset($json['error']['warning'])) {
			$json['error']['warning'] = $this->language->get('error_warning');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/shipping');

			if (!$this->request->post['shipping_id']) {
				$json['shipping_id'] = $this->model_extension_tmdmultivendor_vendor_shipping->addShipping($this->request->post);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function delete():void {
		$this->load->language('extension/tmdmultivendor/vendor/shipping');

		$json = [];

		if (isset($this->request->post['selected'])) {
			$selected = $this->request->post['selected'];
		} else {
			$selected = [];
		}

		if (!$this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/shipping')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('extension/tmdmultivendor/vendor/shipping');

			foreach ($selected as $shipping_id) {
				$this->model_extension_tmdmultivendor_vendor_shipping->deleteShipping($shipping_id);
			}

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function shippingdelete() {
		
		$json = [];
		
		$this->load->model('extension/tmdmultivendor/vendor/shipping');
		$this->load->language('extension/tmdmultivendor/vendor/shipping');
	
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			$this->model_extension_tmdmultivendor_vendor_shipping->deleteShipping($this->request->get['shipping_id']);
			$json['success'] = $this->language->get('text_delete');
			
		}		

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function autocomplete() {

		$json = [];

		if (isset($this->request->get['filter_store_name'])) {
			$filter_store_name = $this->request->get['filter_store_name'];
		} else {
			$filter_store_name = '';
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
		$this->load->model('extension/tmdmultivendor/vendor/vendor');

		$filter_data = array(
			'sort'              => $sort,
			'order'             => $order,
			'filter_store_name' => $filter_store_name,
			'start'             => 0,
			'limit'             => 5,
		);
		$this->load->model('extension/tmdmultivendor/vendor/shipping');
		$accounts = $this->model_extension_tmdmultivendor_vendor_shipping->getVendorStoreDescription($filter_data);
		foreach ($accounts as $account) {

			$json[] = array(
				'vendor_id' => $account['vendor_id'],
				'name'      => strip_tags(html_entity_decode($account['name'], ENT_QUOTES, 'UTF-8'))
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

	public function bulkshipping() {
		if (!empty($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = $this->session->data['user_token'];
		}

		$data['user_token'] =$tokenchage;

		$this->load->language('extension/tmdmultivendor/vendor/shipping');

		$this->document->setTitle($this->language->get('heading_bulktitle'));

		$this->load->model('extension/tmdmultivendor/vendor/shipping');

		$data['heading_bulktitle'] = $this->language->get('heading_bulktitle');

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort='.$this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order='.$this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page='.$this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $tokenchage)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/tmdmultivendor/vendor/shipping', 'user_token=' . $tokenchage . $url)
		);

		$data['export'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|export', 'user_token=' . $tokenchage . $url);

		$data['import'] = $this->url->link('extension/tmdmultivendor/vendor/shipping|import', 'user_token=' . $tokenchage . $url);

		$this->load->model('extension/tmdmultivendor/vendor/shipping');
		$data['sellers'] = $this->model_extension_tmdmultivendor_vendor_shipping->getVendorStoreDescription($data);

		$data['vendor_id'] = '';

		$data['timeallowed'] = ini_get('max_execution_time');

		$data['filesize'] = ini_get("upload_max_filesize");

		$data['header']      = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer']      = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/tmdmultivendor/vendor/bulkshipping', $data));
	}

	public function export() {
		$this->load->model('localisation/country');

		$this->load->language('extension/tmdmultivendor/vendor/shipping');
		$this->load->model('extension/tmdmultivendor/vendor/shipping');

		if (isset($this->request->post['vendor_id'])) {
			$vendor_id = $this->request->post['vendor_id'];
		} else {
			$vendor_id = '';
		}
		
		$i           = 1;
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getActiveSheet()->SetCellValue('A'.$i, 'Store Name');
		$spreadsheet->getActiveSheet()->SetCellValue('B'.$i, 'Shipping Country');
		$spreadsheet->getActiveSheet()->SetCellValue('C'.$i, 'Zipcode From');
		$spreadsheet->getActiveSheet()->SetCellValue('D'.$i, 'Weight From');
		$spreadsheet->getActiveSheet()->SetCellValue('E'.$i, 'Weight To');
		$spreadsheet->getActiveSheet()->SetCellValue('F'.$i, 'Price');

		$i           = 2;
		$results = $this->model_extension_tmdmultivendor_vendor_shipping->getShipping($vendor_id);

		foreach ($results as $result) {
			$country_info = $this->model_localisation_country->getCountry($result['country_id']);
			if (!empty($country_info['name'])) {
				$country = $country_info['name'];
			} else {
				$country = '';
			}
			$this->load->model('extension/tmdmultivendor/vendor/shipping');

			$vendor_info = $this->model_extension_tmdmultivendor_vendor_shipping->getVendorDescription($result['vendor_id']);
			
			if (!empty($vendor_info['name'])) {
				$store_name = $vendor_info['name'];
			} else {
				$store_name = '';
			}
		
			$spreadsheet->getActiveSheet()->SetCellValue('A'.$i, $store_name);
			$spreadsheet->getActiveSheet()->SetCellValue('B'.$i, $country);
			$spreadsheet->getActiveSheet()->SetCellValue('C'.$i, $result['zip_from']);
			$spreadsheet->getActiveSheet()->SetCellValue('D'.$i, $result['weight_from']);
			$spreadsheet->getActiveSheet()->SetCellValue('E'.$i, $result['weight_to']);
			$spreadsheet->getActiveSheet()->SetCellValue('F'.$i, $result['price']);
		$i++;
			
		}

		/* color setup */
		for ($col = 'A'; $col != 'F'; $col++) {
			$spreadsheet->getActiveSheet()->getColumnDimension($col)->setWidth(20);
		}
		$spreadsheet->getActiveSheet()->getRowDimension(1)->setRowHeight(25);
		$spreadsheet->getActiveSheet()
		            ->getStyle('A1:F1')
		            ->getFill()
		            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
		            ->getStartColor()
		            ->setARGB('FF4F81BD');
			$styleArray = array(
					'font'  => array(
					'bold'  => true,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 9,
					'name'  => 'Verdana'
				));
		$spreadsheet->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
		$spreadsheet->getActiveSheet()->setTitle('shipping');
		$filename = 'shipping.xlsx';

		$writer   = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="'.urlencode($filename).'"');
		$writer->save('php://output');
		unlink($filename);

	}

	public function import() {
		if (isset($this->session->data['token'])) {
			$tokenchage = 'token='.$this->session->data['token'];
		} else {
			$tokenchage = 'user_token='.$this->session->data['user_token'];
		}

		$this->load->language('extension/tmdmultivendor/vendor/shipping');
		$this->load->model('extension/tmdmultivendor/vendor/shipping');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->user->hasPermission('modify', 'extension/tmdmultivendor/vendor/shipping')) {

			if (is_uploaded_file($this->request->files['import']['tmp_name'])) {
				$content = file_get_contents($this->request->files['import']['tmp_name']);
			} else {
				$content = false;
			}

			if ($content) {
				////////////////////////// Started Import work  /////////
				if ($this->request->post['format'] == 'xls') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}

				$spreadsheet = $reader->load($_FILES['import']['tmp_name']);
				$spreadsheet->setActiveSheetIndex(0);
				$sheetDatas = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
				$i=0;
				/*
				@ arranging the data according to our need
				*/

				if(!empty($sheetDatas)){
				foreach ($sheetDatas as $sheetData) {

					if ($i != 0) {

						/* Step Customer Collect Data */

						$vendor_id = $sheetData['A'];

						if (!empty($vendor_id)) {
							$vendor_id = $this->model_extension_tmdmultivendor_vendor_shipping->getvendorbyname($sheetData['A']);
						}

						$country_id = $sheetData['B'];

						if (!empty($country_id)) {
							$country_id = $this->model_extension_tmdmultivendor_vendor_shipping->getCountrybyname($sheetData['B']);
						}

						$zipfrom    = $sheetData['C'];
						$weightfrom = $sheetData['D'];
						$weightto   = $sheetData['E'];
						$price      = $sheetData['F'];

						$data = '';

						$data = array(
							'vendor_id'  => $this->request->post['vendor_id'],
							'country_id' => $country_id,
							'zip_from'   => $zipfrom,
							'weight_from' => $weightfrom,
							'weight_to'   => $weightto,
							'price'       => $price,
						);

						$this->model_extension_tmdmultivendor_vendor_shipping->addImport($this->request->post['vendor_id'], $data);

						$totalupdateaffiliate++;
					}

					$i++;
				}
				}

				// $spreadsheet->setActiveSheetIndex(0);
				$this->session->data['success'] = $totalupdateaffiliate.' :: Total Affiliate update '.$totalnewaffiliate.':: Total New Affiliate added';

				/// Started Import work  ////
				$this->response->redirect($this->url->link('extension/tmdmultivendor/vendor/shipping', 'user_token=' . $this->session->data['user_token']));
			} 
			else
			{
				$data['warning'] = $this->language->get('error_empty'); 
			}

		}
	}
}
