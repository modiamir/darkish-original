<?php

/* ::base.json.twig */
class __TwigTemplate_0997e6b76b64db319bb3a52e0069bc6b93d5c5d03d8f2c235ccc03a4a0423a18 extends Twig_Template
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
        echo "{ data | json_encode | raw }}";
    }

    public function getTemplateName()
    {
        return "::base.json.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
