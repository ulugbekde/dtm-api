import telebot
from config import *
from telebot.types import *


bot = telebot.TeleBot("API_KEY",parse_mode='html')


@bot.message_handler(commands=['start','help'])
def start_message(msg):
    bot.reply_to(msg,'I raqmini kiriting: ')




@bot.message_handler(content_types=['text'])
def talaba(msg):
    text = msg.text
    if len(text)==7 and int(text)>0:
        chatid = msg.chat.id
        result  = user_search(text)
        if result==False:
            bot.reply_to(msg,'Siz xato id yubordingiz!')
        else:
            key = InlineKeyboardMarkup()
            key.add(InlineKeyboardButton(text='To\'liq malumot olish',url=result['get_info']))
            txt = f"""Ismingiz: {result['full_name']}

Ballingiz: {result['user_ball']} ball
"""
            bot.send_message(chatid,txt,reply_markup=key)

    else:
        bot.reply_to(msg,'Siz xato id yubordingiz!')










print(bot.get_me())
bot.infinity_polling()
