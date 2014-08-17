phpBotNet
=========

A PHP Botnet proof of concept. Web servers communicating in a centralized Command &amp; Control environment.

This is a proof of concept I wrote for a class project. I was supposed to write a simple PHP webserver. 
This was easily accomplished so I decided to write a proof of concept Botnet Command And Control. The simpleWebServ.php file
serves as the C&C webserver, with the laravel_bot.php files being the bots on infected machines. The bots would call home once
intialized and the C&C would request the bots send data about their environment (hardware, mac adress, etc.). This allows a 
unique fingerprint for each bot to be stored and authenticated. This functionality isnt complete yet.

The project is still in development. Still need much work.

Environment:
C&C: Ubuntu Server 64bit 14.04, PHP5 (curl, cli, cgi)
Bot: Ubuntu Server 64bit 14.04, PHP5 (curl, cli, cgi)
