import weka.core.*;
import weka.core.converters.*;
import java.io.*;

/**
 * A simple API example of transferring an ARFF file into a MySQL table.
 * It loads the data into the database "weka_test" on the MySQL server
 * running on the local machine. Instead of using the relation name of the
 * database as the table name, "mytable" is used instead. The
 * DatabaseUtils.props file must be configured accordingly. <p/>
 *
 * Usage: Arff2Database input.arff
 *
 * @author FracPete (fracpete at waikato dot ac dot nz)
 */
public class Arff2Database {

  /**
   * loads a dataset into a MySQL database
   *
   * @param args    the commandline arguments
   */
  public static void main(String[] args) throws Exception {
    Instances data = new Instances(new BufferedReader(new FileReader(args[0])));
    data.setClassIndex(data.numAttributes() - 1);

    DatabaseSaver save = new DatabaseSaver();
    save.setUrl("jdbc:mysql://localhost:8889/weka_test");
    save.setUser("root");
    save.setPassword("root");
    save.setInstances(data);
    save.setRelationForTableName(false);
    save.setTableName("weka_data");
    save.connectToDatabase();
    save.writeBatch();
  }
}
