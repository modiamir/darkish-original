<?php

/* FOSUserBundle:Profile:show.html.twig */
class __TwigTemplate_b5fe68e809c18ab7ab8d878cda35d91f0e7efca7783f79f8a45237fef69e6ecb extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("SonataUserBundle:Profile:action.html.twig");

        $this->blocks = array(
            'sonata_profile_content' => array($this, 'block_sonata_profile_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataUserBundle:Profile:action.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 14
    public function block_sonata_profile_content($context, array $blocks = array())
    {
        // line 15
        echo "    ";
        echo "<div class='alert alert-default alert-info'>
    <strong>This is the user profile template. Feel free to override it.</strong>
    <div>sonata_core_template_box_file_found_in <code>{$this->getTemplateName()}</code>.</div>
</div>";        // line 16
        echo "
    <div class=\"row row-fluid\">
        ";
        // line 18
        $context["has_center"] = false;
        // line 19
        echo "        ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["blocks"]) ? $context["blocks"] : $this->getContext($context, "blocks")));
        foreach ($context['_seq'] as $context["_key"] => $context["block"]) {
            // line 20
            echo "            ";
            if (($this->getAttribute($context["block"], "position", array()) == "center")) {
                // line 21
                echo "                ";
                $context["has_center"] = true;
                // line 22
                echo "            ";
            }
            // line 23
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['block'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 24
        echo "
        <div class=\"";
        // line 25
        if ((isset($context["has_center"]) ? $context["has_center"] : $this->getContext($context, "has_center"))) {
            echo "span4 col-lg-4";
        } else {
            echo "span6 col-lg-6";
        }
        echo "\">
            ";
        // line 26
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["blocks"]) ? $context["blocks"] : $this->getContext($context, "blocks")));
        foreach ($context['_seq'] as $context["_key"] => $context["block"]) {
            // line 27
            echo "                ";
            if (($this->getAttribute($context["block"], "position", array()) == "left")) {
                // line 28
                echo "                    ";
                echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => $this->getAttribute($context["block"], "type", array()), "settings" => $this->getAttribute($context["block"], "settings", array()))));
                echo "
                ";
            }
            // line 30
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['block'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "        </div>

        ";
        // line 33
        if ((isset($context["has_center"]) ? $context["has_center"] : $this->getContext($context, "has_center"))) {
            // line 34
            echo "            <div class=\"span4 col-lg-4\">
                ";
            // line 35
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["blocks"]) ? $context["blocks"] : $this->getContext($context, "blocks")));
            foreach ($context['_seq'] as $context["_key"] => $context["block"]) {
                // line 36
                echo "                    ";
                if (($this->getAttribute($context["block"], "position", array()) == "center")) {
                    // line 37
                    echo "                        ";
                    echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => $this->getAttribute($context["block"], "type", array()), "settings" => $this->getAttribute($context["block"], "settings", array()))));
                    echo "
                    ";
                }
                // line 39
                echo "                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['block'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 40
            echo "            </div>
        ";
        }
        // line 42
        echo "
        <div class=\"";
        // line 43
        if ((isset($context["has_center"]) ? $context["has_center"] : $this->getContext($context, "has_center"))) {
            echo "span4 col-lg-4";
        } else {
            echo "span6 col-lg-6";
        }
        echo "\">
            ";
        // line 44
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["blocks"]) ? $context["blocks"] : $this->getContext($context, "blocks")));
        foreach ($context['_seq'] as $context["_key"] => $context["block"]) {
            // line 45
            echo "                ";
            if (($this->getAttribute($context["block"], "position", array()) == "right")) {
                // line 46
                echo "                    ";
                echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => $this->getAttribute($context["block"], "type", array()), "settings" => $this->getAttribute($context["block"], "settings", array()))));
                echo "
                ";
            }
            // line 48
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['block'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 49
        echo "        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Profile:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  154 => 49,  148 => 48,  142 => 46,  139 => 45,  135 => 44,  127 => 43,  124 => 42,  120 => 40,  114 => 39,  108 => 37,  105 => 36,  101 => 35,  98 => 34,  96 => 33,  92 => 31,  86 => 30,  80 => 28,  77 => 27,  73 => 26,  65 => 25,  62 => 24,  56 => 23,  53 => 22,  50 => 21,  47 => 20,  42 => 19,  40 => 18,  36 => 16,  31 => 15,  28 => 14,);
    }
}
