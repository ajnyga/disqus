{**
 * plugins/generic/disqus/templates/forum.tpl
 *
 * Copyright (c) 2014-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * A template to be included under the abstract.
 *}
<div id="disqus_thread"></div>
<script>

var disqus_config = function () {ldelim}
	this.page.url = '{$submissionUrl|escape}';
	this.page.identifier = '{$submissionId|escape}';
{rdelim};

(function() {ldelim}
	var d = document, s = d.createElement('script');
	s.src = '//{$disqusForumName|escape}.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
{rdelim})();

</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>