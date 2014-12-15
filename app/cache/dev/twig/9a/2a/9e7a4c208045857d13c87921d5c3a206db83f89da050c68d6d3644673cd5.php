<?php

/* DarkishCategoryBundle:NewsTree:addNews.html.twig */
class __TwigTemplate_9a2a9e7a4c208045857d13c87921d5c3a206db83f89da050c68d6d3644673cd5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::panel_layout.html.twig");

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::panel_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "
    <link href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/jstree/themes/default/style.min.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
";
    }

    // line 8
    public function block_body($context, array $blocks = array())
    {
        // line 9
        echo "<div class=\"container-fluid\">
        <div class=\"row show-grid\">
            <div class=\"col-md-12\">
                <h1>
                    شاخه بندی اخبار و سرگرمی
                </h1>
            </div>
        </div>
        <div class=\"row show-grid\">
            <div class=\"col-md-3\">
                <div id=\"using_json_2\">

                </div>
            </div>
            <div class=\"col-md-9\">
                ";
        // line 24
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form');
        echo "

                <ul class=\"record_actions\">
                    <li>
                        <a href=\"";
        // line 28
        echo $this->env->getExtension('routing')->getPath("admin_newstree");
        echo "\">
                            Back to the list
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


";
    }

    // line 41
    public function block_javascripts($context, array $blocks = array())
    {
        // line 42
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\" src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/jstree/jstree.min.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$(document).ready(function(){
            var data = ";
        // line 46
        echo twig_jsonencode_filter((isset($context["tree"]) ? $context["tree"] : $this->getContext($context, "tree")));
        echo ";
            console.log(data);
            var myArrayOfIDs = new Array();
            var tree = \$('#using_json_2').jstree({ 'core' : {
                'data' : data,
                'selected' : myArrayOfIDs
            } }).bind(
                    \"select_node.jstree\", function(evt, data){
                        //selected node object: data.inst.get_json()[0];
                        //selected node text: data.inst.get_json()[0].data
                        //window.location.replace(\"http://stackoverflow.com\");
                        console.log(data.node.original.original_id);
                        window.location.replace(Routing.generate('admin_newstree_show', {id: data.node.original.original_id}));

                    }
            ).bind(\"reselect.jstree\", function () {
                        jQuery(\"#using_json_2\").jstree(\"select_node\", \"#00\");
                    });


        });
    </script>

";
    }

    public function getTemplateName()
    {
        return "DarkishCategoryBundle:NewsTree:addNews.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 46,  94 => 43,  89 => 42,  86 => 41,  71 => 28,  64 => 24,  47 => 9,  44 => 8,  38 => 5,  33 => 4,  30 => 3,);
    }
}
