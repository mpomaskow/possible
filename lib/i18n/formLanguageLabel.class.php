<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formLanguageLabel
 *
 * @author cyran
 */
class formLanguageLabel {
    static public function getLanguageList() {
        $culture = sfContext::getInstance()->getUser()->getCulture();
        $culture_info = sfCultureInfo::getInstance($culture === null ? sfContext::getInstance()->getUser()->getCulture() : $culture);
        $languages_list = $culture_info->getLanguages();

        return $languages_list;
    }

    static public function setLanguageLabel(sfWidgetFormSchema $widgetSchema) {
        $language_list = self::getLanguageList();
        foreach(sfConfig::get('app_languages') as $short_name) {
            if(in_array($short_name, sfConfig::get('app_languages'))) {
                $widgetSchema->setLabel($short_name, ucfirst($language_list[$short_name]));
            }
        }
    }
}
?>
