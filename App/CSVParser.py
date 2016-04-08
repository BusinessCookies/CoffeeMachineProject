import os

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
  
#f = open('admin.csv', "rb")
#csvstring = f.read()
#print repr(csvstring)
#f.close() 
  
# Parse a file
#print GetCSVFromFile('admin.csv')

# Set a file 
#tab = GetCSVFromFile('admin.csv')
#SetCSVToFile('admin.csv', tab)

# Append to a file
#tab = GetCSVFromFile('admin.csv')
#AppendCSVToFile('date.csv', tab)

# To modify a line (for example for admin file update)
#tab = GetCSVFromFile('admin.csv')
#for i, line in enumerate(tab):
  #if(user[0] == line[0]):
    #tab[i] = user
#SetCSVToFile('admin.csv', tab)
