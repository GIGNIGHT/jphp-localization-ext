<?php
namespace app\forms;

use std, gui, framework, app, localization;


class SettingsForm extends AbstractForm
{

    private $_index = 0;
    
    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {
        $this->listView->items->clear();
        $this->setCellFactory();
        $this->_index = 0;
        
        foreach ($this->getLanguages() as $code => $lang)
        {
            $this->listView->items->add([$this->view($lang, $code), $code, $this->_index]);
            if ($code == $this->getDefaultLanguage())
                $this->listView->selectedIndex = $this->_index;
                
            $this->_index++;
        }
    }
    
    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {
        $lang = trim($this->lang->text);
        $code = trim($this->code->text);

        $this->setLanguage($code, $lang);
        new Localization(new LocalizationFile("lang/{$code}"));

        $this->listView->items->add([$this->view($lang, $code), $code, $this->_index]);
    }
    
    function reload()
    {
        $lang = $this->getDefaultLanguage();
        $this->lang->promptText = __('settings.edit.lang', $lang);
        $this->code->promptText = __('settings.edit.code', $lang);
        $this->button->text     = __('settings.button.add', $lang);
    }
    
    function setCellFactory()
    {
        $this->listView->setCellFactory(function (UXListCell $cell, $items)
        {
            if ($items)
            {
                $name = new UXLabel($items[0]);
                $name->width = 130;
                $name->classesString = 'label dark';
                if (fs::exists($icon = "src/.data/img/icons/{$items[1]}.png"))
                    $name->graphic = new UXImageView(new UXImage($icon));

                $edit = new UXButton(null, new UXImageView(new UXImage('res://.data/img/icons/edit.png')));
                $edit->on('click', function () use ($items)
                {
                    $form = $this->form('EditForm');
                    $form->loadLocalization($items[1]);
                    $form->show();
                    $this->hide();
                });
                
                $delete = new UXButton(null, new UXImageView(new UXImage('res://.data/img/icons/delete.png')));
                $delete->on('click', function () use ($items)
                {
                    $file = new LocalizationFile("lang/{$items[1]}");
                    $file->delete();
                    $this->deleteLanguage($items[1]);
                    $this->listView->items->removeByIndex($items[2]);
                });
                
                $buttonBox = new UXHBox([$edit, $delete]);
                $buttonBox->alignment = 'CENTER';
                $buttonBox->spacing = 5;
                
                $box = new UXHBox([$name, $buttonBox]);
                $box->alignment = 'CENTER_LEFT';
                $box->spacing = 125;
                $box->paddingLeft = 5;
                $box->on('click', function () use ($items)
                {
                    try
                    {
                        $this->setDefaultLanguage($items[1]);
                        $this->reload();
                        $this->form('MainForm')->createMenu();
                        $this->toast("Язык \"{$items[0]}\" выбран по умолчанию");
                    }
                    catch (LocalizationException $e)
                    {
                        // if ($e->getCode() == )
                        $this->toast("Не удалось выбрать язык \"{$items[0]}\" по умолчанию, возможно требуется заполнить");
                    }
                });
                
                $cell->text = null;
                $cell->graphic = $box;
            }
        });
    }
    
    function view($lang, $code)
    {
        return ucfirst($lang).' ('.strtoupper($code).')';
    }

}
