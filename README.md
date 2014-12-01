sample-MVC-with-Symfony2-components
===================================
[![Gitter](https://badges.gitter.im/Join Chat.svg)](https://gitter.im/tournasdim/sample-MVC-with-Symfony2-components?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

A sample MVC app build on top of Symfony2 and Laravel4 components (also Twig , Pure and Jquery).
This project is part of an article serie on [my Blog](http://tournasdimitrios1.wordpress.com/category/sample-mvc/) . 

### A screenshot taken on a browser

![Sample-MVC](https://dl.dropboxusercontent.com/u/8941952/GitHub-images/samplemvc.png)

### Preparing the project 
1. Open a terminal into your webroot directory and clone the project
`git clone https://github.com/tournasdim/sample-MVC-with-Symfony2-components.git`
2. cd into the downloaded project and run `composer install` 
>If Composer isn't installed on your machine already, follow [these instructions first](https://getcomposer.org/doc/00-intro.md#downloading-the-composer-executable) 
3. Change permissions on **cache** dir : `chmod -R 777 cache` 
4. Set a VirtualHost on your web-server and restart the server  
5. Set local DNS on your local machine. On my CentOs machine it's the **/etc/hosts** file
6. [Open base.layout.html](https://github.com/tournasdim/sample-MVC-with-Symfony2-components/blob/master/src/views/layouts/base.layout.html#L7) and set your project's web Url
7. Open a browser and test the project  
