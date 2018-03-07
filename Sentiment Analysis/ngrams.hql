-- No need to import file locations since they are already uploaded due to preprocessing
-- Preprocessing is necessary for removal of punctuation marks
-- to run call: hive -hiveconf N = number(2 for bigrams, and 3 for trigrams) -f ngrams.hql

SELECT EXPLODE(NGRAMS(SENTENCES(LOWER(review)), cast('${hiveconf:N}' as int), 20))
AS grams
FROM processedData;
