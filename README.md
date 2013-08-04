web_jukebox
===========
project for my wedding so I don't have to hire a DJ if someone else finds it useful that would be cool. Currently this is not in a usable state


Dependencies
===========
* Zend Framework 1.1X (http://www.zend.com/en/company/community/downloads)

* getid3 (http://getid3.sourceforge.net/)

* mplayer cmd line with the ability to play mp3 and m4a audio


Install
===========
clone repo in to a directory that has a webserver serving it up. place the dependencies somewhere you can get to them. Change password and paths and such in the 'CONFIG.php' file. Put a folder with subfolders containing audio files where you set the 'MUSIC_DIRECTORY' const in 'CONFIG.php'. Then run the 'setup.sql' file followed by the 'scan_music_dir.php' to populate the db with data. To start the music run the 'run_player.py' and enjoy.
