import sys
import re

from pyspark import SparkContext

if __name__ == "__main__":
    
    if len(sys.argv) < 3:
      sys.exit("Usage: %s inputFolder outputFolder" % sys.argv[0])
        
    inputFolder = sys.argv[1]
    outputFolder = sys.argv[2]
    #example : spark-submit --master local filter_invalid_reviews.py file:/home/training/Input/hw_reviews_FL2016 file:/home/training/SparkOutput  

    sc = SparkContext()

    special_words_list = ["ain’t", "ain't", "aren't", "aren’t", "behind", "can’t", "can't", "cannot", "couldn't", "couldn’t", "despite",  "didn’t", "didn't", "doesn’t", "doesn't", "don't", "don’t", "except", "hadn’t", "hadn't", "hasn't","hasn’t", "haven't","haven’t", "instead", "isn't", "isn’t", "least", "never", "not", "nothing", "shouldn’t" ,"shouldn't", "wasn't", "wasn’t", "weren't" , "weren’t", "won't", "won’t", "wouldn't","wouldn’t",  "yet"];
    
    #function to remove empty reviews and all reviews shorter than 50 words
    def filterTrivialReviews(nameContentsPair) :
        if len(nameContentsPair[1].split()) < 50 :
            return False
        return True

    #function to get homework number from file name
    def getHWNo(fullFileName) :
        pattern = re.compile(r'hw[0-9]+_') 
        matchObj = pattern.findall(fullFileName)
        if matchObj:
            return re.sub('[hw_]', '', matchObj[0])
        else :
            pattern = re.compile(r'hwM_') 
            matchObj = pattern.findall(fullFileName)
            if matchObj :
                return '100'

    #function to get label (positive, negative, neutral, not_labled) from file path
    def getLabel(fullFileName) :
        label = "not_labled"
        if fullFileName.find("positive") != -1 :
            label = "positive"
        elif fullFileName.find("negative") != -1 :
            label = "negative"
        elif fullFileName.find("neutral") != -1 :
            label = "neutral"
        return label

    #function to remove all non-word characters
    def filterContent(content) :
        filteredData = re.sub(u'[^a-zA-Z\'`]', " ".encode('utf8'), content.encode('utf8'))
        filteredData = re.sub(u'\'\'', "_".encode('utf8'), filteredData.encode('utf8'))
        return re.sub('[ ]{2,}', ' ', filteredData)

    #function to process each file
    def prepareData(nameContentsPair) :
        fullFileName = str(nameContentsPair[0].decode('ascii', 'ignore'))
        hwNo = getHWNo(fullFileName)
        label = getLabel(fullFileName)   
    
        #process context sensitive words like not, don't etc.
        words = nameContentsPair[1].split();
        length = len(words)
        index = 0
        while index < length:
            word = words[index]
			#If problem if followed by a number. (Since review talks about problem 1 in
			#homework, it should be treated as stop word. Since numbers and other special characters 
			#are removed in this program, checking if problem is followed by number is not possible
			#later.
            if word.lower() == "problem":
                if words[index + 1].isdigit():
                    words[index] = ""
                    continue;
            if ("problem" in word.lower()):
                if index < length - 2:
                    if any(ch.isdigit() for ch in words[index + 1]) :
                        words[index] = ""
						continue;
            #if word is a special word then
            if word in special_words_list: #if word present in special words
                special_word = word
                index = index + 1
                #append the special word to all the subsequent words till a
                #punctuation is encountered(use '' as seperator)
                while index < length:
                    pattern = re.compile('[^a-zA-Z\'`]') 
                    matchObj = pattern.findall(words[index])
                    words[index] = special_word + "''" + words[index]
                    #if punctuation is encountered
                    if matchObj:
                        break;
                    if index < length - 2 and (words[index + 1].lower() == "and" or words[index + 1].lower() == "or" or words[index + 1].lower() == "because"):
                        break;
                    index = index + 1
            index = index + 1
        newLine = ""
        
        #create the review with updated words
        for word in words:
            newLine = newLine + " " + word
        
        return (hwNo + '\t' + label + '\t' + filterContent(newLine))
    
    #spark pipeline
    inputData = sc.wholeTextFiles(inputFolder + "/*/*") #read files
    nonTrivialReviews = inputData.map(lambda (fullFileName,contents): ([fullFileName, contents])).filter(filterTrivialReviews) #filter trivial reviews
    nonTrivialReviews.map(prepareData).saveAsTextFile(outputFolder); #process reviews and store
    
    sc.stop()