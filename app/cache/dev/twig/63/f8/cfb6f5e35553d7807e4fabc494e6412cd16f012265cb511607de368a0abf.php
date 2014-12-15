<?php

/* DarkishCategoryBundle:NewsTree:edit.html.twig */
class __TwigTemplate_63f8cfb6f5e35553d7807e4fabc494e6412cd16f012265cb511607de368a0abf extends Twig_Template
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
                <h1>NewsTree list</h1>
            </div>
        </div>
        <div class=\"row show-grid\">
            <div class=\"col-md-3\">
                <div id=\"using_json_2\">

                </div>
            </div>
            <div class=\"col-md-9\">
                ";
        // line 22
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["edit_form"]) ? $context["edit_form"] : $this->getContext($context, "edit_form")), 'form');
        echo "

                <ul class=\"record_actions\">
                    <li>
                        <a href=\"";
        // line 26
        echo $this->env->getExtension('routing')->getPath("admin_newstree");
        echo "\">
                            Back to the list
                        </a>
                    </li>
                    <li>";
        // line 30
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["delete_form"]) ? $context["delete_form"] : $this->getContext($context, "delete_form")), 'form');
        echo "</li>
                </ul>
            </div>
        </div>
    </div>


";
    }

    // line 40
    public function block_javascripts($context, array $blocks = array())
    {
        // line 41
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\" src=\"";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/jstree/jstree.min.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$(document).ready(function(){
            var data = ";
        // line 45
        echo twig_jsonencode_filter((isset($context["tree"]) ? $context["tree"] : $this->getContext($context, "tree")));
        echo ";
            console.log(data);

            \$('#using_json_2').jstree({ 'core' : {
                'data' : data
            } }).bind(
                    \"select_node.jstree\", function(evt, data){
                        //selected node object: data.inst.get_json()[0];
                        //selected node text: data.inst.get_json()[0].data
                        //window.location.replace(\"http://stackoverflow.com\");
                        console.log(data.node.original.original_id);
                        window.location.replace(Routing.generate('admin_newstree_show', {id: data.node.original.original_id}));

                    }
            );
        });
    </script>

";
    }

    public function getTemplateName()
    {
        return "DarkishCategoryBundle:NewsTree:edit.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 45,  96 => 42,  91 => 41,  88 => 40,  76 => 30,  69 => 26,  62 => 22,  47 => 9,  44 => 8,  38 => 5,  33 => 4,  30 => 3,);
    }
}
