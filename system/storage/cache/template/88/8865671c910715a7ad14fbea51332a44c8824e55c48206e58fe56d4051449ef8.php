<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* extension/tmdmultivendor/admin/view/template/vendor/vendor_setting.twig */
class __TwigTemplate_9ef98fb9ab8b70bfe62cd625883034aed06821310836e305aa69df11d561630f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo ($context["header"] ?? null);
        echo ($context["column_left"] ?? null);
        echo "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"float-end\">
\t  
\t   <button type=\"submit\" form=\"form-vendor\" data-bs-toggle=\"tooltip\" title=\"";
        // line 7
        echo ($context["button_save"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fas fa-save\"></i></button>
\t   
        <a href=\"";
        // line 9
        echo ($context["back"] ?? null);
        echo "\" data-bs-toggle=\"tooltip\" title=\"";
        echo ($context["button_back"] ?? null);
        echo "\" class=\"btn btn-light\"><i class=\"fas fa-reply\"></i></a></div>
      <h1>";
        // line 10
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 13
            echo "          <li class=\"breadcrumb-item\"><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 13);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 13);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        echo "      </ol>
\t";
        // line 16
        if (($context["success"] ?? null)) {
            // line 17
            echo "    <div class=\"alert alert-success\"><i class=\"fa fa-check-circle\"></i> ";
            echo ($context["success"] ?? null);
            echo "
    </div>
    ";
        }
        // line 20
        echo "    </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fas fa-pencil-alt\"></i> ";
        // line 24
        echo ($context["text_form"] ?? null);
        echo "</div>
      <div class=\"card-body\">
\t   <form action=\"";
        // line 26
        echo ($context["save"] ?? null);
        echo "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-vendor\" class=\"form-horizontal\">
\t\t\t<ul class=\"nav nav-tabs\">
\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-general\" data-bs-toggle=\"tab\" class=\"nav-link active\"><i class=\"fa fa-cogs\" aria-hidden=\"true\"></i> ";
        // line 28
        echo ($context["tab_general"] ?? null);
        echo "</a></li>
\t\t\t\t
\t\t\t\t<li ";
        // line 30
        if (($context["showorderwarning"] ?? null)) {
            echo " class=\"nav-item warningorder\" ";
        }
        echo "><a href=\"#tab-data\" data-bs-toggle=\"tab\" class=\"nav-link\"><i class=\"fa fa-hand-paper\" aria-hidden=\"true\"></i> ";
        echo ($context["tab_data"] ?? null);
        echo "</a></li>

\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-language\" data-bs-toggle=\"tab\" class=\"nav-link\"><i class=\"fa fa-language\" aria-hidden=\"true\"></i> ";
        // line 32
        echo ($context["tab_selerlanguage"] ?? null);
        echo "</a></li>
\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-vendortabsetting\" data-bs-toggle=\"tab\" class=\"nav-link\"><i class=\"fa fa-cogs\" aria-hidden=\"true\"></i> ";
        // line 33
        echo ($context["tab_vendortabsetting"] ?? null);
        echo "</a></li>
\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-signupsetting\" data-bs-toggle=\"tab\" class=\"nav-link\"><i class=\"fa fa-cogs\" aria-hidden=\"true\"></i> ";
        // line 34
        echo ($context["tab_signupsetting"] ?? null);
        echo "</a></li>
\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-seosetting\" data-bs-toggle=\"tab\" class=\"nav-link\"><i class=\"fas fa-key\" aria-hidden=\"true\"></i> ";
        // line 35
        echo ($context["tab_seosetting"] ?? null);
        echo "</a></li>

\t\t\t</ul>
\t\t\t
\t\t\t\t<div class=\"tab-content\">
\t\t\t\t\t<div class=\"tab-pane active\" id=\"tab-general\">\t\t\t\t\t
\t\t\t\t\t\t<ul class=\"nav nav-tabs\">
\t\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-vgeneral\" data-bs-toggle=\"tab\" class=\"nav-link active\"><i class=\"fa fa-cogs\" aria-hidden=\"true\"></i>";
        // line 42
        echo ($context["tab_vgeneral"] ?? null);
        echo "</a></li>\t\t\t\t\t
\t\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-vdata\" data-bs-toggle=\"tab\" class=\"nav-link\"><i class=\"fa fa-eye-slash\" aria-hidden=\"true\"></i> ";
        // line 43
        echo ($context["tab_vdata"] ?? null);
        echo "</a></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"tab-content\">\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"tab-pane active\" id=\"tab-vgeneral\">\t\t
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label for=\"input-vendor-customer2vendor\" class=\"col-sm-3 col-form-label\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 50
        echo ($context["help_customer2vendor"] ?? null);
        echo "\">";
        echo ($context["entry_customer2vendor"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t  <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_customer2vendor\" value=\"1\" id=\"input-vendor-customer2vendor\" class=\"form-check-input\"";
        // line 53
        if (($context["vendor_customer2vendor"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t  </div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_vendor2customer\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 59
        echo ($context["help_vendor2customer"] ?? null);
        echo "\">";
        echo ($context["entry_vendor2customer"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_vendor2customer\" value=\"1\" id=\"input-vendor_vendor2customer\" class=\"form-check-input\"";
        // line 62
        if (($context["vendor_vendor2customer"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t  
\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_vendorautoapprove\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 68
        echo ($context["help_vendorautoapprove"] ?? null);
        echo "\">";
        echo ($context["entry_vendorautoapprove"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_vendorautoapprove\" value=\"1\" id=\"input-vendor_vendorautoapprove\" class=\"form-check-input\"";
        // line 71
        if (($context["vendor_vendorautoapprove"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_proautoapprove\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 77
        echo ($context["help_proautoapprove"] ?? null);
        echo "\">";
        echo ($context["entry_proautoapprove"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_proautoapprove\" value=\"1\" id=\"input-vendor_proautoapprove\" class=\"form-check-input\"";
        // line 80
        if (($context["vendor_proautoapprove"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t  <div class=\"row mb-3\">
\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_hidevendorcontact\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 86
        echo ($context["help_hidevendorcontact"] ?? null);
        echo "\">";
        echo ($context["entry_hidevendorcontact"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_hidevendorcontact\" value=\"1\" id=\"input-vendor_hidevendorcontact\" class=\"form-check-input\"";
        // line 89
        if (($context["vendor_hidevendorcontact"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t  
\t\t\t\t\t\t\t\t<div class=\"row mb-3 d-none\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_vpostcode\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 95
        echo ($context["help_postcode"] ?? null);
        echo "\">";
        echo ($context["entry_vpostcode"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_vpostcode\" value=\"1\" id=\"input-vendor_vpostcode\" class=\"form-check-input\"";
        // line 98
        if (($context["vendor_vpostcode"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendorterms\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 105
        echo ($context["help_vendorterms"] ?? null);
        echo "\">";
        echo ($context["entry_vendorterms"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-3\">
\t\t\t\t\t\t\t\t\t\t<select name=\"vendor_vprivacy_id\" id=\"input-vendorterms\" class=\"form-control\">
\t\t\t\t\t\t\t\t\t\t<option value=\"0\">";
        // line 108
        echo ($context["text_none"] ?? null);
        echo "</option>
\t\t\t\t\t\t\t\t\t\t";
        // line 109
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["informations"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["information"]) {
            // line 110
            echo "\t\t\t\t\t\t\t\t\t\t\t";
            if ((twig_get_attribute($this->env, $this->source, $context["information"], "information_id", [], "any", false, false, false, 110) == ($context["vendor_vprivacy_id"] ?? null))) {
                echo "\t\t\t\t\t\t\t\t\t  
\t\t\t\t\t\t\t\t\t\t\t<option value=\"";
                // line 111
                echo twig_get_attribute($this->env, $this->source, $context["information"], "information_id", [], "any", false, false, false, 111);
                echo "\" selected=\"selected\">";
                echo twig_get_attribute($this->env, $this->source, $context["information"], "title", [], "any", false, false, false, 111);
                echo "</option>\t\t\t\t  
\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 112
                echo "\t\t\t\t\t\t\t\t\t\t  
\t\t\t\t\t\t\t\t\t\t\t<option value=\"";
                // line 113
                echo twig_get_attribute($this->env, $this->source, $context["information"], "information_id", [], "any", false, false, false, 113);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["information"], "title", [], "any", false, false, false, 113);
                echo "</option>
\t\t\t\t\t\t\t\t\t\t\t";
            }
            // line 115
            echo "\t\t\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['information'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        echo "\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t</select>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"tab-pane\" id=\"tab-vdata\">
\t\t\t\t\t\t\t<legend class=\"allsellers\">  <i class=\"fa fa-eye-slash\" aria-hidden=\"true\"></i> ";
        // line 122
        echo ($context["text_forallseller"] ?? null);
        echo "</legend>\t
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-hidevname\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 125
        echo ($context["help_hidevname"] ?? null);
        echo "\">";
        echo ($context["entry_hidevname"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_hidevendorname\" value=\"1\" id=\"input-vendor_hidevendorname\" class=\"form-check-input\"";
        // line 128
        if (($context["vendor_hidevendorname"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_hidevemail\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 134
        echo ($context["help_hidevemail"] ?? null);
        echo "\">";
        echo ($context["entry_hidevemail"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_hidevemail\" value=\"1\" id=\"input-vendor_hidevemail\" class=\"form-check-input\"";
        // line 137
        if (($context["vendor_hidevemail"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_hidevponeno\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 143
        echo ($context["help_hidevponeno"] ?? null);
        echo "\">";
        echo ($context["entry_hidevphoneno"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_hidevponeno\" value=\"1\" id=\"input-vendor_hidevponeno\" class=\"form-check-input\"";
        // line 146
        if (($context["vendor_hidevponeno"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-3 col-form-label\" for=\"input-vendor_hidevsocialicon\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 153
        echo ($context["help_hidevsocialicon"] ?? null);
        echo "\">";
        echo ($context["entry_hidevsocialicon"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-9\">
\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_hidevsocialicon\" value=\"1\" id=\"input-vendor_hidevsocialicon\" class=\"form-check-input\"";
        // line 156
        if (($context["vendor_hidevsocialicon"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<!--08 04 2020-->
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t
\t\t\t\t\t</div>\t
\t\t\t\t   
\t\t\t\t<div class=\"tab-pane\" id=\"tab-data\">
\t\t\t\t\t<div class=\"alert alert-info\"><i class=\"fa fa-info-circle\" aria-hidden=\"true\"></i> The status that you have selected here will appear on the front of seller dashboard orders and Earn Payment!!. </div>
\t\t\t\t\t\t
\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-showorder-status\">
\t\t\t\t\t\t<span data-oc-toggle=\"tooltip\" title=\"";
        // line 171
        echo ($context["help_showorder_status"] ?? null);
        echo "\">";
        echo ($context["entry_showorder_status"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t<div class=\"col-sm-10\">
\t\t\t\t\t\t\t<div class=\"form-control\" style=\"height: 150px; overflow: auto;\">
\t\t\t\t\t\t\t";
        // line 174
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            echo "\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t<div class=\"checkbox\">
\t\t\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t\t";
            // line 177
            if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 177), ($context["vendor_showorder_status"] ?? null))) {
                // line 178
                echo "\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_showorder_status[]\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 178);
                echo "\" checked=\"checked\" />
\t\t\t\t\t\t\t\t\t\t";
                // line 179
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 179);
                echo "
\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 181
                echo "\t\t\t\t\t\t\t\t\t\t  <input type=\"checkbox\" name=\"vendor_showorder_status[]\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 181);
                echo "\" />
\t\t\t\t\t\t\t\t\t\t  ";
                // line 182
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 182);
                echo "
\t\t\t\t\t\t\t\t\t\t ";
            }
            // line 183
            echo " 
\t\t\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 187
        echo "\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<div id=\"error-showorder-status\" class=\"invalid-feedback\"></div>
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-earnpayment-status\"><span data-oc-toggle=\"tooltip\" title=\"";
        // line 195
        echo ($context["help_earnpayment_status"] ?? null);
        echo "\">";
        echo ($context["entry_earnpayment_status"] ?? null);
        echo "</span></label>
\t\t\t\t\t\t\t<div class=\"col-sm-10\">
\t\t\t\t\t\t\t\t<div class=\"form-control\" style=\"height: 150px; overflow: auto;\">
\t\t\t\t\t\t\t\t";
        // line 198
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["order_statuses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["order_status"]) {
            echo "\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t<div class=\"checkbox\">
\t\t\t\t\t\t\t\t\t\t<label>
\t\t\t\t\t\t\t\t\t\t\t";
            // line 201
            if (twig_in_filter(twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 201), ($context["vendor_earnpayment_status"] ?? null))) {
                // line 202
                echo "\t\t\t\t\t\t\t\t\t\t\t  <input type=\"checkbox\" name=\"vendor_earnpayment_status[]\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 202);
                echo "\" checked=\"checked\" />
\t\t\t\t\t\t\t\t\t\t\t";
                // line 203
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 203);
                echo "
\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 205
                echo "\t\t\t\t\t\t\t\t\t\t\t  <input type=\"checkbox\" name=\"vendor_earnpayment_status[]\" value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "order_status_id", [], "any", false, false, false, 205);
                echo "\" />
\t\t\t\t\t\t\t\t\t\t\t  ";
                // line 206
                echo twig_get_attribute($this->env, $this->source, $context["order_status"], "name", [], "any", false, false, false, 206);
                echo "
\t\t\t\t\t\t\t\t\t\t\t ";
            }
            // line 207
            echo " 
\t\t\t\t\t\t\t\t\t\t</label>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['order_status'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 211
        echo "\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t<div id=\"error-earnpayment-status\" class=\"invalid-feedback\"></div>
\t\t\t\t\t\t\t<!-- ";
        // line 214
        if (($context["error_earnpayment_status"] ?? null)) {
            // line 215
            echo "\t\t\t\t\t\t\t<div class=\"text-danger\">";
            echo ($context["error_earnpayment_status"] ?? null);
            echo "</div>
\t\t\t\t\t\t\t";
        }
        // line 216
        echo " -->
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>\t\t\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t\t
\t\t\t\t\t<div class=\"tab-pane \" id=\"tab-language\">
\t\t\t\t\t<legend class=\"allsellers\"> <i class=\"fa fa-list\" aria-hidden=\"true\"></i> 
\t\t\t\t\t\t";
        // line 223
        echo ($context["text_selerlanguage"] ?? null);
        echo "</legend>\t
\t\t\t\t\t\t<ul class=\"nav nav-tabs\" id=\"language-lable\">
\t\t\t\t\t\t\t";
        // line 225
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 226
            echo "\t\t\t\t\t\t\t\t <li class=\"nav-item\"><a href=\"#language-";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 226);
            echo "\" data-bs-toggle=\"tab\" class=\"nav-link";
            if (twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 226)) {
                echo " active";
            }
            echo "\"><img src=\"language/";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 226);
            echo "/";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 226);
            echo ".png\" title=\"";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 226);
            echo "\"/> ";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 226);
            echo "</a></li>
\t\t\t\t\t\t\t";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 228
        echo "\t\t\t\t\t\t</ul>
\t\t\t\t\t<div class=\"tab-content\">
\t\t\t\t\t\t";
        // line 230
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 231
            echo "\t\t\t\t\t\t\t<div class=\"tab-pane";
            if (twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 231)) {
                echo " active";
            }
            echo "\" id=\"language-";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 231);
            echo "\">
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellerlist";
            // line 233
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 233);
            echo "\">";
            echo ($context["text_sellerlist"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 235
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 235);
            echo "][sellerlist]\" value=\"";
            echo (((($__internal_compile_0 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 235)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_1 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 235)] ?? null) : null), "sellerlist", [], "any", false, false, false, 235)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_sellerlist"] ?? null);
            echo "\" id=\"input-sellerlist[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 235);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellerprofile[";
            // line 238
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 238);
            echo "]\">";
            echo ($context["text_sellerprofile"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 240
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 240);
            echo "][sellerprofile]\" value=\"";
            echo (((($__internal_compile_2 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 240)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_3 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 240)] ?? null) : null), "sellerprofile", [], "any", false, false, false, 240)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_sellerprofile"] ?? null);
            echo "\" id=\"input-sellerprofile[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 240);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-loginseller[";
            // line 245
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 245);
            echo "]\">";
            echo ($context["text_loginseller"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 247
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 247);
            echo "][loginseller]\" value=\"";
            echo (((($__internal_compile_4 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 247)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_5 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 247)] ?? null) : null), "loginseller", [], "any", false, false, false, 247)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_loginseller"] ?? null);
            echo "\" id=\"input-loginseller[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 247);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-loginseller[";
            // line 250
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 250);
            echo "]\">";
            echo ($context["text_afterloginseller"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 252
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 252);
            echo "][afterloginseller]\" value=\"";
            echo (((($__internal_compile_6 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 252)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_7 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 252)] ?? null) : null), "afterloginseller", [], "any", false, false, false, 252)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_afterloginseller"] ?? null);
            echo "\" id=\"input-afterloginseller[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 252);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellerdash[";
            // line 257
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 257);
            echo "]\">";
            echo ($context["text_sellerdash"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 259
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 259);
            echo "][sellerdash]\" value=\"";
            echo (((($__internal_compile_8 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_8) || $__internal_compile_8 instanceof ArrayAccess ? ($__internal_compile_8[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 259)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_9 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_9) || $__internal_compile_9 instanceof ArrayAccess ? ($__internal_compile_9[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 259)] ?? null) : null), "sellerdash", [], "any", false, false, false, 259)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_sellerdash"] ?? null);
            echo "\" id=\"input-sellerdash[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 259);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellerproduct[";
            // line 262
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 262);
            echo "]\">";
            echo ($context["text_sellerproduct"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 264
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 264);
            echo "][sellerproduct]\" value=\"";
            echo (((($__internal_compile_10 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_10) || $__internal_compile_10 instanceof ArrayAccess ? ($__internal_compile_10[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 264)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_11 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_11) || $__internal_compile_11 instanceof ArrayAccess ? ($__internal_compile_11[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 264)] ?? null) : null), "sellerproduct", [], "any", false, false, false, 264)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_sellerproduct"] ?? null);
            echo "\" id=\"input-sellerproduct[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 264);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellerreview[";
            // line 269
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 269);
            echo "]\">";
            echo ($context["text_sellerreview"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 271
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 271);
            echo "][sellerreview]\" value=\"";
            echo (((($__internal_compile_12 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_12) || $__internal_compile_12 instanceof ArrayAccess ? ($__internal_compile_12[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 271)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_13 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_13) || $__internal_compile_13 instanceof ArrayAccess ? ($__internal_compile_13[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 271)] ?? null) : null), "sellerreview", [], "any", false, false, false, 271)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_sellerreview"] ?? null);
            echo "\" id=\"input-sellerreview[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 271);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-managestore[";
            // line 274
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 274);
            echo "]\">";
            echo ($context["text_managestore"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 276
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 276);
            echo "][managestore]\" value=\"";
            echo (((($__internal_compile_14 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_14) || $__internal_compile_14 instanceof ArrayAccess ? ($__internal_compile_14[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 276)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_15 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_15) || $__internal_compile_15 instanceof ArrayAccess ? ($__internal_compile_15[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 276)] ?? null) : null), "managestore", [], "any", false, false, false, 276)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_managestore"] ?? null);
            echo "\" id=\"input-managestore[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 276);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-manageprofile[";
            // line 281
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 281);
            echo "]\">";
            echo ($context["text_manageprofile"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 283
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 283);
            echo "][manageprofile]\" value=\"";
            echo (((($__internal_compile_16 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_16) || $__internal_compile_16 instanceof ArrayAccess ? ($__internal_compile_16[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 283)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_17 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_17) || $__internal_compile_17 instanceof ArrayAccess ? ($__internal_compile_17[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 283)] ?? null) : null), "manageprofile", [], "any", false, false, false, 283)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_manageprofile"] ?? null);
            echo "\" id=\"input-manageprofile[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 283);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-download[";
            // line 286
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 286);
            echo "]\">";
            echo ($context["text_download"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 288
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 288);
            echo "][download]\" value=\"";
            echo (((($__internal_compile_18 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_18) || $__internal_compile_18 instanceof ArrayAccess ? ($__internal_compile_18[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 288)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_19 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_19) || $__internal_compile_19 instanceof ArrayAccess ? ($__internal_compile_19[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 288)] ?? null) : null), "download", [], "any", false, false, false, 288)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_download"] ?? null);
            echo "\" id=\"input-download[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 288);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-manufacture[";
            // line 293
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 293);
            echo "]\">";
            echo ($context["text_manufacture"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 295
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 295);
            echo "][manufacture]\" value=\"";
            echo (((($__internal_compile_20 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_20) || $__internal_compile_20 instanceof ArrayAccess ? ($__internal_compile_20[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 295)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_21 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_21) || $__internal_compile_21 instanceof ArrayAccess ? ($__internal_compile_21[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 295)] ?? null) : null), "manufacture", [], "any", false, false, false, 295)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_manufacture"] ?? null);
            echo "\" id=\"input-manufacture[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 295);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellerlogout[";
            // line 298
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 298);
            echo "]\">";
            echo ($context["text_logout"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 300
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 300);
            echo "][sellerlogout]\" value=\"";
            echo (((($__internal_compile_22 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_22) || $__internal_compile_22 instanceof ArrayAccess ? ($__internal_compile_22[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 300)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_23 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_23) || $__internal_compile_23 instanceof ArrayAccess ? ($__internal_compile_23[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 300)] ?? null) : null), "sellerlogout", [], "any", false, false, false, 300)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_logout"] ?? null);
            echo "\" id=\"input-sellerlogout[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 300);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<!--############13 02 2021############-->
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-byseller[";
            // line 306
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 306);
            echo "]\">";
            echo ($context["text_byseller"] ?? null);
            echo "</label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 308
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 308);
            echo "][byseller]\" value=\"";
            echo (((($__internal_compile_24 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_24) || $__internal_compile_24 instanceof ArrayAccess ? ($__internal_compile_24[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 308)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_25 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_25) || $__internal_compile_25 instanceof ArrayAccess ? ($__internal_compile_25[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 308)] ?? null) : null), "byseller", [], "any", false, false, false, 308)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_byseller"] ?? null);
            echo "\" id=\"input-byseller[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 308);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<!--############13 02 2021############-->
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<legend class=\"allsellers\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> ";
            // line 313
            echo ($context["text_productpage"] ?? null);
            echo "</legend>
\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-selernameinpro[";
            // line 316
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 316);
            echo "]\"><span data-oc-toggle=\"tooltip\" title=\"";
            echo ($context["help_selernameinpro"] ?? null);
            echo "\" > ";
            echo ($context["text_selernameinpro"] ?? null);
            echo "</span></label>
\t\t\t\t\t\t\t\t\t<div class=\"col-sm-4\">
\t\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"vendor_languages[";
            // line 318
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 318);
            echo "][selernameinpro]\" value=\"";
            echo (((($__internal_compile_26 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_26) || $__internal_compile_26 instanceof ArrayAccess ? ($__internal_compile_26[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 318)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_27 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_27) || $__internal_compile_27 instanceof ArrayAccess ? ($__internal_compile_27[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 318)] ?? null) : null), "selernameinpro", [], "any", false, false, false, 318)) : (""));
            echo "\" placeholder=\"";
            echo ($context["text_selernameinpro"] ?? null);
            echo "\" id=\"input-selernameinpro[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 318);
            echo "]\" class=\"form-control\"/>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>\t
\t\t\t\t\t\t\t\t<!--############ 13 02 2021 ############Start-->
\t\t\t\t\t\t\t\t<div class=\"row mb-3\">
\t\t\t\t\t\t\t\t\t<label class=\"col-sm-2 col-form-label\" for=\"input-sellershortcut[";
            // line 323
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 323);
            echo "]\">";
            echo ($context["entry_sellershortcut"] ?? null);
            echo "</label>
\t\t\t\t                    <div class=\"col-sm-10\">
\t\t\t\t                    <textarea type=\"text\" name=\"vendor_languages[";
            // line 325
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 325);
            echo "][sellershortcut]\" value=\"\" placeholder=\"";
            echo ($context["entry_message"] ?? null);
            echo "\" id=\"input-sellershortcut[";
            echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 325);
            echo "]\" data-oc-toggle=\"ckeditor\" data-lang=\"";
            echo ($context["ckeditor"] ?? null);
            echo "\" class=\"form-control\">";
            echo (((($__internal_compile_28 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_28) || $__internal_compile_28 instanceof ArrayAccess ? ($__internal_compile_28[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 325)] ?? null) : null)) ? (twig_get_attribute($this->env, $this->source, (($__internal_compile_29 = ($context["vendor_languages"] ?? null)) && is_array($__internal_compile_29) || $__internal_compile_29 instanceof ArrayAccess ? ($__internal_compile_29[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 325)] ?? null) : null), "sellershortcut", [], "any", false, false, false, 325)) : (""));
            echo "</textarea>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<!--############ 13 02 2021 ############Start-->
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 330
        echo "\t\t\t\t\t
\t\t\t\t\t</div>
\t\t\t\t</div>\t
\t\t\t\t
\t\t\t\t<!--advance settings-->\t
\t\t\t\t<div class=\"tab-pane\" id=\"tab-signupsetting\">\t
\t\t\t\t
\t\t\t\t\t<ul class=\"nav nav-tabs\">
\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-personaldetails\" data-bs-toggle=\"tab\" class=\"nav-link active\">";
        // line 338
        echo ($context["tab_personaldetails"] ?? null);
        echo "</a></li>
\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-generalstore\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 339
        echo ($context["tab_generalstore"] ?? null);
        echo "</a></li>
\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-datastore\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 340
        echo ($context["tab_datastore"] ?? null);
        echo "</a></li>
\t\t\t\t\t\t<li class=\"nav-item\"><a href=\"#tab-paymentdetail\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 341
        echo ($context["tab_paymentdetail"] ?? null);
        echo "</a></li>
\t\t\t\t\t</ul>
\t\t\t
\t\t\t\t\t<div class=\"tab-content\">
\t\t\t\t\t\t<div class=\"tab-pane active\" id=\"tab-personaldetails\">\t
\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-sm-12\">\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"table-responsive\"> 
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<table class=\"table table-bordered table-hover signupdata\">
\t\t\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t\t  <tr>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-start\">";
        // line 353
        echo ($context["text_sortorderofsignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<th class=\"text-center\">";
        // line 355
        echo ($context["text_required"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-end\">";
        // line 356
        echo ($context["text_showhidesignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t  </tr>
\t\t\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 364
        echo ($context["entry_display_name"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_displayname\" value=\"1\" id=\"input-vendor_required_displayname\" class=\"form-check-input\"";
        // line 369
        if (($context["vendor_required_displayname"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_displayname\" value=\"1\" id=\"input-vendor_status_displayname\" class=\"form-check-input\"";
        // line 375
        if (($context["vendor_status_displayname"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 382
        echo ($context["entry_lastname"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_lastname\" value=\"1\" id=\"input-vendor_required_lastname\" class=\"form-check-input\"";
        // line 386
        if (($context["vendor_required_lastname"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_lastname\" value=\"1\" id=\"input-vendor_status_lastname\" class=\"form-check-input\"";
        // line 392
        if (($context["vendor_status_lastname"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 399
        echo ($context["entry_telephone"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_telephone\" value=\"1\" id=\"input-vendor_required_telephone\" class=\"form-check-input\"";
        // line 403
        if (($context["vendor_required_telephone"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_telephone\" value=\"1\" id=\"input-vendor_status_telephone\" class=\"form-check-input\"";
        // line 410
        if (($context["vendor_status_telephone"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 417
        echo ($context["entry_fax"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_fax\" value=\"1\" id=\"input-vendor_required_fax\" class=\"form-check-input\"";
        // line 421
        if (($context["vendor_required_fax"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_fax\" value=\"1\" id=\"input-vendor_status_fax\" class=\"form-check-input\"";
        // line 426
        if (($context["vendor_status_fax"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 433
        echo ($context["entry_company"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_company\" value=\"1\" id=\"input-vendor_required_company\" class=\"form-check-input\"";
        // line 437
        if (($context["vendor_required_company"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_company\" value=\"1\" id=\"input-vendor_status_company\" class=\"form-check-input\"";
        // line 443
        if (($context["vendor_status_company"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 451
        echo ($context["entry_address_1"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_address_1\" value=\"1\" id=\"input-vendor_required_address_1\" class=\"form-check-input\"";
        // line 455
        if (($context["vendor_required_address_1"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_address_1\" value=\"1\" id=\"input-vendor_status_address_1\" class=\"form-check-input\"";
        // line 460
        if (($context["vendor_status_address_1"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 467
        echo ($context["entry_address_2"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_address_2\" value=\"1\" id=\"input-vendor_required_address_2\" class=\"form-check-input\"";
        // line 471
        if (($context["vendor_required_address_2"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_address_2\" value=\"1\" id=\"input-vendor_status_address_2\" class=\"form-check-input\"";
        // line 477
        if (($context["vendor_status_address_2"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 484
        echo ($context["entry_city"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_city\" value=\"1\" id=\"input-vendor_required_city\" class=\"form-check-input\"";
        // line 488
        if (($context["vendor_required_city"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_city\" value=\"1\" id=\"input-vendor_status_city\" class=\"form-check-input\"";
        // line 494
        if (($context["vendor_status_city"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 502
        echo ($context["entry_country"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_country\" value=\"1\" id=\"input-vendor_required_country\" class=\"form-check-input\"";
        // line 506
        if (($context["vendor_required_country"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_country\" value=\"1\" id=\"input-vendor_status_country\" class=\"form-check-input\"";
        // line 512
        if (($context["vendor_status_country"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 520
        echo ($context["entry_zone"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_zone\" value=\"1\" id=\"input-vendor_required_zone\" class=\"form-check-input\"";
        // line 524
        if (($context["vendor_required_zone"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_zone\" value=\"1\" id=\"input-vendor_status_zone\" class=\"form-check-input\"";
        // line 530
        if (($context["vendor_status_zone"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 538
        echo ($context["entry_postcode"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_vpostcode\" value=\"1\" id=\"input-vendor_vpostcode\" class=\"form-check-input\"";
        // line 542
        if (($context["vendor_vpostcode"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_postcode\" value=\"1\" id=\"input-vendor_status_postcode\" class=\"form-check-input\"";
        // line 547
        if (($context["vendor_status_postcode"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 554
        echo ($context["entry_about"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_about\" value=\"1\" id=\"input-vendor_required_about\" class=\"form-check-input\"";
        // line 558
        if (($context["vendor_required_about"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_about\" value=\"1\" id=\"input-vendor_status_about\" class=\"form-check-input\"";
        // line 564
        if (($context["vendor_status_about"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"tab-pane\" id=\"tab-generalstore\">\t
\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-sm-12\">\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"table-responsive\"> 
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<table class=\"table table-bordered table-hover signupdata\">
\t\t\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t\t  <tr>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-start\">";
        // line 586
        echo ($context["text_sortorderofsignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<th class=\"text-center\">";
        // line 588
        echo ($context["text_required"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-end\">";
        // line 589
        echo ($context["text_showhidesignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t  </tr>
\t\t\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 597
        echo ($context["entry_meta_description"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_meta_description\" value=\"1\" id=\"input-vendor_required_meta_description\" class=\"form-check-input\"";
        // line 602
        if (($context["vendor_required_meta_description"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_meta_description\" value=\"1\" id=\"input-vendor_status_meta_description\" class=\"form-check-input\"";
        // line 607
        if (($context["vendor_status_meta_description"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 616
        echo ($context["entry_description"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_description\" value=\"1\" id=\"input-vendor_required_description\" class=\"form-check-input\"";
        // line 621
        if (($context["vendor_required_description"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_description\" value=\"1\" id=\"input-vendor_status_description\" class=\"form-check-input\"";
        // line 626
        if (($context["vendor_status_description"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 634
        echo ($context["entry_shipping_policy"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_shipping_policy\" value=\"1\" id=\"input-vendor_required_shipping_policy\" class=\"form-check-input\"";
        // line 639
        if (($context["vendor_required_shipping_policy"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_shipping_policy\" value=\"1\" id=\"input-vendor_status_shipping_policy\" class=\"form-check-input\"";
        // line 644
        if (($context["vendor_status_shipping_policy"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 652
        echo ($context["entry_return_policy"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_return_policy\" value=\"1\" id=\"input-vendor_required_return_policy\" class=\"form-check-input\"";
        // line 657
        if (($context["vendor_required_return_policy"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_return_policy\" value=\"1\" id=\"input-vendor_status_return_policy\" class=\"form-check-input\"";
        // line 662
        if (($context["vendor_status_return_policy"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 670
        echo ($context["entry_meta_keyword"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_meta_keyword\" value=\"1\" id=\"input-vendor_required_meta_keyword\" class=\"form-check-input\"";
        // line 675
        if (($context["vendor_required_meta_keyword"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_meta_keyword\" value=\"1\" id=\"input-vendor_status_meta_keyword\" class=\"form-check-input\"";
        // line 680
        if (($context["vendor_status_meta_keyword"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"tab-pane\" id=\"tab-datastore\">\t
\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-sm-12\">\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"table-responsive\"> 
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<table class=\"table table-bordered table-hover signupdata\">
\t\t\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t\t  <tr>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-start\">";
        // line 698
        echo ($context["text_sortorderofsignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<th class=\"text-center\">";
        // line 700
        echo ($context["text_required"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-end\">";
        // line 701
        echo ($context["text_showhidesignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t  </tr>
\t\t\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 709
        echo ($context["entry_bank_detail"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_bank_detail\" value=\"1\" id=\"input-vendor_required_bank_detail\" class=\"form-check-input\"";
        // line 714
        if (($context["vendor_required_bank_detail"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_bank_detail\" value=\"1\" id=\"input-vendor_status_bank_detail\" class=\"form-check-input\"";
        // line 720
        if (($context["vendor_status_bank_detail"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 729
        echo ($context["entry_storeabout"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_storeabout\" value=\"1\" id=\"input-vendor_required_storeabout\" class=\"form-check-input\"";
        // line 734
        if (($context["vendor_required_storeabout"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_storeabout\" value=\"1\" id=\"input-vendor_status_storeabout\" class=\"form-check-input\"";
        // line 740
        if (($context["vendor_status_storeabout"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 750
        echo ($context["entry_mapurl"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_mapurl\" value=\"1\" id=\"input-vendor_required_mapurl\" class=\"form-check-input\"";
        // line 755
        if (($context["vendor_required_mapurl"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_mapurl\" value=\"1\" id=\"input-vendor_status_mapurl\" class=\"form-check-input\"";
        // line 761
        if (($context["vendor_status_mapurl"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 771
        echo ($context["entry_tax_number"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_tax_number\" value=\"1\" id=\"input-vendor_required_tax_number\" class=\"form-check-input\"";
        // line 776
        if (($context["vendor_required_tax_number"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_tax_number\" value=\"1\" id=\"input-vendor_status_tax_number\" class=\"form-check-input\"";
        // line 782
        if (($context["vendor_status_tax_number"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 792
        echo ($context["entry_shipping_charge"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_shipping_charge\" value=\"1\" id=\"input-vendor_required_shipping_charge\" class=\"form-check-input\"";
        // line 797
        if (($context["vendor_required_shipping_charge"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_shipping_charge\" value=\"1\" id=\"input-vendor_status_shipping_charge\" class=\"form-check-input\"";
        // line 803
        if (($context["vendor_status_shipping_charge"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 811
        echo ($context["entry_url"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_required_url\" value=\"1\" id=\"input-vendor_required_url\" class=\"form-check-input\"";
        // line 816
        if (($context["vendor_required_url"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_url\" value=\"1\" id=\"input-vendor_status_url\" class=\"form-check-input\"";
        // line 822
        if (($context["vendor_status_url"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 831
        echo ($context["entry_logo"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_logo\" value=\"1\" id=\"input-vendor_status_logo\" class=\"form-check-input\"";
        // line 839
        if (($context["vendor_status_logo"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 847
        echo ($context["entry_banner"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_banner\" value=\"1\" id=\"input-vendor_status_banner\" class=\"form-check-input\"";
        // line 855
        if (($context["vendor_status_banner"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 862
        echo ($context["entry_image"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t 
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_image\" value=\"1\" id=\"input-vendor_status_image\" class=\"form-check-input\"";
        // line 869
        if (($context["vendor_status_image"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t
\t\t\t\t\t\t<div class=\"tab-pane\" id=\"tab-paymentdetail\">\t
\t\t\t\t\t
\t\t\t\t\t\t<div class=\"col-sm-12\">\t\t\t\t\t
\t\t\t\t\t\t\t<div class=\"table-responsive\"> 
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t<table class=\"table table-bordered table-hover signupdata\">
\t\t\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t\t  <tr>
\t\t\t\t\t\t\t\t\t\t<th class=\"text-start\">";
        // line 888
        echo ($context["text_sortorderofsignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<th class=\"text-end\">";
        // line 891
        echo ($context["text_showhidesignup"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t\t\t  </tr>
\t\t\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 899
        echo ($context["text_paypal"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_paypal\" value=\"1\" id=\"input-vendor_status_paypal\" class=\"form-check-input\"";
        // line 905
        if (($context["vendor_status_paypal"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-start\">
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t\t<span>";
        // line 914
        echo ($context["text_bank"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t\t\t<td class=\"text-end\">
\t\t\t\t\t\t\t\t\t\t\t <div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_status_bank\" value=\"1\" id=\"input-vendor_status_bank\" class=\"form-check-input\"";
        // line 919
        if (($context["vendor_status_bank"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t  </td>
\t\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t\t\t</table>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<!--advance settings-->\t
\t\t\t\t
\t\t\t\t<!--############ 13 02 2021 ############Start-->\t
\t\t\t\t<div class=\"tab-pane\" id=\"tab-vendortabsetting\">\t\t\t\t
\t\t\t\t\t<div class=\"col-sm-12\">\t\t\t\t\t
\t\t\t\t\t<div class=\"table-responsive component\">
\t\t\t\t\t  <table class=\"table table-bordered table-hover personaldata\">
\t\t\t\t\t\t<thead>
\t\t\t\t\t\t  <tr>
\t\t\t\t\t\t\t<th class=\"text-start\">";
        // line 940
        echo ($context["text_sortorderoftab"] ?? null);
        echo "</th>
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<th class=\"text-end\">";
        // line 942
        echo ($context["text_showhidetab"] ?? null);
        echo "</th>
\t\t\t\t\t\t  </tr>
\t\t\t\t\t\t</thead>
\t\t\t\t\t\t<tbody >
\t\t\t\t\t\t
\t\t\t\t\t\t\t<tr data-sort=\"";
        // line 947
        echo ($context["vendor_profilestoresort"] ?? null);
        echo "\">
\t\t\t\t\t\t  <td class=\"text-start\">
\t\t\t\t\t\t\t<i class=\"fas fa-arrows-alt\"></i>
\t\t\t\t\t\t\t<span>";
        // line 950
        echo ($context["entry_profilesort"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"vendor_profilestoresort\" class=\"personalsort\" value=\"";
        // line 951
        echo ($context["vendor_profilestoresort"] ?? null);
        echo "\" />
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t  
\t\t\t\t\t\t  <td class=\"text-end\">
\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_profile\" value=\"1\" id=\"input-vendor_profile\" class=\"form-check-input\"";
        // line 956
        if (($context["vendor_profile"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t
\t\t\t\t\t\t\t<tr data-sort=\"";
        // line 961
        echo ($context["vendor_aboutstoresort"] ?? null);
        echo "\">
\t\t\t\t\t\t  <td class=\"text-start\">
\t\t\t\t\t\t\t<i class=\"fas fa-arrows-alt\"></i>
\t\t\t\t\t\t\t<span>";
        // line 964
        echo ($context["entry_aboutstoresort"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"vendor_aboutstoresort\" class=\"personalsort\" value=\"";
        // line 965
        echo ($context["vendor_aboutstoresort"] ?? null);
        echo "\" />
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t  
\t\t\t\t\t\t  <td class=\"text-end\">
\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_aboutstore\" value=\"1\" id=\"input-vendor_aboutstore\" class=\"form-check-input\"";
        // line 970
        if (($context["vendor_aboutstore"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t
\t\t\t\t\t\t\t<tr data-sort=\"";
        // line 975
        echo ($context["vendor_tabproductsort"] ?? null);
        echo "\">
\t\t\t\t\t\t  <td class=\"text-start\">
\t\t\t\t\t\t\t<i class=\"fas fa-arrows-alt\"></i>
\t\t\t\t\t\t\t<span>";
        // line 978
        echo ($context["entry_productsort"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"vendor_tabproductsort\" class=\"personalsort\" value=\"";
        // line 979
        echo ($context["vendor_tabproductsort"] ?? null);
        echo "\" />
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t  
\t\t\t\t\t\t  <td class=\"text-end\">
\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_tabproduct\" value=\"1\" id=\"input-vendor_tabproduct\" class=\"form-check-input\"";
        // line 984
        if (($context["vendor_tabproduct"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t
\t\t\t\t\t\t<tr data-sort=\"";
        // line 990
        echo ($context["vendor_reviewsort"] ?? null);
        echo "\">
\t\t\t\t\t\t  <td class=\"text-start\">
\t\t\t\t\t\t\t<i class=\"fas fa-arrows-alt\"></i>
\t\t\t\t\t\t\t<span>";
        // line 993
        echo ($context["entry_review"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"vendor_reviewsort\" class=\"personalsort\" value=\"";
        // line 994
        echo ($context["vendor_reviewsort"] ?? null);
        echo "\" />
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t  
\t\t\t\t\t\t  <td class=\"text-end\">
\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_review\" value=\"1\" id=\"input-vendor_review\" class=\"form-check-input\"";
        // line 999
        if (($context["vendor_review"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t 
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t
\t\t\t\t\t\t<tr data-sort=\"";
        // line 1005
        echo ($context["vendor_productreviewsort"] ?? null);
        echo "\">
\t\t\t\t\t\t  <td class=\"text-start\">
\t\t\t\t\t\t\t<i class=\"fas fa-arrows-alt\"></i>
\t\t\t\t\t\t\t<span>";
        // line 1008
        echo ($context["entry_productreviewsort"] ?? null);
        echo "</span>
\t\t\t\t\t\t\t<input type=\"hidden\" name=\"vendor_productreviewsort\" class=\"personalsort\" value=\"";
        // line 1009
        echo ($context["vendor_productreviewsort"] ?? null);
        echo "\" />
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t  
\t\t\t\t\t\t  <td class=\"text-end\">
\t\t\t\t\t\t\t\t<div class=\"form-check form-switch form-switch-lg\">
\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"vendor_productreview\" value=\"1\" id=\"input-vendor_productreview\" class=\"form-check-input\"";
        // line 1014
        if (($context["vendor_productreview"] ?? null)) {
            echo " checked";
        }
        echo "/>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t
\t\t\t\t\t\t  </td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t</table>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>\t\t\t\t
\t\t\t\t</div>
\t\t\t\t<!--############ 13 02 2021 End############-->
\t\t\t\t
\t\t\t\t<!---SEO-->
\t\t\t\t<div class=\"tab-pane\" id=\"tab-seosetting\">\t
\t\t\t\t<label class=\"col-sm-6 col-form-label\" for=\"input-thumb-vendorregisterseo\">";
        // line 1028
        echo ($context["entry_vendorregisterseo"] ?? null);
        echo "</label>\t
              <div id=\"product-seo\" class=\"table-responsive\">
                <table class=\"table table-bordered table-hover\">
                  <thead>
                    <tr>
                      <td class=\"text-start\">";
        // line 1033
        echo ($context["entry_store"] ?? null);
        echo "</td>
                      <td class=\"text-start\">";
        // line 1034
        echo ($context["entry_keyword"] ?? null);
        echo "</td>
                    </tr>
                  </thead>
                  <tbody>
                    ";
        // line 1038
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 1039
            echo "                      <tr>
                        <td class=\"text-start\">";
            // line 1040
            echo twig_get_attribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 1040);
            echo "</td>
                        <td class=\"text-start\">
                          ";
            // line 1042
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
                // line 1043
                echo "                            <div class=\"input-group\">
                              <div class=\"input-group-text\"><img src=\"language/";
                // line 1044
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1044);
                echo "/";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1044);
                echo ".png\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 1044);
                echo "\"/></div>
                              <input type=\"text\" name=\"vendorregister_seo_url[";
                // line 1045
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1045);
                echo "][";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1045);
                echo "]\" value=\"";
                if ((($__internal_compile_30 = (($__internal_compile_31 = ($context["vendorregister_seo_url"] ?? null)) && is_array($__internal_compile_31) || $__internal_compile_31 instanceof ArrayAccess ? ($__internal_compile_31[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1045)] ?? null) : null)) && is_array($__internal_compile_30) || $__internal_compile_30 instanceof ArrayAccess ? ($__internal_compile_30[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1045)] ?? null) : null)) {
                    echo (($__internal_compile_32 = (($__internal_compile_33 = ($context["vendorregister_seo_url"] ?? null)) && is_array($__internal_compile_33) || $__internal_compile_33 instanceof ArrayAccess ? ($__internal_compile_33[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1045)] ?? null) : null)) && is_array($__internal_compile_32) || $__internal_compile_32 instanceof ArrayAccess ? ($__internal_compile_32[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1045)] ?? null) : null);
                }
                echo "\" id=\"input-keyword-";
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1045);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1045);
                echo "\" placeholder=\"";
                echo ($context["entry_keyword"] ?? null);
                echo "\" class=\"form-control\"/>
                            </div>
                            <div id=\"error-keyword-";
                // line 1047
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1047);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1047);
                echo "\" class=\"invalid-feedback\"></div>
                          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 1048
            echo "</td>
                      </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 1051
        echo "                  </tbody>
                </table>
              </div>
\t\t\t  
\t\t\t  <label class=\"col-sm-6 col-form-label\" for=\"input-thumb-vendorloginseo\">";
        // line 1055
        echo ($context["entry_vendorloginseo"] ?? null);
        echo "</label>\t
              <div id=\"product-seo\" class=\"table-responsive\">
                <table class=\"table table-bordered table-hover\">
                  <thead>
                    <tr>
                      <td class=\"text-start\">";
        // line 1060
        echo ($context["entry_store"] ?? null);
        echo "</td>
                      <td class=\"text-start\">";
        // line 1061
        echo ($context["entry_keyword"] ?? null);
        echo "</td>
                    </tr>
                  </thead>
                  <tbody>
                    ";
        // line 1065
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 1066
            echo "                      <tr>
                        <td class=\"text-start\">";
            // line 1067
            echo twig_get_attribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 1067);
            echo "</td>
                        <td class=\"text-start\">
                          ";
            // line 1069
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
                // line 1070
                echo "                            <div class=\"input-group\">
                              <div class=\"input-group-text\"><img src=\"language/";
                // line 1071
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1071);
                echo "/";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1071);
                echo ".png\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 1071);
                echo "\"/></div>
                              <input type=\"text\" name=\"vendorlogin_seo_url[";
                // line 1072
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1072);
                echo "][";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1072);
                echo "]\" value=\"";
                if ((($__internal_compile_34 = (($__internal_compile_35 = ($context["vendorlogin_seo_url"] ?? null)) && is_array($__internal_compile_35) || $__internal_compile_35 instanceof ArrayAccess ? ($__internal_compile_35[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1072)] ?? null) : null)) && is_array($__internal_compile_34) || $__internal_compile_34 instanceof ArrayAccess ? ($__internal_compile_34[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1072)] ?? null) : null)) {
                    echo (($__internal_compile_36 = (($__internal_compile_37 = ($context["vendorlogin_seo_url"] ?? null)) && is_array($__internal_compile_37) || $__internal_compile_37 instanceof ArrayAccess ? ($__internal_compile_37[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1072)] ?? null) : null)) && is_array($__internal_compile_36) || $__internal_compile_36 instanceof ArrayAccess ? ($__internal_compile_36[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1072)] ?? null) : null);
                }
                echo "\" id=\"input-keyword-";
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1072);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1072);
                echo "\" placeholder=\"";
                echo ($context["entry_keyword"] ?? null);
                echo "\" class=\"form-control\"/>
                            </div>
                            <div id=\"error-keyword-";
                // line 1074
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1074);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1074);
                echo "\" class=\"invalid-feedback\"></div>
                          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 1075
            echo "</td>
                      </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 1078
        echo "                  </tbody>
                </table>
              </div>
\t\t\t  
\t\t\t  <label class=\"col-sm-6 col-form-label\" for=\"input-thumb-vendorsuccessseo\">";
        // line 1082
        echo ($context["entry_vendorsuccessseo"] ?? null);
        echo "</label>\t
              <div id=\"product-seo\" class=\"table-responsive\">
                <table class=\"table table-bordered table-hover\">
                  <thead>
                    <tr>
                      <td class=\"text-start\">";
        // line 1087
        echo ($context["entry_store"] ?? null);
        echo "</td>
                      <td class=\"text-start\">";
        // line 1088
        echo ($context["entry_keyword"] ?? null);
        echo "</td>
                    </tr>
                  </thead>
                  <tbody>
                    ";
        // line 1092
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 1093
            echo "                      <tr>
                        <td class=\"text-start\">";
            // line 1094
            echo twig_get_attribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 1094);
            echo "</td>
                        <td class=\"text-start\">
                          ";
            // line 1096
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
                // line 1097
                echo "                            <div class=\"input-group\">
                              <div class=\"input-group-text\"><img src=\"language/";
                // line 1098
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1098);
                echo "/";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1098);
                echo ".png\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 1098);
                echo "\"/></div>
                              <input type=\"text\" name=\"vendorsuccess_seo_url[";
                // line 1099
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1099);
                echo "][";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1099);
                echo "]\" value=\"";
                if ((($__internal_compile_38 = (($__internal_compile_39 = ($context["vendorsuccess_seo_url"] ?? null)) && is_array($__internal_compile_39) || $__internal_compile_39 instanceof ArrayAccess ? ($__internal_compile_39[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1099)] ?? null) : null)) && is_array($__internal_compile_38) || $__internal_compile_38 instanceof ArrayAccess ? ($__internal_compile_38[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1099)] ?? null) : null)) {
                    echo (($__internal_compile_40 = (($__internal_compile_41 = ($context["vendorsuccess_seo_url"] ?? null)) && is_array($__internal_compile_41) || $__internal_compile_41 instanceof ArrayAccess ? ($__internal_compile_41[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1099)] ?? null) : null)) && is_array($__internal_compile_40) || $__internal_compile_40 instanceof ArrayAccess ? ($__internal_compile_40[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1099)] ?? null) : null);
                }
                echo "\" id=\"input-keyword-";
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1099);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1099);
                echo "\" placeholder=\"";
                echo ($context["entry_keyword"] ?? null);
                echo "\" class=\"form-control\"/>
                            </div>
                            <div id=\"error-keyword-";
                // line 1101
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1101);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1101);
                echo "\" class=\"invalid-feedback\"></div>
                          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 1102
            echo "</td>
                      </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 1105
        echo "                  </tbody>
                </table>
              </div>
\t\t\t  
\t\t\t  <label class=\"col-sm-6 col-form-label\" for=\"input-thumb-vendorprofile\">";
        // line 1109
        echo ($context["entry_vendorprofile"] ?? null);
        echo "</label>\t
              <div id=\"product-seo\" class=\"table-responsive\">
                <table class=\"table table-bordered table-hover\">
                  <thead>
                    <tr>
                      <td class=\"text-start\">";
        // line 1114
        echo ($context["entry_store"] ?? null);
        echo "</td>
                      <td class=\"text-start\">";
        // line 1115
        echo ($context["entry_keyword"] ?? null);
        echo "</td>
                    </tr>
                  </thead>
                  <tbody>
                    ";
        // line 1119
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 1120
            echo "                      <tr>
                        <td class=\"text-start\">";
            // line 1121
            echo twig_get_attribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 1121);
            echo "</td>
                        <td class=\"text-start\">
                          ";
            // line 1123
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
                // line 1124
                echo "                            <div class=\"input-group\">
                              <div class=\"input-group-text\"><img src=\"language/";
                // line 1125
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1125);
                echo "/";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1125);
                echo ".png\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 1125);
                echo "\"/></div>
                              <input type=\"text\" name=\"vendorprofile_seo_url[";
                // line 1126
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1126);
                echo "][";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1126);
                echo "]\" value=\"";
                if ((($__internal_compile_42 = (($__internal_compile_43 = ($context["vendorprofile_seo_url"] ?? null)) && is_array($__internal_compile_43) || $__internal_compile_43 instanceof ArrayAccess ? ($__internal_compile_43[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1126)] ?? null) : null)) && is_array($__internal_compile_42) || $__internal_compile_42 instanceof ArrayAccess ? ($__internal_compile_42[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1126)] ?? null) : null)) {
                    echo (($__internal_compile_44 = (($__internal_compile_45 = ($context["vendorprofile_seo_url"] ?? null)) && is_array($__internal_compile_45) || $__internal_compile_45 instanceof ArrayAccess ? ($__internal_compile_45[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1126)] ?? null) : null)) && is_array($__internal_compile_44) || $__internal_compile_44 instanceof ArrayAccess ? ($__internal_compile_44[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1126)] ?? null) : null);
                }
                echo "\" id=\"input-keyword-";
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1126);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1126);
                echo "\" placeholder=\"";
                echo ($context["entry_keyword"] ?? null);
                echo "\" class=\"form-control\"/>
                            </div>
                            <div id=\"error-keyword-";
                // line 1128
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1128);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1128);
                echo "\" class=\"invalid-feedback\"></div>
                          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 1129
            echo "</td>
                      </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 1132
        echo "                  </tbody>
                </table>
              </div>
\t\t\t  
\t\t\t   <label class=\"col-sm-6 col-form-label\" for=\"input-thumb-vendorallseller\">";
        // line 1136
        echo ($context["entry_vendorallseller"] ?? null);
        echo "</label>\t
              <div id=\"product-seo\" class=\"table-responsive\">
                <table class=\"table table-bordered table-hover\">
                  <thead>
                    <tr>
                      <td class=\"text-start\">";
        // line 1141
        echo ($context["entry_store"] ?? null);
        echo "</td>
                      <td class=\"text-start\">";
        // line 1142
        echo ($context["entry_keyword"] ?? null);
        echo "</td>
                    </tr>
                  </thead>
                  <tbody>
                    ";
        // line 1146
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 1147
            echo "                      <tr>
                        <td class=\"text-start\">";
            // line 1148
            echo twig_get_attribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 1148);
            echo "</td>
                        <td class=\"text-start\">
                          ";
            // line 1150
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["languages"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
                // line 1151
                echo "                            <div class=\"input-group\">
                              <div class=\"input-group-text\"><img src=\"language/";
                // line 1152
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1152);
                echo "/";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 1152);
                echo ".png\" title=\"";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, false, 1152);
                echo "\"/></div>
                              <input type=\"text\" name=\"vendorallseller_seo_url[";
                // line 1153
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1153);
                echo "][";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1153);
                echo "]\" value=\"";
                if ((($__internal_compile_46 = (($__internal_compile_47 = ($context["vendorallseller_seo_url"] ?? null)) && is_array($__internal_compile_47) || $__internal_compile_47 instanceof ArrayAccess ? ($__internal_compile_47[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1153)] ?? null) : null)) && is_array($__internal_compile_46) || $__internal_compile_46 instanceof ArrayAccess ? ($__internal_compile_46[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1153)] ?? null) : null)) {
                    echo (($__internal_compile_48 = (($__internal_compile_49 = ($context["vendorallseller_seo_url"] ?? null)) && is_array($__internal_compile_49) || $__internal_compile_49 instanceof ArrayAccess ? ($__internal_compile_49[twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1153)] ?? null) : null)) && is_array($__internal_compile_48) || $__internal_compile_48 instanceof ArrayAccess ? ($__internal_compile_48[twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1153)] ?? null) : null);
                }
                echo "\" id=\"input-keyword-";
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1153);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1153);
                echo "\" placeholder=\"";
                echo ($context["entry_keyword"] ?? null);
                echo "\" class=\"form-control\"/>
                            </div>
                            <div id=\"error-keyword-";
                // line 1155
                echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 1155);
                echo "-";
                echo twig_get_attribute($this->env, $this->source, $context["language"], "language_id", [], "any", false, false, false, 1155);
                echo "\" class=\"invalid-feedback\"></div>
                          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['language'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 1156
            echo "</td>
                      </tr>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 1159
        echo "                  </tbody>
                </table>
              </div>
              </div>
\t\t\t  <!---SEO-->
\t\t\t\t\t\t\t
\t\t\t</div>\t\t\t\t
\t\t</form>
      </div>
    </div>
  </div>
</div>

<script src=\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js\"></script>

<script type=\"text/javascript\"><!--

\$('textarea[data-oc-toggle=\\'ckeditor\\']').ckeditor();

\$( \".component table tbody\" ).sortable();
\$( '.personaldata tbody' ).sortable({
\t\t  update : function () {
           \$('.personaldata tr').each(function(idx) {
\t\t\t\t\t\$(this).find('.personalsort').val(idx);
\t\t\t});
        }
});
var \$sorted_items,
getSorted = function(selector, attrName) {
    return \$(
      \$(selector).toArray().sort(function(a, b){
          var aVal = parseInt(a.getAttribute(attrName)),
              bVal = parseInt(b.getAttribute(attrName));
          return aVal - bVal;
      })
    );
};

\$sorted_items = getSorted('.personaldata tbody tr', 'data-sort').clone();
\$('.personaldata tbody').html(\$sorted_items);
//--></script>

<style>

.form-horizontal #tab-vendortabsetting .control-label{text-align:left!important;}

.btn-group > .btn.active, .btn-success.btn-success:active:hover, .btn-success.active:hover, .open > .btn-success.dropdown-toggle:hover, .btn-success:active:focus, .btn-success.active:focus, .open > .btn-success.dropdown-toggle:focus, .btn-success:active.focus, .btn-success.active.focus, .open > .btn-success.dropdown-toggle.focus
{ 
background-color: #3DBEEF;
  border-color: #3DBEEF;}
.btn-success {\t
color: #000;
    background-color: #fff;
    border-color: #fff;
    border: solid 1px #dccc;
    padding: 7px;
}
.btn-success:hover{
\tbackground-color: #0F89B7;
    border-color: #0F89B7;
}
.allsellers{background:#f5f5f5; padding:8px;}
.text-end .form-switch-lg{
\tfloat:right;
}
</style>

";
        // line 1226
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "extension/tmdmultivendor/admin/view/template/vendor/vendor_setting.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  2607 => 1226,  2538 => 1159,  2530 => 1156,  2520 => 1155,  2503 => 1153,  2495 => 1152,  2492 => 1151,  2488 => 1150,  2483 => 1148,  2480 => 1147,  2476 => 1146,  2469 => 1142,  2465 => 1141,  2457 => 1136,  2451 => 1132,  2443 => 1129,  2433 => 1128,  2416 => 1126,  2408 => 1125,  2405 => 1124,  2401 => 1123,  2396 => 1121,  2393 => 1120,  2389 => 1119,  2382 => 1115,  2378 => 1114,  2370 => 1109,  2364 => 1105,  2356 => 1102,  2346 => 1101,  2329 => 1099,  2321 => 1098,  2318 => 1097,  2314 => 1096,  2309 => 1094,  2306 => 1093,  2302 => 1092,  2295 => 1088,  2291 => 1087,  2283 => 1082,  2277 => 1078,  2269 => 1075,  2259 => 1074,  2242 => 1072,  2234 => 1071,  2231 => 1070,  2227 => 1069,  2222 => 1067,  2219 => 1066,  2215 => 1065,  2208 => 1061,  2204 => 1060,  2196 => 1055,  2190 => 1051,  2182 => 1048,  2172 => 1047,  2155 => 1045,  2147 => 1044,  2144 => 1043,  2140 => 1042,  2135 => 1040,  2132 => 1039,  2128 => 1038,  2121 => 1034,  2117 => 1033,  2109 => 1028,  2090 => 1014,  2082 => 1009,  2078 => 1008,  2072 => 1005,  2061 => 999,  2053 => 994,  2049 => 993,  2043 => 990,  2032 => 984,  2024 => 979,  2020 => 978,  2014 => 975,  2004 => 970,  1996 => 965,  1992 => 964,  1986 => 961,  1976 => 956,  1968 => 951,  1964 => 950,  1958 => 947,  1950 => 942,  1945 => 940,  1919 => 919,  1911 => 914,  1897 => 905,  1888 => 899,  1877 => 891,  1871 => 888,  1847 => 869,  1837 => 862,  1825 => 855,  1814 => 847,  1801 => 839,  1790 => 831,  1776 => 822,  1765 => 816,  1757 => 811,  1744 => 803,  1733 => 797,  1725 => 792,  1710 => 782,  1699 => 776,  1691 => 771,  1676 => 761,  1665 => 755,  1657 => 750,  1642 => 740,  1631 => 734,  1623 => 729,  1609 => 720,  1598 => 714,  1590 => 709,  1579 => 701,  1575 => 700,  1570 => 698,  1547 => 680,  1537 => 675,  1529 => 670,  1516 => 662,  1506 => 657,  1498 => 652,  1485 => 644,  1475 => 639,  1467 => 634,  1454 => 626,  1444 => 621,  1436 => 616,  1422 => 607,  1412 => 602,  1404 => 597,  1393 => 589,  1389 => 588,  1384 => 586,  1357 => 564,  1346 => 558,  1339 => 554,  1327 => 547,  1317 => 542,  1310 => 538,  1297 => 530,  1286 => 524,  1279 => 520,  1266 => 512,  1255 => 506,  1248 => 502,  1235 => 494,  1224 => 488,  1217 => 484,  1205 => 477,  1194 => 471,  1187 => 467,  1175 => 460,  1165 => 455,  1158 => 451,  1145 => 443,  1134 => 437,  1127 => 433,  1115 => 426,  1105 => 421,  1098 => 417,  1086 => 410,  1074 => 403,  1067 => 399,  1055 => 392,  1044 => 386,  1037 => 382,  1025 => 375,  1014 => 369,  1006 => 364,  995 => 356,  991 => 355,  986 => 353,  971 => 341,  967 => 340,  963 => 339,  959 => 338,  949 => 330,  921 => 325,  914 => 323,  900 => 318,  891 => 316,  885 => 313,  871 => 308,  864 => 306,  849 => 300,  842 => 298,  830 => 295,  823 => 293,  809 => 288,  802 => 286,  790 => 283,  783 => 281,  769 => 276,  762 => 274,  750 => 271,  743 => 269,  729 => 264,  722 => 262,  710 => 259,  703 => 257,  689 => 252,  682 => 250,  670 => 247,  663 => 245,  649 => 240,  642 => 238,  630 => 235,  623 => 233,  613 => 231,  596 => 230,  592 => 228,  563 => 226,  546 => 225,  541 => 223,  532 => 216,  526 => 215,  524 => 214,  519 => 211,  510 => 207,  505 => 206,  500 => 205,  495 => 203,  490 => 202,  488 => 201,  480 => 198,  472 => 195,  462 => 187,  453 => 183,  448 => 182,  443 => 181,  438 => 179,  433 => 178,  431 => 177,  423 => 174,  415 => 171,  395 => 156,  387 => 153,  375 => 146,  367 => 143,  356 => 137,  348 => 134,  337 => 128,  329 => 125,  323 => 122,  309 => 115,  302 => 113,  299 => 112,  292 => 111,  287 => 110,  283 => 109,  279 => 108,  271 => 105,  259 => 98,  251 => 95,  240 => 89,  232 => 86,  221 => 80,  213 => 77,  202 => 71,  194 => 68,  183 => 62,  175 => 59,  164 => 53,  156 => 50,  146 => 43,  142 => 42,  132 => 35,  128 => 34,  124 => 33,  120 => 32,  111 => 30,  106 => 28,  101 => 26,  96 => 24,  90 => 20,  83 => 17,  81 => 16,  78 => 15,  67 => 13,  63 => 12,  58 => 10,  52 => 9,  47 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "extension/tmdmultivendor/admin/view/template/vendor/vendor_setting.twig", "C:\\wamp\\www\\tutor\\extension\\tmdmultivendor\\admin\\view\\template\\vendor\\vendor_setting.twig");
    }
}
