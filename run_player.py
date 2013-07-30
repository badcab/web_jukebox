#!/usr/bin/python
# -*- coding: utf-8 -*-

import MySQLdb as mdb
import sys
import subprocess
import time
#here I should randomly select a song and put it in a que 2 times
#here I should call the generate vote stack stored procedure 5 times

def shellquote(s):
    return "'" + s.replace("'", "'\\''") + "'"

while True: #I will want to be able to interupt this proccess so the mc can do maual stuff
	try:
		con = mdb.connect('localhost', 'root', 'blizzard', 'web_jukebox')
		cur = con.cursor()
		cur.execute("SELECT `queue`.`id`, `songs`.`file_path` FROM `queue` JOIN `songs` ON `songs`.`id`=`queue`.`song_id`ORDER BY `time` ASC LIMIT 1")
		query = cur.fetchone()#need to get the full path and file name of the music
		queue_id = query[0]
		audio_file = query[1]
		sql_delete = "DELETE FROM `web_jukebox`.`queue` WHERE `queue`.`id` = " + str(queue_id)
		cur.execute(sql_delete)
		con.commit()
	except mdb.Error, e:
		print "Error %d: %s" % (e.args[0],e.args[1])
	finally:
		if con:
			con.close()
		if audio_file:
			subprocess.call("mplayer " + shellquote(audio_file), shell=True)
			audio_file = False
		print("************-end of loop iteration-************")
		time.sleep(1) # prevents a ton of error messages being output
#end while loop