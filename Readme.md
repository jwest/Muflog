Muflog
======
Your static blog based on markup files
------

Master: [![Build Status](https://travis-ci.org/jwest/Muflog.png?branch=master)](https://travis-ci.org/jwest/Muflog) [![Dependencies](http://dependency.me/repository/image/jwest/Muflog/master)](http://dependency.me/repository/branche/jwest/Muflog/master)

Create your blog in markdown files, and start build after changes. All pages will build without php code. Front your blog without logic.

If you have comments system you must use disqus or facebook.

Installation
------

Get application from repository (or composer)

	git clone http://github.com/jwest/Muflog
	cd Muflog

Change config.ini file, mainly:

 * absoluteUrl
 * repositories > post, repositories > page
 * used modules

Upload articles to the repository (see post [examples][postExample])

Development
-----------

Get application from repository and run tests

	git clone http://github.com/jwest/Muflog
	cd Muflog
	phpunit

 [postExample]: https://github.com/jwest/Muflog/blob/master/tests/fixtures/repository/posts/test_post.md