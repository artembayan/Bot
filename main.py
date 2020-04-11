from vk_api.longpoll import VkLongPoll, VkEventType
import vk_api
from vk_api.keyboard import VkKeyboard, VkKeyboardColor
import connectDB


token = "95f107cd1d9d0652e224c8a1ba1da2c027eba29920b294d919df2787676963e63439ad9b2b6fc584896ff"
vk_session = vk_api.VkApi(token=token)
session_api = vk_session.get_api()
longpoll = VkLongPoll(vk_session)


def create_keyboard(response):
    keyboard = VkKeyboard(one_time=False)

    keyboard.add_button('Продукция', color=VkKeyboardColor.DEFAULT)
    keyboard.add_button('Прайс-лист', color=VkKeyboardColor.DEFAULT)

    keyboard.add_line()  # Переход на вторую строку
    keyboard.add_button('Курсы', color=VkKeyboardColor.DEFAULT)
    keyboard.add_button('Контакты', color=VkKeyboardColor.DEFAULT)

    keyboard.add_line()
    keyboard.add_button('Режим работы', color=VkKeyboardColor.DEFAULT)
    keyboard.add_button('Реквизиты', color=VkKeyboardColor.DEFAULT)

    keyboard.add_line()
    keyboard.add_button('Отслеживание заказа', color=VkKeyboardColor.POSITIVE)
    #keyboard.add_button('В начало', color=VkKeyboardColor.POSITIVE)

    keyboard = keyboard.get_keyboard()
    return keyboard


for event in longpoll.listen():
    if event.type == VkEventType.MESSAGE_NEW and not event.from_me:
        response = event.text.lower()
        keyboard = create_keyboard(response)
        print('Текст сообщения: ' + str(response))
        if response == 'начать' or response == 'привет' or response == 'start' or response == '/start':
            session_api.messages.send(user_id=event.user_id, message='Привет! Я бот-помощник ЦМИТ "ЛЮКС". '
                                                                     'Чем могу помочь? \n 1. Продукция ЦМИТ\n '
                                                                     '2. Прайс-лист\n 3. Расписание и стоимость курсов ЦМИТ\n'
                                                                     ' 4. Режим работы\n 5. Контакты сотрудников\n '
                                                                     '6. Реквизиты ЦМИТ\n 7. Отслеживание заказа \n '
                                                                     , keyboard=keyboard, random_id=0)

        elif response == "продукция цмит" or response==str('1'):
            with connectDB.connect.cursor() as cursor:
                cursor.execute("""select Name, Price from Products;""")
                showinfo = ''
                for row in cursor:
                    info = '🔹' + row['Name'] + ' — ' + str(row['Price']) + " руб."
                    showinfo = showinfo + info + '\n'
                session_api.messages.send(user_id=event.user_id, message="Продукция ЦМИТ:\n" + '\n' +showinfo, keyboard=keyboard, random_id=0)
            cursor.close()

        elif response == "прайс-лист" or response==str('2'):
            with connectDB.connect.cursor() as cursor:
                cursor.execute("""select service_name, service_price from services;""")
                showinfo = ''
                for row in cursor:
                    info = '🔹' + row['service_name'] + ' — ' + str(row['service_price']) + " руб."
                    showinfo = showinfo + info + '\n'
            session_api.messages.send(user_id=event.user_id, message='Прайс-лист:\n' + '\n' +showinfo, keyboard=keyboard, random_id=0)

        elif response == "курсы цмит" or response==str('3'):
            with connectDB.connect.cursor() as cursor:
                cursor.execute("""SELECT name, price, FIO, schedule FROM staff RIGHT JOIN courses ON staff.staff_ID=courses.teacher;""")
                rows=cursor.fetchall()
                showinfo = ''
                for row in rows:
                    info = ('📚 Название курса: ' + row['name'] + '\n💳 Стоимость: ' + str(row['price']) + " руб."
                            + "\n👨‍🏫Преподаватель: " + str(row['FIO']) + '\n⌚Расписание: '  + str(row['schedule']))
                    showinfo = showinfo + info + '\n' + '\n'
            session_api.messages.send(user_id=event.user_id, message='Расписание и стоимость курсов ЦМИТ:\n' + '\n' +showinfo,
                                      keyboard=keyboard, random_id=0)

        elif response == "режим работы цмит" or response==str('4'):
            with connectDB.connect.cursor() as cursor:
                cursor.execute("""SELECT hours FROM working_hours;""")
                info=cursor.fetchone()
            session_api.messages.send(user_id=event.user_id, message='Режим работы ЦМИТ:\n' + '\n' +str(info['hours']), keyboard=keyboard,
                                      random_id=0)

        elif response == "контакты" or response==str('5'):
            with connectDB.connect.cursor() as cursor:
                cursor.execute("""SELECT FIO, post, email, phone  FROM staff;""")
                rows=cursor.fetchall()
                showinfo = ''
                for row in rows:
                    info = ('👨‍🏫 Преподаватель: ' + row['FIO'] + '\n💼 Должность: ' + str(row['post']) + "\n📬 E-mail: " + str(row['email'])
                    + '\n📱 Телефон: ' + str(row['phone']))
                    showinfo = showinfo + info + '\n' + '\n'
            session_api.messages.send(user_id=event.user_id, message='Контакты сотрудников:\n' + '\n' +showinfo, keyboard=keyboard,
                                      random_id=0)

        elif response == "реквизиты цмит" or response==str('6'):
            with connectDB.connect.cursor() as cursor:
                cursor.execute("""SELECT requisites FROM requisites;""")
                info=cursor.fetchone()
            session_api.messages.send(user_id=event.user_id, message='Реквизиты ЦМИТ:\n' + '\n' +str(info['requisites']), keyboard=keyboard, random_id=0)

        elif response == "отслеживание заказа" or response==str('7'):
            session_api.messages.send(user_id=event.user_id, message='Введите номер заказа:', keyboard=keyboard,
                                      random_id=0)
            for event in longpoll.listen():
                   if event.type == VkEventType.MESSAGE_NEW and not event.from_me:
                        order = event.text.lower()
                        with connectDB.connect.cursor() as cursor:
                            a = cursor.execute("""SELECT service_name, FIO, status, ready_date FROM services join tracking 
                            ON services.service_ID = tracking.service join staff ON staff.staff_ID = tracking.employee WHERE order_ID = %s""", order)
                            rows = cursor.fetchall()
                            if a == 0:
                                session_api.messages.send(user_id=event.user_id, message='Заказа с таким номером не существует :(', keyboard=keyboard, random_id=0)
                            showinfo = ''
                            for row in rows:
                                info = ('📝 Заказ: ' + str(row['service_name']) + "\n👨‍💻 Исполнитель: " + str(row['FIO'])
                                        + '\n🔎 Статус: ' + str(row['status']) + '\n📅 Дата готовности: ' + str(row['ready_date']))
                                showinfo = showinfo + info + '\n'
                                session_api.messages.send(user_id=event.user_id, message=str(showinfo), keyboard=keyboard,
                                              random_id=0)
                        if(order != ''):
                            break
        else:
            session_api.messages.send(user_id=event.user_id, message='Я вас не понимаю!', keyboard=keyboard, random_id=0)