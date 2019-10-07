package com.example.cowlogs;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class DBAdapter
{
    // declaring variables for database
    static final String KEY_ROWID = "_id";
    static final String KEY_COWID = "cow";
    static final String KEY_AGE = "Age";
    static final String KEY_WEIGHT = "Weight";
    static final String KEY_CONDITON = "Condition";
    static final String KEY_TYPE = "Type";
    static final String KEY_DATETIME = "DateTime";
    static final String KEY_LONGITUDE = "Longitude";
    static final String KEY_LATITUDE = "Latitude";
    static final String TAG = "DBAdapter";
    static final String DATABASE_NAME = "cowDB";
    static final String DATABASE_TABLE = "cows";
    static final int DATABASE_VERSION = 1;
    static final String DATABASE_CREATE =
            "create table cows (_id integer primary key autoincrement, "
                    + "cow text not null, Age text not null, Weight text not null, Condition text not null, Type text not null, DateTime text not null, Longitude text not null, Latitude text not null);";
    final Context context;
    DatabaseHelper DBHelper;
    SQLiteDatabase db;

    // constructor
    public DBAdapter(Context ctx)
    {
        this.context = ctx;
        DBHelper = new DatabaseHelper(context);
    }

    private static class DatabaseHelper extends SQLiteOpenHelper
    {
        DatabaseHelper(Context context)
        {
            super(context, DATABASE_NAME, null, DATABASE_VERSION);
        }

        @Override
        public void onCreate(SQLiteDatabase db)
        {
            // try catch block to create the database table
            try
            {
                db.execSQL(DATABASE_CREATE); // executing table create statement
            }
            catch (SQLException e)
            {
                e.printStackTrace();
            }
        }

        @Override
        public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion)
        {
            // dropping and recreating database on upgrade
            Log.w(TAG, "Upgrading database from version " + oldVersion + " to "
                    + newVersion + ", which will destroy all old data");
            db.execSQL("DROP TABLE IF EXISTS contacts");
            onCreate(db);
        }
    }

    // inserting an entry into the database
    public long insertEntry(String id, String age, String weight, String condition, String type, String dateTime, String longitude, String latitude)
    {
        // setting insert values
        ContentValues initialValues = new ContentValues();
        initialValues.put(KEY_COWID, id);
        initialValues.put(KEY_AGE, age);
        initialValues.put(KEY_WEIGHT, weight);
        initialValues.put(KEY_CONDITON, condition);
        initialValues.put(KEY_TYPE, type);
        initialValues.put(KEY_DATETIME, dateTime);
        initialValues.put(KEY_LONGITUDE, longitude);
        initialValues.put(KEY_LATITUDE, latitude);
        return db.insert(DATABASE_TABLE, null, initialValues); // inserting to database
    }

    // retrieving all the cow logs
    public Cursor getAllEntries()
    {
        // fetching cow logs and returning
        return db.query(DATABASE_TABLE, new String[] {KEY_ROWID, KEY_COWID, KEY_AGE, KEY_WEIGHT, KEY_CONDITON, KEY_TYPE, KEY_DATETIME, KEY_LONGITUDE, KEY_LATITUDE}, null, null, null, null, null);
    }

    // opens the database
    public DBAdapter open() throws SQLException
    {
        db = DBHelper.getWritableDatabase();
        return this;
    }

    // closes the database
    public void close()
    {
        DBHelper.close();
    }

    // deletes all entries
    public boolean removeAll()
    {
        return db.delete(DATABASE_TABLE, null, null) > 0;
    }
}
