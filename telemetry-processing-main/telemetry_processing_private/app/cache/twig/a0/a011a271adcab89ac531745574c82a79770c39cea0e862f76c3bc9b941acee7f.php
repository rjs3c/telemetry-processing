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

/* boilerplate.html.twig */
class __TwigTemplate_0e65ac9b428a9c4f44ff93b25460917a43b9094704458788ece78e95e77b41f1 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        ob_start();
        // line 2
        echo "<!DOCTYPE html>
<html lang=”en\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
    <meta name=\"author\" content=\"James Brass, Mo Aziz, Ryan Instrell\">
    <meta name=\"viewport\" content=\"width-device-width, initial-scale=1.0\">
    <link rel=\"stylesheet\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, ($context["css_file"] ?? null), "html", null, true);
        echo "\" type=\"text/css\">
    <link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css\">
    <title>Telemetry Processing</title>
</head>
<header>
    ";
        // line 13
        $this->loadTemplate("header.html.twig", "boilerplate.html.twig", 13)->displayBlock("header", $context);
        echo "
</header>
<body>
";
        // line 16
        $this->displayBlock('content', $context, $blocks);
        // line 17
        echo "</body>
<footer>
    ";
        // line 19
        $this->loadTemplate("footer.html.twig", "boilerplate.html.twig", 19)->displayBlock("footer", $context);
        echo "
</footer>
</html>
";
        $extension = $this->env->getExtension(\nochso\HtmlCompressTwig\Extension::class);
        echo $extension->compress($this->env, ob_get_clean());
    }

    // line 16
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    public function getTemplateName()
    {
        return "boilerplate.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 16,  68 => 19,  64 => 17,  62 => 16,  56 => 13,  48 => 8,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "boilerplate.html.twig", "H:\\p3t\\phpappfolder\\includes\\telemetry_processing\\app\\templates\\boilerplate.html.twig");
    }
}
