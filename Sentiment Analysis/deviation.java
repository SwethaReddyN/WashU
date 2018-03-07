package stubs;

import org.apache.hadoop.hive.ql.exec.UDF;

public class deviation extends UDF{
	public int evaluate(int truth, int evaluation) throws Exception {
		int res=Math.abs(truth-evaluation);
		
		try{
			
		} catch (Exception e) { // Should never happen
		 	throw e;
			//to_value = new Text(s);
		    }
		
		return res;
	    }
}
