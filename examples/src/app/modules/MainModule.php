<?php
namespace app\modules;

use std, gui, framework, app;


class MainModule extends AbstractModule
{

    /**
     * @var string
     */
    const LANGS_SECTION = 'Langs',
          MAIN_SECTION  = 'Main';
    
    /**
     * @var IniStorage
     */
    public $ini;

    function __construct()
    {
        $this->ini = new IniStorage();
        $this->ini->path = 'Config';
    }
    
    function setLanguage($code, $name)
    {
        $name = ucfirst(trim($name));
        $this->ini->set(trim($code), $name, self::LANGS_SECTION);
    }
    
    function getDefaultLanguage()
    {
        return $this->getConfigValue('lang', self::MAIN_SECTION);
    }
    
    function setDefaultLanguage($code)
    {
        return $this->ini->set('lang', $code, self::MAIN_SECTION);
    }
    
    function getLanguage($code)
    {
        return $this->getConfigValue($code, self::LANGS_SECTION);
    }

    function getLanguages()
    {
        //or fs::scan
        $this->ini->load();
        return $this->ini->section(self::LANGS_SECTION);
    }
    
    function deleteLanguage($code)
    {
        $this->ini->remove($code, self::LANGS_SECTION);
    }
    
    function getConfigValue($key, $section = '')
    {
        $this->ini->load();
        return $this->ini->get($key, $section);
    }

    /**
     * @param UXForm $form
     */
    function showForm($form)
    {
        
    }

}