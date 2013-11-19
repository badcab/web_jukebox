#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb as mdb
import sys
import subprocess
import time

#Make sure you have run the 'scan_music_dir.php' script before running this

db_host = 'localhost'
db_user = 'root'
db_name = 'web_jukebox'
db_password = 'blizzard'

def shellquote(s):
    return "'" + s.replace("'", "'\\''") + "'"

while True: #I will want to be able to interupt this proccess so the mc can do maual stuff
	try:
		con = mdb.connect(db_host, db_user ,db_password , db_name)
		cur = con.cursor()
		cur.execute("SELECT `queue`.`id`, `songs`.`file_path` FROM `queue` JOIN `songs` ON `songs`.`id`=`queue`.`song_id`ORDER BY `time` ASC LIMIT 1")
		query = cur.fetchone()
		queue_id = query[0]
		audio_file = query[1]
		sql_delete = "DELETE FROM `queue` WHERE `queue`.`id` = " + str(queue_id)
		cur.execute(sql_delete)
		cur.execute("CALL web_jukebox.ADD_TO_QUEUE()")
		con.commit()
	except mdb.Error, e:
		print "Error %d: %s" % (e.args[0],e.args[1])
	finally:
		if con:
			con.close()
		if audio_file:
			subprocess.call("omxplayer " + shellquote(audio_file), shell=True)
			#may want to switch to mplayer if on a different distro
			audio_file = False
		print("************-end of loop iteration-************")
		time.sleep(1) # prevents a ton of error messages being output
#end while loop
