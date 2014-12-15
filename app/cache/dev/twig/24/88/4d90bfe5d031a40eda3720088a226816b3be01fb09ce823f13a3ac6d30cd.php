<?php

/* DarkishCategoryBundle:NewsTree:show.html.twig */
class __TwigTemplate_24884d90bfe5d031a40eda3720088a226816b3be01fb09ce823f13a3ac6d30cd extends Twig_Template
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
                <table class=\"record_properties\">
                    <tbody>


                    <tr>
                        <th>
                            کد شاخه
                        </th>
                        <td>";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "treeIndex", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            ترتیب
                        </th>
                        <td>";
        // line 38
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "sort", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            عنوان
                        </th>
                        <td>";
        // line 44
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "title", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            زیرعنوان
                        </th>
                        <td>";
        // line 50
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "subTitle", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            کلید بازگشت
                        </th>
                        <td>";
        // line 56
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "backKeyTitle", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            کلیدواژه جستجو
                        </th>
                        <td>";
        // line 62
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "searchKeywords", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            نمایش زیردرخت به عنوان فیلتر
                        </th>
                        <td>";
        // line 68
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "showSubtreeAsFilter", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            نمایش باند اسپانسر
                        </th>
                        <td>";
        // line 74
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "showSponsorBox", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            گروه اسپانسر
                        </th>
                        <td>";
        // line 80
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "sponsorGroup", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            نام فایل آیکون
                        </th>
                        <td>";
        // line 86
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "iconFileName", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            آیکن های قابلیت های شاخه
                        </th>
                        <td>asd</td>
                    </tr>
                    <tr>
                        <th>رنگ فونت</th>
                        <td>";
        // line 96
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "fontColor", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>رنگ پس زمینه</th>
                        <td>";
        // line 100
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "backColor", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            نمایش تصویر در رکوردهای زیرشاخه
                        </th>
                        <td>";
        // line 106
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "subPicShow", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            تصویر زمینه زیرشاخه
                        </th>
                        <td>";
        // line 112
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "subBackground", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>
                            مقیاس ارتفاع باندهای زیرشاخه
                        </th>
                        <td>";
        // line 118
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "subUnitHeightScale", array()), "html", null, true);
        echo "</td>
                    </tr>
                    <tr>
                        <th>شاخه مخفی</th>
                        <td>";
        // line 122
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "hiddenTree", array()), "html", null, true);
        echo "</td>
                    </tr>
                    </tbody>
                </table>

                <ul class=\"record_actions\">
                    <li>
                        <a href=\"";
        // line 129
        echo $this->env->getExtension('routing')->getPath("admin_newstree");
        echo "\">
                            Back to the list
                        </a>
                    </li>
                    <li>
                        <a href=\"";
        // line 134
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_newstree_edit", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id", array()))), "html", null, true);
        echo "\">
                            Edit
                        </a>
                    </li>
                    <li>
                        <a href=\"";
        // line 139
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_newstree_addnews", array("id" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "id", array()))), "html", null, true);
        echo "\">
                            افزودن خبر
                        </a>
                    </li>
                    <li>";
        // line 143
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["delete_form"]) ? $context["delete_form"] : $this->getContext($context, "delete_form")), 'form');
        echo "</li>
                </ul>
            </div>
        </div>
    </div>


";
    }

    // line 153
    public function block_javascripts($context, array $blocks = array())
    {
        // line 154
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\" src=\"";
        // line 155
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("assets/js/jstree/jstree.min.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$(document).ready(function(){
            var data = ";
        // line 158
        echo twig_jsonencode_filter((isset($context["tree"]) ? $context["tree"] : $this->getContext($context, "tree")));
        echo ";
            console.log(data);
            var myArrayOfIDs = new Array();
            myArrayOfIDs[0] = ";
        // line 161
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "treeIndex", array()), "html", null, true);
        echo ";  //etc...
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
        return "DarkishCategoryBundle:NewsTree:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  272 => 161,  266 => 158,  260 => 155,  255 => 154,  252 => 153,  240 => 143,  233 => 139,  225 => 134,  217 => 129,  207 => 122,  200 => 118,  191 => 112,  182 => 106,  173 => 100,  166 => 96,  153 => 86,  144 => 80,  135 => 74,  126 => 68,  117 => 62,  108 => 56,  99 => 50,  90 => 44,  81 => 38,  72 => 32,  47 => 9,  44 => 8,  38 => 5,  33 => 4,  30 => 3,);
    }
}
