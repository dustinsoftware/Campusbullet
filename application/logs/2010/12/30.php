<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-12-30 09:51:47 --- ERROR: ErrorException [ 8 ]: Undefined variable: content ~ APPPATH\views\template.php [ 66 ]
2010-12-30 09:58:24 --- ERROR: ErrorException [ 8 ]: Undefined variable: pagination ~ APPPATH\classes\controller\home.php [ 55 ]
2010-12-30 10:06:47 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'category' in 'where clause' [ select count(id) as count from posts where disabled=0 and category='books' ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 179 ]
2010-12-30 10:09:17 --- ERROR: ErrorException [ 8 ]: Undefined variable: category ~ APPPATH\classes\controller\home.php [ 68 ]
2010-12-30 10:15:28 --- ERROR: ErrorException [ 8 ]: Undefined variable: category_prettyname ~ APPPATH\views\home_category_view.php [ 1 ]
2010-12-30 10:16:03 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'prettyname' in 'field list' [ SELECT `name`, `prettyname` FROM `categories` WHERE `name` = 'books' ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 179 ]
2010-12-30 10:18:01 --- ERROR: ErrorException [ 8 ]: Undefined variable: category_prettyname ~ APPPATH\views\home_category_view.php [ 1 ]
2010-12-30 10:18:09 --- ERROR: ErrorException [ 8 ]: Undefined variable: url_base ~ APPPATH\views\home_category_view.php [ 26 ]
2010-12-30 10:22:07 --- ERROR: ReflectionException [ -1 ]: Class controller_category does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 10:22:32 --- ERROR: ReflectionException [ -1 ]: Class controller_category does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 12:16:45 --- ERROR: ErrorException [ 8 ]: Undefined variable: categories ~ APPPATH\views\home.php [ 3 ]
2010-12-30 12:22:50 --- ERROR: ErrorException [ 8 ]: Undefined variable: categories ~ APPPATH\views\home.php [ 3 ]
2010-12-30 12:34:14 --- ERROR: ErrorException [ 8 ]: Undefined variable: categories ~ APPPATH\views\home.php [ 3 ]
2010-12-30 12:34:28 --- ERROR: ErrorException [ 8 ]: Undefined variable: url_base ~ APPPATH\views\home.php [ 4 ]
2010-12-30 12:36:08 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'sort_order' in 'order clause' [ SELECT `name`, `prettyname`, `image` FROM `categories` WHERE `disabled` = '0' ORDER BY `sort_order` ASC ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 179 ]
2010-12-30 12:46:26 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/videogames.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:46:27 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/shelves.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:46:27 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/electronics.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:46:27 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/applicances.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:46:28 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/stuff.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:46:28 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/vehicles.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:52:48 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/applicances.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:52:48 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/stuff.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:53:13 --- ERROR: Kohana_Request_Exception [ 0 ]: Unable to find a route to match the URI: images/stuff.png ~ SYSPATH\classes\kohana\request.php [ 674 ]
2010-12-30 12:57:33 --- ERROR: ErrorException [ 8 ]: Undefined variable: post_category ~ APPPATH\views\account_newpost.php [ 36 ]
2010-12-30 13:51:39 --- ERROR: ReflectionException [ -1 ]: Class controller_help does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 13:51:43 --- ERROR: ReflectionException [ -1 ]: Class controller_help does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 13:52:25 --- ERROR: ReflectionException [ -1 ]: Class controller_register does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 13:57:20 --- ERROR: ReflectionException [ -1 ]: Class controller_help does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 14:03:37 --- ERROR: ErrorException [ 2 ]: Missing argument 5 for Controller_Account::previewpost(), called in C:\xampplite\htdocs\kohana\application\classes\controller\account.php on line 74 and defined ~ APPPATH\classes\controller\account.php [ 232 ]
2010-12-30 14:06:09 --- ERROR: ErrorException [ 8 ]: Undefined index: category ~ APPPATH\classes\controller\account.php [ 104 ]
2010-12-30 14:06:25 --- ERROR: ErrorException [ 8 ]: Undefined variable: post_category ~ APPPATH\views\account_newpost.php [ 36 ]
2010-12-30 14:19:37 --- ERROR: ReflectionException [ -1 ]: Class controller_home_index does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 14:58:40 --- ERROR: ErrorException [ 8 ]: Undefined variable: categories ~ APPPATH\views\account_newpost.php [ 37 ]
2010-12-30 15:01:20 --- ERROR: ErrorException [ 2048 ]: Creating default object from empty value ~ APPPATH\classes\controller\account.php [ 16 ]
2010-12-30 15:11:32 --- ERROR: ReflectionException [ -1 ]: Class controller_help does not exist ~ SYSPATH\classes\kohana\request.php [ 1094 ]
2010-12-30 15:19:17 --- ERROR: ErrorException [ 8 ]: Undefined variable: categories ~ APPPATH\views\account_newpost.php [ 37 ]
2010-12-30 15:33:04 --- ERROR: ErrorException [ 8 ]: Undefined variable: error ~ APPPATH\views\notemplate_register.php [ 15 ]
2010-12-30 16:01:16 --- ERROR: ErrorException [ 8 ]: Undefined variable: error ~ APPPATH\views\notemplate_register.php [ 15 ]