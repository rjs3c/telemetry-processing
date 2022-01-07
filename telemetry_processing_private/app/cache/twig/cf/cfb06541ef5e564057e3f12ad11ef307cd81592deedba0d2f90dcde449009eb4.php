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

/* header.html.twig */
class __TwigTemplate_5242ef13a8865e6310802db6fc46514fc7c4d5951ca0d4588681de9445b3dbdc extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'header' => [$this, 'block_header'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        $this->displayBlock('header', $context, $blocks);
    }

    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 2
        echo "    <div class=\"header\">
        <div class=\"not-header-links\">
            Telemetry Processing
        </div>

        ";
        // line 7
        if (($context["isAdmin"] ?? null)) {
            // line 8
            echo "            <div class=\"header-links\">
                <a href=";
            // line 9
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "homepage", [], "any", false, false, false, 9), "html", null, true);
            echo ">Home</a>
                <a href=";
            // line 10
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "logout", [], "any", false, false, false, 10), "html", null, true);
            echo ">Logout</a>
            </div>
        ";
        } else {
            // line 13
            echo "            <div class=\"header-links\">
                <a href=";
            // line 14
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "homepage", [], "any", false, false, false, 14), "html", null, true);
            echo ">Home</a>
                <a href=";
            // line 15
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "login", [], "any", false, false, false, 15), "html", null, true);
            echo ">Login</a>
                <a href=";
            // line 16
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "register", [], "any", false, false, false, 16), "html", null, true);
            echo ">Register</a>
            </div>
        ";
        }
        // line 19
        echo "
    </div>
";
    }

    public function getTemplateName()
    {
        return "header.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  84 => 19,  78 => 16,  74 => 15,  70 => 14,  67 => 13,  61 => 10,  57 => 9,  54 => 8,  52 => 7,  45 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.html.twig", "/p3t/phpappfolder/includes/telemetry_processing/app/templates/header.html.twig");
    }
}
