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

/* extension/tmdmultivendor/admin/view/template/module/tmdvendor.twig */
class __TwigTemplate_927bb173e89a4deff0ca68cb87383d3058705863673727b9b36d2927e90a8f6b extends Template
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
        <button type=\"submit\" form=\"form-module\" data-bs-toggle=\"tooltip\" title=\"";
        // line 6
        echo ($context["button_save"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fas fa-save\"></i></button>
        <a href=\"";
        // line 7
        echo ($context["back"] ?? null);
        echo "\" data-bs-toggle=\"tooltip\" title=\"";
        echo ($context["button_back"] ?? null);
        echo "\" class=\"btn btn-light\"><i class=\"fas fa-reply\"></i></a></div>
      <h1>";
        // line 8
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 11
            echo "          <li class=\"breadcrumb-item\"><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 11);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 11);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        echo "      </ol>
    </div>
  </div>
  ";
        // line 16
        echo ($context["getkeyform"] ?? null);
        echo "
  <div class=\"container-fluid\">
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fas fa-pencil-alt\"></i> ";
        // line 19
        echo ($context["text_edit"] ?? null);
        echo "</div>
      <div class=\"card-body\">
        <form id=\"form-module\" action=\"";
        // line 21
        echo ($context["save"] ?? null);
        echo "\" method=\"post\" data-oc-toggle=\"ajax\">
          
          <div class=\"row mb-3\">
            <label class=\"col-sm-2 col-form-label\" for=\"input-imagetype\">";
        // line 24
        echo ($context["entry_imgbotrder"] ?? null);
        echo "</label>
            <div class=\"col-sm-6\">
              <select name=\"module_tmdvendor_imagetype\" id=\"input-imagetype\" class=\"form-control\">
                ";
        // line 27
        if ((($context["module_tmdvendor_imagetype"] ?? null) == "round")) {
            // line 28
            echo "                <option value=\"round\" selected=\"selected\">";
            echo ($context["entry_round"] ?? null);
            echo "</option>
                <option value=\"rect\">";
            // line 29
            echo ($context["entry_squre"] ?? null);
            echo "</option>
                ";
        } else {
            // line 31
            echo "                <option value=\"round\">";
            echo ($context["entry_round"] ?? null);
            echo "</option>
                <option value=\"rect\" selected=\"selected\">";
            // line 32
            echo ($context["entry_squre"] ?? null);
            echo "</option>
                ";
        }
        // line 34
        echo "              </select>
            </div>
          </div>
          <div class=\"row mb-3\">
            <label class=\"col-sm-2 col-form-label\" for=\"input-bgcolor\">";
        // line 38
        echo ($context["entry_bgcolor"] ?? null);
        echo "</label>
            <div class=\"col-sm-6\">
              <input type=\"text\" name=\"module_tmdvendor_bgcolor\" value=\"";
        // line 40
        echo ($context["module_tmdvendor_bgcolor"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_bgcolor"] ?? null);
        echo "\" id=\"input-bgcolor\" class=\"form-control demo\" />
            </div>
          </div>
          <div class=\"row mb-3\">
            <label class=\"col-sm-2 col-form-label\" for=\"input-textcolor\">";
        // line 44
        echo ($context["entry_textcolor"] ?? null);
        echo "</label>
            <div class=\"col-sm-6\">
              <input type=\"text\" name=\"module_tmdvendor_textcolor\" value=\"";
        // line 46
        echo ($context["module_tmdvendor_textcolor"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_textcolor"] ?? null);
        echo "\" id=\"input-textcolor\" class=\"form-control demo\" />
            </div>
          </div>
          <div class=\"row mb-3\">
            <label class=\"col-sm-2 col-form-label\" for=\"input-imgsize\">";
        // line 50
        echo ($context["entry_imgsize"] ?? null);
        echo "</label>
            <div class=\"col-sm-3\">
              <input type=\"text\" name=\"module_tmdvendor_imgwidth\" value=\"";
        // line 52
        echo ($context["module_tmdvendor_imgwidth"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_imgwidth"] ?? null);
        echo "\" id=\"input-imgsize\" class=\"form-control\" />
            </div>
            <div class=\"col-sm-3\">
              <input type=\"text\" name=\"module_tmdvendor_imgheight\" value=\"";
        // line 55
        echo ($context["module_tmdvendor_imgheight"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_imgheight"] ?? null);
        echo "\" id=\"input-imgsize\" class=\"form-control\" />
            </div>
          </div>
      
          <div class=\"row mb-3\">
            <label for=\"input-status\" class=\"col-sm-2 col-form-label\">";
        // line 60
        echo ($context["entry_status"] ?? null);
        echo "</label>
            <div class=\"col-sm-9\">
              <select name=\"module_tmdvendor_status\" id=\"input-status\" class=\"form-select\">
                <option value=\"1\"";
        // line 63
        if (($context["module_tmdvendor_status"] ?? null)) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_enabled"] ?? null);
        echo "</option>
                <option value=\"0\"";
        // line 64
        if ( !($context["module_tmdvendor_status"] ?? null)) {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo ($context["text_disabled"] ?? null);
        echo "</option>
              </select>
            </div>
          </div>


        </form>
      </div>
    </div>
  </div>

  <script src=\"";
        // line 75
        echo ($context["HTTP_CATALOG"] ?? null);
        echo "extension/tmdmultivendor/admin/view/javascript/colorbox/jquery.minicolors.js\"></script>
<link rel=\"stylesheet\" href=\"";
        // line 76
        echo ($context["HTTP_CATALOG"] ?? null);
        echo "extension/tmdmultivendor/admin/view/javascript/colorbox/jquery.minicolors.css\">
<script type=\"text/javascript\"><!--
\$(document).ready( function() {
    \$('.demo').each( function() {
      \$(this).minicolors({
    control: \$(this).attr('data-control') || 'hue',
    defaultValue: \$(this).attr('data-defaultValue') || '',
    inline: \$(this).attr('data-inline') === 'true',
    letterCase: \$(this).attr('data-letterCase') || 'lowercase',
    opacity: \$(this).attr('data-opacity'),
    position: \$(this).attr('data-position') || 'bottom left',
    change: function(hex, opacity) {
    if( !hex ) return;
    if( opacity ) hex += ', ' + opacity;
      try {
        console.log(hex);
      } catch(e) {}
    },
    theme: 'bootstrap'
    });
    });
});
//--></script>
</div>
";
        // line 100
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "extension/tmdmultivendor/admin/view/template/module/tmdvendor.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  246 => 100,  219 => 76,  215 => 75,  197 => 64,  189 => 63,  183 => 60,  173 => 55,  165 => 52,  160 => 50,  151 => 46,  146 => 44,  137 => 40,  132 => 38,  126 => 34,  121 => 32,  116 => 31,  111 => 29,  106 => 28,  104 => 27,  98 => 24,  92 => 21,  87 => 19,  81 => 16,  76 => 13,  65 => 11,  61 => 10,  56 => 8,  50 => 7,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "extension/tmdmultivendor/admin/view/template/module/tmdvendor.twig", "C:\\wamp\\www\\tutor\\extension\\tmdmultivendor\\admin\\view\\template\\module\\tmdvendor.twig");
    }
}
