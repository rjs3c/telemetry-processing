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
class __TwigTemplate_0e1b2021549eceb5f23f1f193d730aaeba6abc2631e38f06381aa3b0dc6c7d5c extends \Twig\Template
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

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "        <div class=\"homepage content\">
            <h1 class=\"heading\">";
        // line 5
        echo twig_escape_filter($this->env, ($context["heading_1"] ?? null), "html", null, true);
        echo "</h1>
            <p>Group 21-3110-AF</p>
            <div class=\"content-wrapper homepage-wrapper\">
                <div class=\"homepage-links\">
                    <div class=\"homepage-link\"><a href=\"";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "fetch_telemetry", [], "any", false, false, false, 9), "html", null, true);
        echo "\">Fetch and Store Telemetry Data</a></div>
                    <div class=\"homepage-link\"><a href=\"";
        // line 10
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "present_telemetry", [], "any", false, false, false, 10), "html", null, true);
        echo "\">Show Stored Telemetry Data</a> </div>
                </div>
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
        return array (  64 => 10,  60 => 9,  53 => 5,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "homepage.html.twig", "H:\\p3t\\phpappfolder\\includes\\telemetry_processing\\app\\templates\\homepage.html.twig");
    }
}
