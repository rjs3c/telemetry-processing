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
class __TwigTemplate_45aa6133c1e314606388404c2eccf1752c2e3f3a05025bb06ae6bf991a230548 extends \Twig\Template
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
        <div class=\"header-links\">
            <a href=";
        // line 7
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "homepage", [], "any", false, false, false, 7), "html", null, true);
        echo ">Home</a>
            <a href=";
        // line 8
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "login", [], "any", false, false, false, 8), "html", null, true);
        echo ">Login</a>
            <a href=";
        // line 9
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["links"] ?? null), "register", [], "any", false, false, false, 9), "html", null, true);
        echo ">Register</a>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "header.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  60 => 9,  56 => 8,  52 => 7,  45 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "header.html.twig", "H:\\p3t\\phpappfolder\\includes\\telemetry_processing\\app\\templates\\header.html.twig");
    }
}
