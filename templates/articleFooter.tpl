{**
 * plugins/generic/disqus/templates/articleFooter.tpl
 *
 * Copyright (c) 2014-2017 Simon Fraser University
 * Copyright (c) 2003-2017 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * A template to be included via Templates::Article::Footer::PageFooter hook.
 * https://help.disqus.com/customer/portal/articles/472097-universal-embed-code
 *}
<div id="disqus_thread"></div>
<script>

/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
/*
var disqus_config = function () {ldelim}
this.page.url = {$articleUrl};
this.page.identifier = {$articleId}; 
{rdelim};
*/
(function() {ldelim} // DON'T EDIT BELOW THIS LINE
	var d = document, s = d.createElement('script');
	s.src = '//{$disqusForumName}.disqus.com/embed.js';
	s.setAttribute('data-timestamp', +new Date());
	(d.head || d.body).appendChild(s);
{rdelim})();

</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>