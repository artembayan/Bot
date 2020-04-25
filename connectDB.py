import pymysql.cursors

connection = pymysql.connect(host='localhost',
                             user='root',
                             password='root')

connect = pymysql.connect(host='localhost',
                          user='root',
                          password='root',
                          db='cmit',
                          charset='utf8mb4',
                          cursorclass=pymysql.cursors.DictCursor
                          )

