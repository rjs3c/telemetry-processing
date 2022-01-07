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

/* sendtelemetrydataresult.html.twig */
class __TwigTemplate_43b297483e0c5c1a494b10ad46febd42bd88326d1e494e3235e03aee57c8a106 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("boilerplate.html.twig", "sendtelemetrydataresult.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "        <div class=\"present-page content\">
            <h1 class=\"heading\">";
        // line 4
        echo twig_escape_filter($this->env, ($context["heading_1"] ?? null), "html", null, true);
        echo "</h1>
        </div>
        <p>";
        // line 6
        echo twig_escape_filter($this->env, ($context["circuit_board_status"] ?? null), "html", null, true);
        echo "</p>
    ";
    }

    public function getTemplateName()
    {
        return "sendtelemetrydataresult.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 6,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "sendtelemetrydataresult.html.twig", "/p3t/phpappfolder/includes/telemetry_processing/app/templates/sendtelemetrydataresult.html.twig");
    }
}
