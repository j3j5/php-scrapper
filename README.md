PHP Scrapper
============

A simple web scrapper made in PHP for your command line.

## Installation

Clone this project somewhere into your filesystem
```
$ git clone https://github.com/j3j5/php-scrapper.git
```

Run `composer install` to install all the dependencies

You are ready to go and scrape the interwebs!

## Use

Go to the project path and run

```
$ ./run-cli scrape http://slashdot.org
```
or
```
$ ./run-cli scrape http://google.com http://bing.com http://yahoo.com
```

You should see some output similar to

```
[2015-04-19 00:02:56] general.INFO: Parsing host google.com [] []
[2015-04-19 00:02:56] general.INFO: Title of the page is: Google [] []
[2015-04-19 00:02:56] general.INFO: Parsing host bing.com [] []
[2015-04-19 00:02:56] general.INFO: Title of the page is: Bing [] []
[2015-04-19 00:02:57] general.INFO: Parsing host yahoo.com [] []
[2015-04-19 00:02:57] general.INFO: Title of the page is: Yahoo [] []
```

Good, it worked, now you're ready to add your own stuff, open the cli folder and
add any file with the name of the host you're trying to parse (see examples with last.fm and slashdot.org).

I use the great [SimpleHtmlDom package from S.C. Chen](http://simplehtmldom.sourceforge.net)
installed through this composer package [mgargano/simplehtmldom](http://github.com/mgargano/simplehtmldom).

Thanks to them, you can use jQuery style selectors to scrape the web, making it really easy.
