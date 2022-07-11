<?php

class Controller
{
    public function render(string $template_file, ?string $view_file = null, ?array $params = null)
    {
        ob_start();

        if ($params != null) {
            extract($params);
        }
        include Constants::viewsPath() . $view_file . '.php';
        /**
         * $content
         * @var string rendered view file
         */
        $content = ob_get_clean();
        include Constants::viewsPath() . $template_file . '.php';
    }
}
