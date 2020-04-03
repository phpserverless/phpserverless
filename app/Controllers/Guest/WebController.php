<?php

namespace App\Controllers\Guest;

class WebController
{
    public function anyIndex()
    {
        return $this->anyHome();
    }

    public function anyHome()
    {
        return \blade('guest/home');
    }

    public function anyPage($page = "home")
    {
        $namespace = "guest";
        $viewPath = basePath('views/' . $namespace . '/' . $page . '.blade.php');
        if (!\file_exists($viewPath)) {
            if (\Sinevia\Registry::equals('ENVIRONMENT', 'live') == false) {
                return $viewPath . ' page not found';
            }
            return 'Page not found';
        }

        return \blade($namespace . '/' . $page);
    }

    public function anyModulePage($module, $page = "home")
    {
        if ($module == '') {
            return $this->anyPage();
        }
        if ($module == 'home') {
            return $this->anyPage();
        }
        $namespace = "guest";
        $viewPath = basePath('views/' . $namespace . '/' . $module . '/' . $page . '.blade.php');
        if (!\file_exists($viewPath)) {
            if (\Sinevia\Registry::equals('ENVIRONMENT', 'live') == false) {
                return $viewPath . ' module page not found';
            }
            return 'Module page not found';
        }

        return \blade($namespace . '/' . $module . '/' . $page);
    }
}