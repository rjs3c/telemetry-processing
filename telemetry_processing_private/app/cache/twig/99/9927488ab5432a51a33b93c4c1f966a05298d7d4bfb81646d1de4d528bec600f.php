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

/* manageusersform.html.twig */
class __TwigTemplate_d194830bbdf48986ccaad65e3484a70fc7725b363f015ae526a3bfdd27f40339 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("boilerplate.html.twig", "manageusersform.html.twig", 1);
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
                <div class=\"data-table-wrapper\">
                    <table class=\"data-table\">
                        <tr>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                        ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable([0 => "test"]);
        foreach ($context['_seq'] as $context["_key"] => $context["username"]) {
            // line 13
            echo "                            <tr>
                                <td>";
            // line 14
            echo twig_escape_filter($this->env, $context["username"]);
            echo "</td>
                                <td>
                                    <form action=\"manageuserschangepassword\" method=\"post\">
                                            <input class=\"form-input-text\" name=\"username\" type=\"hidden\" value=\"";
            // line 17
            echo twig_escape_filter($this->env, $context["username"]);
            echo "\">
                                        <div class=\"form-input\">
                                            <input id=\"password\" name=\"password\" type=\"password\" placeholder=\"Password\" size=\"30\"  size=\"33\" maxlength=\"32\" tabindex=\"2\" required>
                                            <button id=\"show-password\" type=\"button\" onclick=\"maskPassword()\"><i class=\"fa fa-eye-slash\"></i></button>
                                        </div>
                                            <button class=\"form-input-button\"  type=\"submit\">Change Password</button>
                                        <script type=\"text/javascript\">
                                            function maskPassword() {
                                                let password = document.querySelector('#new-password');
                                                let show_new_password = document.querySelector('#show-new-password')
                                                if (password.type === \"password\") {
                                                    password.type = \"text\";
                                                    show_new_password.innerHTML = \"<i class='fa fa-eye'>\";
                                                } else {
                                                    password.type = \"password\";
                                                    show_new_password.innerHTML = \"<i class='fa fa-eye-slash' >\";
                                                }
                                            }
                                        </script>
                                    </form>
                                </td>
                                <td>
                                    <div class=\"form-button\">
                                        <a href=\"manageusersdelete?username=";
            // line 40
            echo twig_escape_filter($this->env, twig_urlencode_filter(twig_escape_filter($this->env, $context["username"], "url")), "html", null, true);
            echo "\">
                                            <button class=\"delete-input-button\" type=\"button\">Delete</button>
                                        </a>
                                    </div>

                                </td>
                            </tr>
                        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['username'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 48
        echo "                    </table>
                </div>
    ";
    }

    public function getTemplateName()
    {
        return "manageusersform.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 48,  103 => 40,  77 => 17,  71 => 14,  68 => 13,  64 => 12,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "manageusersform.html.twig", "/p3t/phpappfolder/includes/telemetry_processing/app/templates/manageusersform.html.twig");
    }
}
