<?php
class BookItOpenScheduleCreateItemProcessor extends modObjectCreateProcessor {
	public $classKey = 'OpenScheduleList';
	public $languageTopics = array('bookit:default');
	public $objectType = 'bookit';

	public function beforeSave() {
		$name = $this->getProperty('name');

		if (empty($name)) {
			$this->addFieldError('name',$this->modx->lexicon('bookit.error_no_item_name'));
		} else if ($this->doesAlreadyExist(array('name' => $name))) {
			$this->addFieldError('name',$this->modx->lexicon('bookit.error_name_exists'));
		}
		return parent::beforeSave();
	}
}
return 'BookItOpenScheduleCreateItemProcessor';