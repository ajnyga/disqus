<?php

/**
 * @defgroup plugins_generic_disqus disqus Plugin
 */
 
/**
 * @file plugins/generic/disqus/index.php
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_disqus
 * @brief Wrapper for disqus plugin.
 *
 */

require_once('DisqusPlugin.inc.php');

return new DisqusPlugin();

?>
