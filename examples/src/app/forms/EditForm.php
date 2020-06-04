<?php
namespace app\forms;

use localization;
use std, gui, framework, app;


class EditForm extends AbstractForm
{
    /**
     * @var Localization
     */
    private $lang;
    
    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {
        $line = $this->line->text;
        if ($line != null)
        {
            $this->lang->set($line, null)->save();
            $this->addRow($line);
        }
    }

    function addRow($key, $translate = '')
    {
        $text = new UXTextArea($translate);
        $text->size = [400, 80];
        $key = strtoupper(trim($key));
        $text->observer('focused')->addListener(function ($old, $focused) use ($key, $text)
        {
            if (!$focused)
            {
                try
                {
                    $isSaved = $this->lang->set($key, $text->text)->save() ? 'Сохранено' : 'Не удалось сохранить';
                    $this->toast($isSaved);
                    $this->reload();
                    $this->form('MainForm')->createMenu();
                }
                catch (LocalizationException $err) { Logger::warn($err->getMessage()); }
            }
        });
        
        $this->table->items->add(['key' => $key, 'translate' => $text]);
    }
    
    function reload()
    {
        $lang = $this->getDefaultLanguage();
        $this->button->text     = __('editForm.button.add', $lang);
        $this->line->promptText = __('editForm.edit.line', $lang);
    }

    function loadLocalization($code)
    {
        try
        {
            $this->table->items->clear();
            $this->lang  = $lang = new Localization($code);
            $this->reload();

            foreach ($lang->getAll() as $key => $translate)
                $this->addRow($key, $translate);
        }
        catch (LocalizationException $err) { Logger::warn($err->getMessage()); }
    }

}
