import json
from flask import Flask, Response, render_template, request, jsonify
from flask_cors import CORS, cross_origin
from bs4 import BeautifulSoup
import requests
app = Flask(__name__)
cors = CORS(app)
app.config['CORS_HEADERS'] = 'Content-Type'
#with open('../classified.json', encoding="utf8") as f_in:
#   data = json.load(f_in)
print("Jsonlar açılıyor...");
with open('./herkelime.json', encoding="utf8") as f_in:
   herkelime = json.load(f_in)
   herkelime_json = json.loads(herkelime)

kelime_data = json.load(open('./kelimeler.json'))
kelime_data_json =json.dumps(kelime_data)
kelime_data_dict=json.loads(kelime_data_json) 


@app.route('/')
def index():
    return 'DevAkademi!'
                       
@app.route('/autocomplete', methods=['GET'])
@cross_origin()
def autocomplete():
    search = request.args.get('word')
    if len(search) < 3:
       return 'Min. 3 Karakter Giriniz!'
    results = [i for i in herkelime_json if i.startswith(search)]
    return jsonify(matching_results=results)
    
@app.route('/search', methods=['GET'])
@cross_origin()
def search():
    search = request.args.get('word')
    word = kelime_data_dict.get(search);
    if word == None:
       return 'Kelime hiç kullanılmamış!'
    return jsonify(matching_results=word)

@app.route('/detectWords', methods=['GET'])
@cross_origin()
def detectWords():
    content = request.args.get('content') #1: en çok kullanılan, 2: en sıkıntılı
    ratio = 15 # Güvenilebilecek rakamlara ulaşıncaya kadar belirsiz.
    if content == None:
       return ''
    else:
       lastHtml = "";
       words = content.split();
       for i, val in enumerate(words): 
          #burada val'a bakilip html koduna eklensin.
          word_uses = kelime_data_dict.get(val);
          word_ratio = word_uses[1]/word_uses[0]; #approve rate
          if (word_ratio < 0.7 and word_ratio > 0.5) or word_uses[0] <= ratio:
             lastHtml+="<span style='color:orange'>"+val+"</span> ";
          elif word_ratio >= 0.7 :
             lastHtml+="<span style='color:green'>"+val+"</span> ";
          else:
             lastHtml+="<span style='color:red'>"+val+"</span> ";
             
       return lastHtml; #html code
app.run(host='0.0.0.0', port=5000)