#coding=utf-8

import requests
import pymysql
from bs4 import BeautifulSoup as bs
# 处理非ascii编码
import sys
reload(sys)
sys.setdefaultencoding('utf-8')

#创建连接
conn = pymysql.connect(host='localhost',
                       port=3306,
                       user='sql154_8_139_13',
                       passwd='xWG4pNEeG6',
                       db='sql154_8_139_13',
                       charset='utf8')
#创建游标,游标类型为字典类型
cursor = conn.cursor(cursor=pymysql.cursors.DictCursor)
#查询数据
cursor.execute('select weather_code from ins_county')
#获取所有
result = cursor.fetchall()
#提交，保存新建或修改的数据
conn.commit()

for i in range(len(result)):
	citycode = result[i]['weather_code']
	url = "http://wthrcdn.etouch.cn/WeatherApi?citykey=" + citycode
	r = requests.get(url, verify=False)
	soup = bs(r.text, 'html.parser')
	updatetime = soup.find('updatetime').text
	wendu = soup.find('wendu').text
	fengli = soup.find('fengli').text
	fengxiang = soup.find('fengxiang').text
	shidu = soup.find('shidu').text
	if soup.find('pm25'):
		pm25 = soup.find('pm25').text
	else:
		pm25 = 'Null'
	if soup.find('quality'):
		quality = soup.find('quality').text
	else:
		quality = 'Null'
	if soup.find('high_1'):
		high = soup.find('high').text
	else:
		high = 'Null'
	if soup.find('low_1'):
		low = soup.find('low').text
	else:
		low = 'Null'
	weather_content = '更新时间:' + updatetime + '\n温度:' + wendu + '℃' + '\n风力:' + fengli + \
		'\n湿度:' + shidu + '\n风向:' + fengxiang + \
		'\nPM2.5:' + pm25 + '\n空气质量:' + quality + \
		'\n温度范围:' + low + '～' + high + ' ' 
	sql_exe = 'UPDATE ins_county SET weather_info = \''\
	          + weather_content + '\' WHERE weather_code = ' + citycode + ''
	print(sql_exe)
	cursor.execute(sql_exe)
	conn.commit()
cursor.close()
conn.close()