import os


###### This file define the CSV parser we use ############################

def GetCSVFromFile(path):
  f = open(path, "rb")
  csvstring = f.read()
  f.close()
  csvtab = Parse(csvstring)
  return csvtab
  
def SetCSVToFile(path, csvtab):
  csvstring = Unparse(csvtab)
  os.remove(path)
  f = open(path, "wb")
  f.write(csvstring)
  f.close()
  
def AppendCSVToFile(path, csvtab):
  file_csvtab = GetCSVFromFile(path)
  new_csvtab = file_csvtab + csvtab 
  csvstring = Unparse(new_csvtab)
  os.remove(path)
  f = open(path, "wb")
  f.write(csvstring)
  f.close()

def Parse(string):
  string.replace('\r', '')
  string = string.strip()
  tab = string.splitlines()
  if(len(tab) != 0):
    for i, line in enumerate(tab):
      tab[i] = line.split(';')
  else:
    tab = []
  return tab  
  
def Unparse(tab):
  string = ''
  for line in tab:
    stringline = ''
    first = True
    for word in line:
      if(first):
        first = False
      else:
        stringline += ';'
      stringline += word
    string += stringline
    string += '\n'
  return string.strip()
  
