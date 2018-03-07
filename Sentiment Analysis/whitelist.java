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
public class whitelist extends UDF {
    protected ArrayList<String> l = new ArrayList<String>();
    private static final String arch = "/finalproject/english.stop";
    public void getList( ) {

        try {
            FileSystem fs = FileSystem.get(new Configuration());
            FSDataInputStream in = fs.open(new Path(arch));
            BufferedReader br = new BufferedReader(new InputStreamReader(in));    

            String ret;
            while ((ret = br.readLine()) != null) {
                l.add(ret);
            	//System.out.println(ret);
            }
            br.close();
            return;

        } catch (Exception e) { 

	    System.out.println("out: Error Message: " + arch + " exc: " + e.getMessage());
	    return;
	} 
    }
    public Text evaluate(Text s) throws Exception {
	Text to_value = new Text("");
	if(l.isEmpty()) {
			getList();
		}
	if (s != null) {
	    try {
		String [] words = s.toString().toLowerCase().split(" ");
		String tokens[];
		for(int i = 0; i < words.length; i++){
		    if(l.contains(words[i])) {
		    	words[i]="";
		    } else if(words[i].contains("_")) {
		    	
		    	tokens = words[i].split("_");
		    	if(tokens.length < 2 || l.contains(words[i].split("_")[1])) {
		    		words[i] = "";
		    	}
		    }
	     }
		
		StringBuilder strBuilder = new StringBuilder();
       	    	for (int i = 0; i < words.length; i++) {
		    if(!words[i].isEmpty()) strBuilder.append(words[i]+" ");
	    	}
		    	
		to_value.set(strBuilder.toString());
		//to_value.set(s.toString().toUpperCase().replace("I",""));
	    } catch (Exception e) { // Should never happen
	 	throw e;
		//to_value = new Text(s);
	    }
	}
	return to_value;
    }
}