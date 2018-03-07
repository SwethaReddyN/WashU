DROP TABLE IF EXISTS finaloutput;

--Create finaloutput table first:
CREATE TABLE finaloutput
(hw_number INT,
lable STRING,
review STRING,
evaluated STRING)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\001';

--Load file into finaloutput table:
LOAD DATA LOCAL INPATH '/home/training/SentimentOutput/000000_0'
INTO TABLE finaloutput;