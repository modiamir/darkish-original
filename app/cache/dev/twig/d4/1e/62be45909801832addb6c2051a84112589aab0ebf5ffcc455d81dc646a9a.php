<?php

/* DarkishCategoryBundle:NewsTree:index.html.twig */
class __TwigTemplate_d41e62be45909801832addb6c2051a84112589aab0ebf5ffcc455d81dc646a9a extends Twig_Template
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
    <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/angular/tree-control.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
    <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/angular/tree-control-attributes.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
";
    }

    // line 12
    public function block_body($context, array $blocks = array())
    {
        // line 13
        echo "<div class=\"container-fluid\">
        <div class=\"row show-grid\">
            <div class=\"col-md-12\">
                <h1>شاخه بندی اخبار و سرگرمی</h1>
            </div>
        </div>
        <div class=\"row show-grid\">
            <div class=\"col-md-3\">
                <div id=\"using_json_2\">

                </div>
            </div>
            <div class=\"col-md-9\">
                <div class=\"jumbotron\">
                    <h1>سلام آقا خالقی!</h1>
                    <div ng-controller=\"NewsIndexController\">
                        [[ test ]]
                        <treecontrol class=\"tree-classic\"
                                     tree-model=\"dataForTheTree\"
                                     options=\"treeOptions\"
                                     on-selection=\"showSelected(node)\"
                                     selected-node=\"node1\">
                            employee: [[node.name]] age [[node.age]]
                        </treecontrol>


                    </div>
                </div>
            </div>
        </div>
    </div>


    ";
    }

    // line 49
    public function block_javascripts($context, array $blocks = array())
    {
        // line 50
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\" src=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/jstree/jstree.min.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$(document).ready(function(){
            var data = ";
        // line 54
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

    <script src=\"";
        // line 74
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/angular-tree-control.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 75
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/Controllers/newsIndexCtrl.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 76
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/Controllers/newsService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 77
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/newsIndex.js"), "html", null, true);
        echo "\"></script>

";
    }

    public function getTemplateName()
    {
        return "DarkishCategoryBundle:NewsTree:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  141 => 77,  137 => 76,  133 => 75,  129 => 74,  106 => 54,  100 => 51,  95 => 50,  92 => 49,  55 => 13,  52 => 12,  46 => 7,  42 => 6,  38 => 5,  33 => 4,  30 => 3,);
    }
}
