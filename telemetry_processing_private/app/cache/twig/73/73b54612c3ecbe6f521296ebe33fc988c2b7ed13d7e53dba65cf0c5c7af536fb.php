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

/* presenttelemetrydata.html.twig */
class __TwigTemplate_547f1d49c39c0e0e943bd29fc6d927795599e8e7551fbeeafcd079bb1f35d386 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("boilerplate.html.twig", "presenttelemetrydata.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "        <div class=\"present-page content\">
            <h1>";
        // line 4
        echo twig_escape_filter($this->env, ($context["heading_1"] ?? null), "html", null, true);
        echo "</h1>
        </div>
        <div class=\"data-table-wrapper\">
            ";
        // line 7
        if ((twig_length_filter($this->env, ($context["telemetry_data"] ?? null)) > 0)) {
            // line 8
            echo "                <div class=\"data-table-info\">
                    <p>Page:";
            // line 9
            echo twig_escape_filter($this->env, ($context["page_number"] ?? null), "html", null, true);
            echo "</p>
                </div>
                <table class=\"data-table\">
                    <tr>
                        <th>Switch 1</th>
                        <th>Switch 2</th>
                        <th>Switch 3</th>
                        <th>Switch 4</th>
                        <th>Fan</th>
                        <th>Temperature</th>
                        <th>Keypad</th>
                    </tr>
                        ";
            // line 21
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["telemetry_data"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["data"]) {
                // line 22
                echo "                            <tr>
                                <td>";
                // line 23
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "switch_one", [], "any", false, false, false, 23));
                echo "</td>
                                <td>";
                // line 24
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "switch_two", [], "any", false, false, false, 24));
                echo "</td>
                                <td>";
                // line 25
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "switch_three", [], "any", false, false, false, 25));
                echo "</td>
                                <td>";
                // line 26
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "switch_four", [], "any", false, false, false, 26));
                echo "</td>
                                <td>";
                // line 27
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "fan", [], "any", false, false, false, 27));
                echo "</td>
                                <td>";
                // line 28
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "temperature", [], "any", false, false, false, 28));
                echo "</td>
                                <td>";
                // line 29
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["data"], "keypad", [], "any", false, false, false, 29));
                echo "</td>
                            </tr>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['data'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 32
            echo "                </table>
                <div class=\"data-buttons\">
                    ";
            // line 34
            if ((($context["page_number"] ?? null) > 1)) {
                // line 35
                echo "                        <form method=\"get\" action=\"presenttelemetrydata\">
                            <input type=\"hidden\" name=\"page\" value=";
                // line 36
                echo twig_escape_filter($this->env, (($context["page_number"] ?? null) - 1), "html", null, true);
                echo " />
                            <button id=\"prev\" type=\"submit\">Prev</button>
                        </form>
                    ";
            }
            // line 40
            echo "                    <button onclick=\"window.location.href='fetchtelemetrydata'\">Fetch</button>
                    ";
            // line 41
            if (($context["is_next_page"] ?? null)) {
                // line 42
                echo "                        <form action=\"presenttelemetrydata\">
                            <input type=\"hidden\" name=\"page\" value=";
                // line 43
                echo twig_escape_filter($this->env, (($context["page_number"] ?? null) + 1), "html", null, true);
                echo " />
                            <button id=\"next\" type=\"submit\">Next</button>
                        </form>
                    ";
            }
            // line 47
            echo "                </div>
            ";
        } else {
            // line 49
            echo "                <p>No telemetry data available.</p>
                <button onclick=\"window.location.href='fetchtelemetrydata'\">Fetch</button>
            ";
        }
        // line 52
        echo "
        </div>
    ";
    }

    public function getTemplateName()
    {
        return "presenttelemetrydata.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 52,  154 => 49,  150 => 47,  143 => 43,  140 => 42,  138 => 41,  135 => 40,  128 => 36,  125 => 35,  123 => 34,  119 => 32,  110 => 29,  106 => 28,  102 => 27,  98 => 26,  94 => 25,  90 => 24,  86 => 23,  83 => 22,  79 => 21,  64 => 9,  61 => 8,  59 => 7,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "presenttelemetrydata.html.twig", "/p3t/phpappfolder/includes/telemetry_processing/app/templates/presenttelemetrydata.html.twig");
    }
}
