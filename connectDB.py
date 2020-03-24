import pymysql.cursors

connection = pymysql.connect(host='localhost',
                             user='root',
                             password='')

connect = pymysql.connect(host='localhost',
                          user='root',
                          password='',
                          db='cmit',
                          charset='utf8mb4',
                          cursorclass=pymysql.cursors.DictCursor
                          )

# with connect.cursor() as cursor:
#     cursor.execute("""show tables""")
#     print(cursor.fetchall())
#     cursor.execute("""insert into Products (Name, Price) values('фак', 22), ("ю", 21), ("бич", 23)""")
# connect.commit()
