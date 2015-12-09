import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class BookStoreDB {

	   // JDBC driver name and database URL
	   static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";  
	   static final String DB_URL = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/batuhan_tuter";
	   
	   //  Database credentials
	   static final String USER = "*******";
	   static final String PASS = "*******";
	   
	public static void main(String[] args) {
		
		Connection conn = null;
		Statement stmt = null;
		   try{
		      //STEP 2: Register JDBC driver
		      Class.forName(JDBC_DRIVER);
		      
		      //STEP 3: Open a connection
		      System.out.println("Connecting to a selected database...");
		      conn = DriverManager.getConnection(DB_URL, USER, PASS);
		      System.out.println("Connected database successfully...");
		      
		      //STEP 4: Execute a query
		      System.out.println("Creating table in given database...");
		      stmt = conn.createStatement();
		      
		      stmt.execute("SET FOREIGN_KEY_CHECKS=0");
		      String sql = "DROP TABLE if exists book ";
		      stmt.executeUpdate(sql);
		      sql = "DROP TABLE if exists store_branch ";
		      stmt.executeUpdate(sql);
		      sql = "DROP TABLE if exists has";
		      stmt.executeUpdate(sql);
		      sql = "DROP TABLE if exists manager";
		      stmt.executeUpdate(sql);
		      stmt.execute("SET FOREIGN_KEY_CHECKS=1");
		      
		      sql = "CREATE TABLE book " +
		                   "(bid CHAR(12) not NULL, " +
		                   " bname VARCHAR(50), " + 
		                   " author VARCHAR(50), " + 
		                   " publisher VARCHAR(50), " + 
		                   " year INTEGER, " +
		                   " PRIMARY KEY ( bid )) ENGINE=InnoDB"; 
		      stmt.executeUpdate(sql);
		      
		      sql = "CREATE TABLE manager " +
	                   "(mid CHAR(12) not NULL, " +
	                   " password VARCHAR(10), " + 
	                   " mname VARCHAR(50), " + 
	                   " startYear INTEGER, " +
	                   " PRIMARY KEY ( mid )) ENGINE=InnoDB";
		      stmt.executeUpdate(sql);
		      
		      sql = "CREATE TABLE store_branch " +
	                   "(sid CHAR(12) not NULL, " +
		    		   " sname VARCHAR(20), " +
	                   " mid CHAR(12) not NULL,  " + 
	                   " address VARCHAR(50), " + 
	                   " city VARCHAR(20), " + 
	                   " size VARCHAR(20), " +
	                   " PRIMARY KEY ( sid ), " +
	                   " FOREIGN KEY (mid) REFERENCES manager (mid)) ENGINE=InnoDB" ; 
		      stmt.executeUpdate(sql);
		      
		      sql = "CREATE TABLE has " +
	                   "(bid CHAR(12) not NULL, " +
		    		   " sid CHAR(12) not NULL, " +
	                   " stock INTEGER, " + 
	                   " FOREIGN KEY (bid) REFERENCES book (bid), " +
	                   " FOREIGN KEY (sid) REFERENCES store_branch (sid)) ENGINE=InnoDB"; 
		      stmt.executeUpdate(sql);
		      System.out.println("Created table in given database...");
		      
		      sql = "INSERT INTO book " +
		    		  "VALUES ('1', 'Ogullar ve Rencide Ruhlar', 'Alper Caniguz', 'Iletisim', 2003) "; 
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO book " +
		    		  "VALUES ('2', 'Veciz Sozler', 'Baris Bicakci' , 'Iletisim' , 2002)"; 
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO book " +       
	                   "VALUES ('3', 'Ruhi Mucerret', 'Murat Mentes', 'April', 2013)";
		      stmt.executeUpdate(sql);
		      
		      sql = "INSERT INTO manager " + 
		    		  "VALUES ('5' , '11111' , 'Mehmet Guvercin' , 2011)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO manager " + 
		    		  "VALUES ('6' , '22222' , 'Istemi Bahceci' , 2012)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO manager " + 
		    		  "VALUES ('7' , '33333' , 'Basak Unsal' , 2014)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO manager " + 
		    		  "VALUES ('8' , '44444' , 'Can Firtina' , 2015)";
		      stmt.executeUpdate(sql);
		      
		      sql = "INSERT INTO store_branch " + 
		    		  "VALUES ('111' , 'Tunali' , '5' , 'Tunali Hilmi Caddesi No:12' , 'Ankara' , 'medium')";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO store_branch " + 
		    		  "VALUES ('112' , 'Besiktas' , '6' , 'Kadırgalar Caddesi No:3' , 'Istanbul' , 'small')";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO store_branch " + 
		    		  "VALUES ('113' , 'Bilkent' , '7' , 'Bilkent Center No:8' , 'Ankara' , 'large')";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO store_branch " + 
		    		  "VALUES ('114' , 'Kadikoy' , '8' , 'Rihtim Caddesi No:44' , 'Istanbul' , 'medium')";
		      stmt.executeUpdate(sql);
		      
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('1' , '111' , 6)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('3' , '111' , 4)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('1' , '113' , 3)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('2' , '113' , 5)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('3' , '113' , 3)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('3' , '112' , 4)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('1' , '114' , 3)";
		      stmt.executeUpdate(sql);
		      sql = "INSERT INTO has " + 
		    		  "VALUES ('2' , '114' , 6)";
		      stmt.executeUpdate(sql);
		      
		      sql = "SELECT * FROM book";
		      ResultSet rs = stmt.executeQuery(sql);
		      System.out.println("SELECT * FROM book:");
		      while(rs.next()){
		          //Retrieve by column name
		          String bid  = rs.getString("bid");
		          String bname  = rs.getString("bname");
		          String author  = rs.getString("author");
		          String publisher  = rs.getString("publisher");
		          int year = rs.getInt("year");

		          //Display values
		          System.out.print("bid: " + bid);
		          System.out.print(", bname: " + bname);
		          System.out.print(", author: " + author);
		          System.out.print(", publisher: " + publisher);
		          System.out.println(", year: " + year);
		       }
	      		      
		   }catch(SQLException se){
		      //Handle errors for JDBC
		      se.printStackTrace();
		   }catch(Exception e){
		      //Handle errors for Class.forName
		      e.printStackTrace();
		   }finally{
		      //finally block used to close resources
		      try{
		         if(conn!=null)
		            conn.close();
		      }catch(SQLException se){
		         se.printStackTrace();
		      }//end finally try
		   }//end try
		   System.out.println("Goodbye...");

	}

}
