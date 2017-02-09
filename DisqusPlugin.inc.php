<?php

/**
 * @file plugins/generic/disqus/DisqusPlugin.inc.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class disqus
 * @ingroup plugins_generic_disqus
 *
 * @brief disqus plugin class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class DisqusPlugin extends GenericPlugin {
	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path) {
		$success = parent::register($category, $path);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			
			// Insert Disqus div
			HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'addDisqus'));
		
		}
		return $success;
	}

	/**
	 * Get the plugin display name.
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.disqus.displayName');
	}

	/**
	 * Get the plugin description.
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.disqus.description');
	}

	/**
	 * @copydoc Plugin::getActions()
	 */
	function getActions($request, $verb) {
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		return array_merge(
			$this->getEnabled()?array(
				new LinkAction(
					'settings',
					new AjaxModal(
						$router->url($request, null, null, 'manage', null, array('verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic')),
						$this->getDisplayName()
					),
					__('manager.plugins.settings'),
					null
				),
			):array(),
			parent::getActions($request, $verb)
		);
	}

 	/**
	 * @copydoc Plugin::manage()
	 */
	function manage($args, $request) {
		switch ($request->getUserVar('verb')) {
			case 'settings':
				$context = $request->getContext();

				AppLocale::requireComponents(LOCALE_COMPONENT_APP_COMMON,  LOCALE_COMPONENT_PKP_MANAGER);
				$templateMgr = TemplateManager::getManager($request);
				$templateMgr->register_function('plugin_url', array($this, 'smartyPluginUrl'));

				$this->import('DisqusSettingsForm');
				$form = new DisqusSettingsForm($this, $context->getId());

				if ($request->getUserVar('save')) {
					$form->readInputData();
					if ($form->validate()) {
						$form->execute();
						return new JSONMessage(true);
					}
				} else {
					$form->initData();
				}
				return new JSONMessage(true, $form->fetch($request));
		}
		return parent::manage($args, $request);
	}

	/**
	 * @copydoc PKPPlugin::getTemplatePath
	 */
	function getTemplatePath($inCore = false) {
		return parent::getTemplatePath($inCore) . 'templates/';
	}

	/**
	 * Add the Disqus forum div
	 * @param $hookName string
	 * @param $params array
	 */
	function addDisqus($hookName, $params) {
		$request = $this->getRequest();
		$context = $request->getContext();
		$disqusForumName = $this->getSetting($context->getId(), 'disqusForumName');

		if (empty($disqusForumName)) return false;
				
		$smarty =& $params[1];
		$output =& $params[2];
		
		$article = $smarty->get_template_vars('article');
		$articleUrl = $request->url($context->getPath(), 'article', 'view', $article->getBestArticleId());

		$smarty->assign('disqusForumName', $disqusForumName);
		$smarty->assign('articleId', $article->getBestArticleId());
		$smarty->assign('articleUrl', $articleUrl);
		
		$output .= $smarty->fetch($this->getTemplatePath() . 'articleFooter.tpl');
		return false;		
		
	}
}

?>
