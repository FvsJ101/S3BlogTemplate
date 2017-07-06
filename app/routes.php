<?php

//INDEX HOME
$app->get('/','HomeController:index')->setName('home');

//CONTACT
$app->get('/contact','ContactController:getContact')->setName('contact');
$app->post('/contact','ContactController:postContact');

//BLOG
$app->get('/blog','BlogController:viewBlog')->setName('blog');
$app->post('/blog','BlogController:postBlog');