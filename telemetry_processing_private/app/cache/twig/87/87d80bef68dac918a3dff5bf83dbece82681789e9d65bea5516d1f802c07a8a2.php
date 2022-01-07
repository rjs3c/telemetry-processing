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

/* registerform.html.twig */
class __TwigTemplate_509c389db2ad732c027c5d089dd1b661c3ca7bd3623492c3f3b3ae5c51e55196 extends \Twig\Template
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
        $this->parent = $this->loadTemplate("boilerplate.html.twig", "registerform.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "        <div class=\"login-page content\">
            <h1 class=\"heading\">";
        // line 4
        echo twig_escape_filter($this->env, ($context["heading_1"] ?? null), "html", null, true);
        echo "</h1>

            <form action=\"";
        // line 6
        echo twig_escape_filter($this->env, ($context["register_action"] ?? null), "html", null, true);
        echo "\" method=\"post\">
                <div class=\"form-elements\">
                    <div class=\"form-wrapper\">
                        <h2 id=\"login-heading\">Telemetry Processing</h2>
                        <div class=\"message-info form-input\">
                            <i class=\"fa fa-info\"></i>
                            <span>Enter your details below.</span>
                        </div>
                        <div class=\"form-input\">
                            <label for=\"username\">Username:</label>
                            <br>
                            <input class=\"form-input-text\" id=\"username\" name=\"username\" type=\"text\" placeholder=\"Username\" size=\"33\" maxlength=\"32\" tabindex=\"1\" required>
                            <br><br>
                        </div>
                        <div class=\"form-input\" id=\"password-input\">
                            <label for=\"password\">Password:</label>
                            <br>
                            <input  id=\"password\" name=\"password\" type=\"password\" placeholder=\"Password\" size=\"30\"  size=\"33\" maxlength=\"32\" tabindex=\"2\" required>
                            <button id=\"show-password\" type=\"button\" onclick=\"maskPassword()\"><i class=\"fa fa-2x fa-eye-slash\"></i></button>
                        </div>
                        ";
        // line 27
        echo "                        ";
        // line 28
        echo "                        ";
        // line 29
        echo "                        ";
        // line 30
        echo "                        ";
        // line 31
        echo "                        ";
        // line 32
        echo "                        <div class=\"form-input\">
                            <input class=\"form-input-button\" type=\"submit\" value=\"Register\">

                        </div>
                    </div>
                </div>
                <script type=\"text/javascript\">
                    function maskPassword() {
                        let password = document.querySelector('#password');
                        let show_password = document.querySelector('#show-password')
                        if (password.type === \"password\") {
                            password.type = \"text\";
                            show_password.innerHTML = \"<i class='fa fa-2x fa-eye'>\";
                        } else {
                            password.type = \"password\";
                            show_password.innerHTML = \"<i class='fa fa-2x fa-eye-slash' >\";


                        }
                    }
                </script>
            </form>
        </div>
    ";
    }

    public function getTemplateName()
    {
        return "registerform.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 32,  89 => 31,  87 => 30,  85 => 29,  83 => 28,  81 => 27,  58 => 6,  53 => 4,  50 => 3,  46 => 2,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "registerform.html.twig", "/p3t/phpappfolder/includes/telemetry_processing/app/templates/registerform.html.twig");
    }
}
