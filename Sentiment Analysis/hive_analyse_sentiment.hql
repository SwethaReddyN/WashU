DROP TABLE IF EXISTS processedData;

--Create processedData table first:
CREATE TABLE processedData
(hw_number INT,
lable STRING,
review STRING)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\001';

--Load file into processedData table:
LOAD DATA LOCAL INPATH '/home/training/Output/000000_0'
INTO TABLE processedData;

--Create Hive function by using UDF:
ADD JAR /home/training/training_materials/FinalProject/analysis.jar;
CREATE TEMPORARY FUNCTION evaluate as 'stubs.EvaluateSentiment';

--Write the result to local disk:
INSERT OVERWRITE LOCAL DIRECTORY '/home/training/SentimentOutput'
SELECT hw_number,lable, review, evaluate(review) from processedData;