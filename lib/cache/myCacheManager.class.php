<?php
class myCacheManager {
    const app_name = 'frontend';
    static protected $env_types = array('cache', 'prod');
    static protected $is_debug;
    static protected $prev_application;
    static protected $prev_sfconfig;
    static protected $prev_env;

    //uniwersalna metoda niezalezna od rodzaju cache
    static public function clearCache($pattern) {
        self::$prev_sfconfig = sfConfig::getAll();
        $currentConfiguration = sfContext::getInstance()->getConfiguration();

        self::$prev_env = $currentConfiguration->getEnvironment();
        self::$env_types[] = self::$prev_env;
        self::$env_types = array_unique(self::$env_types);
        //var_dump($currentConfiguration->getEnvironment());
        //var_dump($currentConfiguration->isDebug()); exit();
        self::$prev_application = $currentConfiguration->getApplication(); //pobieram nazwe aplikacji z ktorej odpalam czyszczenie cache admin/system
        self::$is_debug = $currentConfiguration->isDebug(); //czy jest wlaczony tryb debugowania

        foreach (self::$env_types as $env) {
            $frontend_context = self::getFrontendContext($env);
            $view_cache_manager = $frontend_context->getViewCacheManager();
            //zobaczyc czy tu nie potrzeba jakiegos zabezpieczenia jak nie ma cache
            if($view_cache_manager) {
                $view_cache = $view_cache_manager->getCache();
                $view_cache->removePattern(sprintf('**%s**', $pattern));
            }
        }
        self::returnToDefaultContext();
    }

    static protected function getFrontendContext($env) {
        $configuration = ProjectConfiguration::getApplicationConfiguration(self::app_name, $env, self::$is_debug);
        //inicializuje context do aplikacji systemowej (od strony internauty)
        return sfContext::createInstance($configuration, sprintf('%s_%s', self::app_name, $env));
    }

    static protected function returnToDefaultContext() {
        //tworzy ponownie obecny context, sposob na csrf secret, ktory zostaje z poprzedniej konfiguracji
        $configuration = ProjectConfiguration::getApplicationConfiguration(self::$prev_application, self::$prev_env, self::$is_debug);
        sfContext::createInstance($configuration, sprintf('%s_%s', self::$prev_application, self::$prev_env));
        //przelaczenie na instancje domyslna, po wczesniejszym przejsciu na system
        if(sfContext::hasInstance(self::$prev_application)) {
            sfContext::switchTo(self::$prev_application);
            //ustawiam wszystkie wpisy w sfConfig, ktore wcielo po przelaczeniu context

            //bylo kiedys ale wali warningami
            //$sf_config_diff = array_diff(self::$prev_sfconfig, sfConfig::getAll());

            //obecna wersja
            $sf_config_diff = array_diff_key((array)self::$prev_sfconfig, (array)sfConfig::getAll());
            sfConfig::add($sf_config_diff);
        }
    }
}
?>
