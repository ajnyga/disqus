<?php

/**
 * @file plugins/generic/disqus/DisqusSettingsForm.inc.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class disqusSettingsForm
 * @ingroup plugins_generic_disqus
 *
 * @brief Form for journal managers to modify disqus plugin settings
 */

import('lib.pkp.classes.form.Form');

class DisqusSettingsForm extends Form {

	/** @var int */
	var $_journalId;

	/** @var object */
	var $_plugin;

	/**
	 * Constructor
	 * @param $plugin DisqusPlugin
	 * @param $journalId int
	 */
	function __construct($plugin, $journalId) {
		$this->_journalId = $journalId;
		$this->_plugin = $plugin;

		parent::__construct($plugin->getTemplatePath() . 'settingsForm.tpl');

		$this->addCheck(new FormValidator($this, 'disqusForumName', 'required', 'plugins.generic.disqus.manager.settings.disqusForumNameRequired'));

		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidatorCSRF($this));
	}

	/**
	 * Initialize form data.
	 */
	function initData() {
		$this->_data = array(
			'disqusForumName' => $this->_plugin->getSetting($this->_journalId, 'disqusForumName'),
		);
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array('disqusForumName'));
	}

	/**
	 * Fetch the form.
	 * @copydoc Form::fetch()
	 */
	function fetch($request) {
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->_plugin->getName());
		return parent::fetch($request);
	}

	/**
	 * Save settings.
	 */
	function execute() {
		$this->_plugin->updateSetting($this->_journalId, 'disqusForumName', trim($this->getData('disqusForumName'), "\"\';"), 'string');
	}
}

?>
