<?php

/* DarkishCategoryBundle:Default:index.html.twig */
class __TwigTemplate_0bb32bf141ba7b0a5c511fa181ba4b8d43de18db943c50142038f6b21256c02e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "

<div style=\"background: red\">
Hello ";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
        echo "!
</div>

";
    }

    public function getTemplateName()
    {
        return "DarkishCategoryBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
    }
}
