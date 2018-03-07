package stubs;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.fs.FSDataInputStream;
import org.apache.hadoop.fs.FileSystem;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.hive.ql.exec.UDF;
import org.apache.hadoop.hive.ql.exec.Description;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.conf.Configured;
import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.util.Tool;
import org.apache.hadoop.util.ToolRunner;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStreamReader;

import org.apache.hadoop.hive.ql.metadata.HiveException;

import java.sql.SQLException;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.Statement;
import java.sql.DriverManager;
public class EvaluateSentiment extends UDF {
	protected ArrayList<String> negList = new ArrayList<String>();
	private static final String negFile = "/finalproject/neg-words.txt";
	protected ArrayList<String> posList = new ArrayList<String>();
	private static final String posFile = "/finalproject/pos-words.txt";

	protected int negativeCounter = 0;
	protected int positiveCounter = 0;
	protected boolean lastNGram = false;

	//Create word list
	public void getList(String path, ArrayList<String> list) {

		try {
			FileSystem fs = FileSystem.get(new Configuration());
			FSDataInputStream in = fs.open(new Path(path));
			BufferedReader br = new BufferedReader(new InputStreamReader(in));    

			String ret;
			while ((ret = br.readLine()) != null) {
				list.add(ret);
			}
			br.close();
			return;

		} catch (Exception e) { 

			System.out.println("out: Error Message: " + path + " exc: " + e.getMessage());
			return;
		} 
	}
	
	//Create 2-grams
	public static List<String[]> ngrams(int n, String str) {
	    List<String[]> ngrams = new ArrayList<String[]>();
	    String[] words = str.split(" ");
	    for (int i = 0; i < words.length - 1; i++) {
	    	String wordTokens[] = new String[2];
	    	wordTokens[0] = words[i];
	    	wordTokens[1] = words[i + 1];
	    	ngrams.add(wordTokens);
		}
	    return ngrams;
	}
	
	//Get sentiment for a word using positive and negative word list
	protected String getLabelForWord(String word) {
		
		//If a word is in negative words list, return negative
		////If in positive words list, then return positive
		if(negList.contains(word))
			return "negative";
		} else if(posList.contains(word)) {
			return "positive";
		} 
		String tempWord = "";
		//If word contains _, then a special word is present which negates the tone
		//of the word. So, if the word is in negatice words list, return positive,
		//If in positive words list, then return negative
		if(word.contains("_")) {
			tempWord = word.split("_")[1];	

			if(negList.contains(tempWord)){
				return "positive"; 
			} else if(posList.contains(tempWord)) {
				return "negative";
			} 
		}
		return "neutral";
	}

	public Text evaluate(Text review) throws Exception {
		Text to_value = new Text("");
		//Create negative words list from file
		if(negList.isEmpty()) {
			getList(negFile, negList);
		}
		//Create positive words list from file
		if(posList.isEmpty()) {
			getList(posFile, posList);
		}
		positiveCounter = negativeCounter = 0;
		lastNGram = false;
		if (review != null) {
			
			try {
				List<String[]> ngrams = ngrams(2, review.toString()); 
				String label = "";
				String label_word1 = "";
				String label_word2 = "";
				boolean ignoreWord1 = false;
				for(int i = 0; i < ngrams.size(); i++) {
					String wordTokens[] = ngrams.get(i);
					if(i == ngrams.size() - 1)
						lastNGram = true;
					//n-gram contains one or more special words. So, each word is treated as a seperate entity
					//and sentiment is predicted individually
					if(wordTokens[0].contains("_") || wordTokens[1].contains("_")) {
						
						//first word in this ngram was already predicted in the last ngram. SO 
						//ignore now
						if(!ignoreWord1) 
							label_word1 = getLabelForWord(wordTokens[0]);
						else
							label_word1 = "neutral";
						ignoreWord1 = false;
						if(wordTokens[1].contains("_")) {
							label_word2 = "neutral";
							if(lastNGram)
								label_word2 = getLabelForWord(wordTokens[1]);
						} else
							label_word2 = getLabelForWord(wordTokens[1]);
						//increment postive or negative counter for both words based one
						//predicted sentiment
						if(label_word1.trim().equals("positive")) {
							positiveCounter++;
						} else if(label_word1.trim().equals("negative")) {
							negativeCounter++;
						} 
						if(label_word2.trim().equals("positive")) {
							positiveCounter++;
							ignoreWord1 = true; 
						} else if(label_word2.trim().equals("negative")) {
							negativeCounter++;
							ignoreWord1 = true;
						} 
						continue;
					} else {
						
						if(!ignoreWord1) 
							label_word1 = getLabelForWord(wordTokens[0]);
						else
							label_word1 = "neutral";
						ignoreWord1 = false;
						label_word2 = getLabelForWord(wordTokens[1]);
						//Atleast one word in the 2gram is neutral or not present in any list
						if(label_word1.trim().equals("neutral") || label_word2.trim().equals("neutral")) {
							//both neutral, so sentiment for 2gram is neutral
							if(label_word1.trim().equals("neutral") && label_word2.trim().equals("neutral"))
								label = "neutral";
							else if(label_word1.trim().equals("neutral")) {
								//if first word is neutral, ignore second word label unless it is the
								//last ngram. It takes care of cases like (word1, pretty), (pretty, good)
								//pretty is considered only in the second gram along with good.
								label = "neutral";
								if(lastNGram)
									label = label_word2;
							} else 
								label = label_word1;
						} else if(label_word1.equals("positive")) {
							//If both the words are positive, then ngram sentiment is positve
							//otherwise negative
							if(label_word2.equals("positive")) 
								label = "positive";
							else
								label = "negative";
							ignoreWord1 = true;
						} else  {
							label = "negative";
							if(label_word1.equals("negative") && label_word2.equals("positive")) {
								label = "positive";
								ignoreWord1 = true;
							}
						}
					}
					
					//Increment counter for the corresponding sentiment
					if(label.trim().equals("positive"))
						positiveCounter++;
					else if(label.trim().equals("negative"))
						negativeCounter++;
				}
			     
				//If the positive counter is greater == negative counter
				//review is neutral, if pos is greater, then it is positive review
				//otherwise it is negative review
				if(positiveCounter == negativeCounter)
					label = "neutral";
				else if(positiveCounter > negativeCounter)
					label = "positive";
				else	
					label = "negative";
	      
				StringBuilder strBuilder = new StringBuilder();
				strBuilder.append(label);


				to_value.set(strBuilder.toString());
			} catch (Exception e) { // Should never happen
				throw e;
			}
		}
		return to_value;
	}
}