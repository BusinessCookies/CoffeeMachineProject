import CSVParser
import os


path = "/kivy/CoffeeMProject/PinLoginVersion/Data/DB/"
######### This file is used to modify localy the information of the different CSV files###################### 
class Users:
    def __init__(self):
        self.users=[]

    def importFromCsvFile(self):
        global path
        localpath = path +"admin.csv"
        csvfile = CSVParser.GetCSVFromFile(localpath)
        self.users = csvfile
    
    def SetUser (self, user):
        global path
        localpath = path +"admin.csv"
        tab = CSVParser.GetCSVFromFile(localpath)
        for i, line in enumerate(tab):
          if(user[0] == line[0]):
            tab[i] = user
        CSVParser.SetCSVToFile(localpath, tab)
        return

    def DelUserList(self):
        self.users=[]
        return

class Coffee:
    #contain all the informations to add to date.csv (datetime, UID, Type)

    def __init__(self, info):
        self.info=info

    def WriteInCSV(self):
        global path
        localpath = path +"date.csv"
        CSVParser.AppendCSVToFile(localpath, [self.info])
        localpath = path +"dateTemp.csv"
        CSVParser.AppendCSVToFile(localpath, [self.info])
        return 
        
    def DelLastCoffee(self):
        #print "coucou"
        self.info = []

class Grade:
    #contain all the informations to add to grade.csv (datetime, UID, Type)

    def __init__(self, UserGrade):
        self.UserGrade=UserGrade

    def WriteInCSV(self):
        global path
        localpath = path +"grade.csv"
        CSVParser.AppendCSVToFile(localpath, [self.UserGrade])


class MycoffeeList:
    def __init__(self):
        self.Mycoffee=[]

    def importFromCsvFile(self):
        global path
        localpath = path +"mycoffee.csv"
        self.Mycoffee = CSVParser.GetCSVFromFile(localpath)

    def DelMycoffeeList(self):
        self.Mycoffee=[]

    def setDefaultuser(self, user):
        global path
        localpath = path +"mycoffee.csv"
        CSVParser.AppendCSVToFile(localpath, [[user.UID, '3', '180']])

    def SetMyCoffee(self, user):
        global path
        localpath = path +"mycoffee.csv"
        tab = CSVParser.GetCSVFromFile(localpath)
        for i, line in enumerate(tab):
            if(user[0] == line[0]):
                tab[i] = user
        CSVParser.SetCSVToFile(localpath, tab)
