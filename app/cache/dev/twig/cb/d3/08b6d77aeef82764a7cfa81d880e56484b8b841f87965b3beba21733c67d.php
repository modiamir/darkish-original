<?php

/* DarkishCategoryBundle:Record:index.html.twig */
class __TwigTemplate_cbd308b6d77aeef82764a7cfa81d880e56484b8b841f87965b3beba21733c67d extends Twig_Template
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
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/angular/tree-control.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
    <link href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/angular/tree-control-attributes.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
    <link href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/angular/ui-grid-unstable.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
";
    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        // line 11
        echo "<h1>News list</h1>

    <div class=\"container-fluid\" ng-controller=\"NewsIndexController\">
        <div class=\"row show-grid\">
            <div class=\"col-md-12\">
                <h1>شاخه بندی اخبار و سرگرمی</h1>
            </div>
        </div>
        <div class=\"row show-grid\">
            <div class=\"col-md-3\">
                <div >

                    <treecontrol class=\"tree-classic\"
                                 tree-model=\"dataForTheTree\"
                                 options=\"treeOptions\"
                                 on-selection=\"showSelected(node)\"
                                 selected-node=\"node1\">
                        [[node.title]]
                    </treecontrol>



                </div>
            </div>
            <div class=\"col-md-9\">
                <div class=\"jumbotron\">
                    <h1>سلام آقا خالقی!</h1>
                    [[ getForCategory ]]
                    <input ng-model=\"catid\" type=\"number\"/>
                    <button ng-click=\"clickForCat(catid)\">test</button>
                    <div id=\"grid1\" ui-grid=\"{ data: myData }\" class=\"grid\"></div>
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


    <script src=\"";
        // line 53
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/angular-tree-control.js"), "html", null, true);
        echo "\"></script>
    <script src=\"http://ui-grid.info/docs/grunt-scripts/pdfmake.js\"></script>
    <script src=\"http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js\"></script>
    <script src=\"";
        // line 56
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/ui-grid-unstable.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 57
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/Controllers/newsIndexCtrl.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 58
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/Services/newsService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 59
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/Services/treeService.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 60
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/angular/newsIndex.js"), "html", null, true);
        echo "\"></script>


";
    }

    public function getTemplateName()
    {
        return "DarkishCategoryBundle:Record:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 60,  123 => 59,  119 => 58,  115 => 57,  111 => 56,  105 => 53,  98 => 50,  95 => 49,  55 => 11,  52 => 10,  46 => 7,  42 => 6,  38 => 5,  33 => 4,  30 => 3,);
    }
}
