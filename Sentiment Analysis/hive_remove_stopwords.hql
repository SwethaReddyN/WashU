DROP TABLE IF EXISTS review;

--Create review table first:
CREATE TABLE review
(hw_number INT,
lable STRING,
review STRING)
ROW FORMAT DELIMITED
FIELDS TERMINATED BY '\t';

--Load file into review table:
LOAD DATA LOCAL INPATH '/home/training/SparkOutput/part-00000'
INTO TABLE review;

--Create Hive function by using UDF:
ADD JAR /home/training/training_materials/FinalProject/stop.jar;
CREATE TEMPORARY FUNCTION stop as 'stubs.whitelist';

--Write the result to local disk:
INSERT OVERWRITE LOCAL DIRECTORY '/home/training/Output'
select hw_number,lable,stop(review) from review;