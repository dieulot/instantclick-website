

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-46962315-1', 'instantclick.io');

InstantClick.on('change', function() {
	ga('send', 'pageview', location.pathname + location.search);
	var emails = document.querySelectorAll('a[data-no-instant=email]')
	for (var i = 0; i < emails.length; i++) {
		emails[i].href = 'mailto:' + ['adieulot', 'gmail.com'].join('@')
	}
})

InstantClick.init()
