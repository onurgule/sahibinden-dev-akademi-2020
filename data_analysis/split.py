from datetime import datetime
import json

print(datetime.now()) #başlangıç

f = open('classified.json', 'r', encoding="utf8")
ilanlar = json.load(f)
kelimeler = dict()
ilan_kelime = dict()
herKelime = []
duplicated = 0
#'asWsd':{5,1,4} all-app-rej
for i in ilanlar:
   for t in i['title'].split(' '):
       herKelime.append(t);
   if t in kelimeler:
      newKelime = kelimeler.get(t);
      newKelime[0]+=1;
      if i['status'] != 'REJECTED':
         newKelime[1]+=1;
      else:
         newKelime[2]+=1;
      kelimeler.update({t:newKelime})
   else:
      kelimeler[t] = [1,(1 if i['status']!='REJECTED' else 0),(1 if i['status']=='REJECTED' else 0)]
   if t in ilan_kelime:
      newIlan = ilan_kelime.get(t);
      newIlan.append(i['id'])
      ilan_kelime.update({t:newIlan})
   else:
      ilan_kelime[t] = [i['id']]      

   for t in i['description'].split(' '):
         herKelime.append(t);
   if t in kelimeler:
      newKelime = kelimeler.get(t);
      newKelime[0]+=1;
      if i['status'] != 'REJECTED':
         newKelime[1]+=1;
      else:
         newKelime[2]+=1;
      kelimeler.update({t:newKelime})
   else:
      kelimeler[t] = [1,(1 if i['status']!='REJECTED' else 0),(1 if i['status']=='REJECTED' else 0)]
   if t in ilan_kelime:
      newIlan = ilan_kelime.get(t);
      newIlan.append(i['id'])
      ilan_kelime.update({t:newIlan})
   else:
      ilan_kelime[t] = [i['id']] 
f.close()
with open('kelimeler.json', 'w') as fp:
    json.dump(kelimeler, fp)
with open('ilan_kelime.json', 'w') as fp:
    json.dump(ilan_kelime, fp)
woDups = list(dict.fromkeys(herKelime))
with open('herkelime.json', 'w') as fp:
    json.dump((woDups), fp)
print(datetime.now())#bitiş