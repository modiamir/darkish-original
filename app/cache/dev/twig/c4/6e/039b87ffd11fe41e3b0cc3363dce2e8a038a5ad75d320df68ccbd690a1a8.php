<?php

/* ::panel_layout.html.twig */
class __TwigTemplate_c46e039b87ffd11fe41e3b0cc3363dce2e8a038a5ad75d320df68ccbd690a1a8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <title>Bootstrap 101 Template</title>

    ";
        // line 9
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 12
        echo "






</head>
<body ng-app=\"newsApp\">
    <nav class=\"navbar navbar-default\" role=\"navigation\">
        <div class=\"container\">
            <div class=\"navbar-header\">
                <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#bs-example-navbar-collapse-6\">
                    <span class=\"sr-only\">Toggle navigation</span>
                    <span class=\"icon-bar\"></span>
                    <span class=\"icon-bar\"></span>
                    <span class=\"icon-bar\"></span>
                </button>
                <a class=\"navbar-brand\" href=\"#\">درکیش</a>
            </div>
            <div class=\"collapse navbar-collapse\" id=\"bs-example-navbar-collapse-6\">
                <ul class=\"nav navbar-nav\">
                    <li><a href=\"#\">Home</a></li>
                    <li><a href=\"";
        // line 35
        echo $this->env->getExtension('routing')->getPath("admin_newstree");
        echo "\">
                                درخت اخبار و سرگرمی
                        </a></li>
                    <li><a href=\"#\">Link</a></li>
                </ul>
            </div>
        </div>
    </nav>

    ";
        // line 44
        $this->displayBlock('body', $context, $blocks);
        // line 45
        echo "

    ";
        // line 47
        $this->displayBlock('javascripts', $context, $blocks);
        // line 57
        echo "</body>
</html>";
    }

    // line 9
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 10
        echo "        <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/css/bootstrap-arabic.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" />
    ";
    }

    // line 44
    public function block_body($context, array $blocks = array())
    {
    }

    // line 47
    public function block_javascripts($context, array $blocks = array())
    {
        // line 48
        echo "        <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/fosjsrouting/js/router.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 49
        echo $this->env->getExtension('routing')->getPath("fos_js_routing_js", array("callback" => "fos.Router.setData"));
        echo "\"></script>
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js\"></script>
        <script type=\"text/javascript\" src=\"";
        // line 51
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/bootstrap-arabic.js"), "html", null, true);
        echo "\"></script>
        <script src=\"http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular.js\"></script>
        <script src=\"http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-touch.js\"></script>
        <script src=\"http://ajax.googleapis.com/ajax/libs/angularjs/1.2.16/angular-animate.js\"></script>

    ";
    }

    public function getTemplateName()
    {
        return "::panel_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 51,  107 => 49,  102 => 48,  99 => 47,  94 => 44,  87 => 10,  84 => 9,  79 => 57,  77 => 47,  73 => 45,  71 => 44,  59 => 35,  34 => 12,  32 => 9,  22 => 1,);
    }
}
