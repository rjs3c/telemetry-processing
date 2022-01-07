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

/* homepage.html.twig */
class __TwigTemplate_42f86c2ab1422ec3d54d54ea7c317233a709d1e8161dbee0993bbe664255f35e extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "boilerplate.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("boilerplate.html.twig", "homepage.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "        <div class=\"homepage content\">
            <h1 class=\"heading\">";
        // line 4
        echo twig_escape_filter($this->env, ($context["heading_1"] ?? null), "html", null, true);
        echo "</h1>
            <p>Group 21-3110-AF</p>
            <div class=\"content-wrapper homepage-wrapper\">
                <div class=\"homepage-links\">
                    <div class=\"homepage-link\"><a href=\"";
        // line 8
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "present_telemetry", [], "any", false, false, false, 8), "html", null, true);
        echo "\">Fetch and Present Telemetry Data</a> </div>
                    <div class=\"homepage-link\"><a href=\"";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "send_telemetry", [], "any", false, false, false, 9), "html", null, true);
        echo "\">Circuit Board Status</a> </div>
                    ";
        // line 10
        if (($context["isAdmin"] ?? null)) {
            // line 11
            echo "                    <div class=\"homepage-link\"><a href=\"";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "manage_users", [], "any", false, false, false, 11), "html", null, true);
            echo "\">Manage Registered Users</a> </div>
                    ";
        }
        // line 13
        echo "                </div>
            </div>
        </div>
    ";
    }

    public function getTemplateName()
    {
        return "homepage.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 13,  70 => 11,  68 => 10,  64 => 9,  60 => 8,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "homepage.html.twig", "/p3t/phpappfolder/includes/telemetry_processing/app/templates/homepage.html.twig");
    }
}
