<?php
namespace app\forms;

use localization;
use std, gui, framework, app;


class MainForm extends AbstractForm
{

    /**
     * @var Localization
     */
    public $lang;
    
    public $_menu;

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {
        $this->createMenu();
    }


    /**
     * @event button3.action 
     */
    function doButton3Action(UXEvent $e = null)
    {    
        $this->form('SettingsForm')->show();
    }
    
    function reload()
    {
        $lang = $this->getDefaultLanguage();
        $this->label->text     = __('app.name', $lang);
        $this->labelAlt->text  = __('app.desc', $lang);
        $this->label3->text    = __('app.info', $lang);
        $this->label4->text    = sprintf(__('mainform.login', $lang), __('app.name', $lang));
        $this->label5->text    = __('mainform.login.desc', $lang);
        $this->label8->text    = __('mainform.login.email', $lang);
        $this->label7->text    = __('mainform.login.password', $lang);
        $this->checkbox->text  = __('mainform.login.remember', $lang);
        $this->link->text      = __('mainform.login.forgotPassword', $lang);
        $this->buttonAlt->text = __('mainform.login.signIn', $lang);
        $this->button3->text   = __('mainform.localization.add', $lang);
    }

    function createMenu()
    {
        if (is_object($this->_menu))
            $this->_menu->free();

        $this->reload();
        $this->_menu = $menuBar = new UXMenuBar(); 
        $menuBar->width = $this->width;
        $menuBar->style = '-fx-background-color: #4d4d4d;';
        $this->add($menuBar);
        
        $lang     = new Localization($this->getDefaultLanguage());
        $file     = new UXMenu($lang->get('mainform.menu.file._name'));
        $options  = new UXMenu($lang->get('mainform.menu.options._name'));
        
        //items
        $newFileItem     = new UXMenuItem($lang->get('mainform.menu.file.newFile'));
        $openFileItem    = new UXMenuItem($lang->get('mainform.menu.file.openFile'));
        $openFolderItem  = new UXMenuItem($lang->get('mainform.menu.file.openFolder'));
        $separator1      = UXMenuItem::createSeparator();
        $saveItem        = new UXMenuItem($lang->get('mainform.menu.file.save'));
        $saveAsItem      = new UXMenuItem($lang->get('mainform.menu.file.saveAs'));
        $saveAllItem     = new UXMenuItem($lang->get('mainform.menu.file.saveAll'));
        $separator2      = UXMenuItem::createSeparator();
        $exitItem        = new UXMenuItem($lang->get('mainform.menu.file.exit'));

        $file->items->addAll([$newFileItem, $openFileItem, $openFolderItem,
                              $separator1, $saveItem, $saveAsItem,
                              $saveAllItem, $separator2, $exitItem]);

        $settings = new UXMenuItem($lang->get('mainform.menu.options.settings'));
        $settings->on('action', function ()
        {
            $this->form('SettingsForm')->show();
        });

        $options->items->add($settings);
        $menuBar->menus->addAll([$file, $options]);
    }




}
