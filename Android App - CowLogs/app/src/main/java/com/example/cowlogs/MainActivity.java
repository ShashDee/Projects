package com.example.cowlogs;

import android.Manifest;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.util.ArrayList;
import java.util.Iterator;

public class MainActivity extends AppCompatActivity
{
    // declaring variables
    public int currentPage;
    public static ArrayList<CowLogs> cowLogsList;
    public static String profileUsername;
    public static String profilePassword;

    public static final int MY_PERMISSIONS_REQUEST_LOCATION = 99;

    // string array holding cow names
    static String[] pageNames = {"Angus", "Hereford", "Brahman", "Shorthorn", "Brangus"};

    // default constructor
    public MainActivity()
    {
        // setting current page to 5, which means home page, initially
        this.currentPage = 5;

        // initialising arraylist to hold log entries
        cowLogsList = new ArrayList<CowLogs>();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main); // set view to activity_main

        // loading home page
        HomeFragment frag = new HomeFragment();
        FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
        ft.replace(R.id.cowPlace, frag);
        ft.commit();

        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        // initialising DBAdapter
        DBAdapter db = new DBAdapter(this);

        // try catch block to create database in mobile device
        try
        {
            String destPath = "/data/data/" + getPackageName() + "/databases";
            File f = new File(destPath);

            if (!f.exists())
            {
                // create directory and then copy db
                f.mkdirs();
                f.createNewFile();

                // copy the db from the assets folder into the databases folder
                CopyDB(getBaseContext().getAssets().open("cowDB.db"),
                        new FileOutputStream(destPath + "/cowDB.db"));
            }

            // fetching old entries from the database
            getExistingEntries(db);
        }
        catch (FileNotFoundException e)
        {
            e.printStackTrace(); // print exception
        }
        catch (IOException e)
        {
            e.printStackTrace(); // print exception
        }

        // getting location access permissions
        checkLocationPermission();
    }

    @Override
    public void onBackPressed() // when the mobile back button is pressed
    {
        //Display alert message when back button has been pressed
        saveEntriesConfirmation();
        return;
    }

    public void CopyDB(InputStream inputStream,
                       OutputStream outputStream) throws IOException
    {
        // copy 1K bytes at a time
        byte[] buffer = new byte[1024];
        int length;

        while ((length = inputStream.read(buffer)) > 0)
        {
            outputStream.write(buffer, 0, length);
        }

        inputStream.close();
        outputStream.flush();
        outputStream.close();
    }

    // method to get existing entries from the database
    public void getExistingEntries(DBAdapter db)
    {
        // opening database
        db.open();

        // cursor to loop through all entries
        Cursor entriesList = db.getAllEntries();

        if(entriesList.moveToFirst())
        {
            do
            {
                // adding entries to local arraylist
                cowLogsList.add(new CowLogs(entriesList.getString(1),
                        Integer.parseInt(entriesList.getString(2)),
                        Integer.parseInt(entriesList.getString(3)),
                        entriesList.getString(4),
                        Integer.parseInt(entriesList.getString(5)),
                        entriesList.getString(6),
                        entriesList.getString(7),
                        entriesList.getString(8)));
            }
            while (entriesList.moveToNext());
        }

        // closing database
        db.close();
    }

    // method to load data entry page
    public void loadCowEntries(View view)
    {
        //Retrieve index from view's tag to determine the cow
        currentPage = Integer.valueOf((String)view.getTag());
        showCurrentPage(); // load current page
    }

    // method called when previous button is pressed
    public void prevControl(View view)
    {
        if(currentPage == 0) // setting current page to last cow if at first cow
            currentPage = 4;
        else
            currentPage--; // decrementing current page indicator

        // loading current page
        showCurrentPage();
    }

    // method called when next button is pressed
    public void nextControl(View view)
    {
        if(currentPage == 4) // setting current page to first cow if at last cow
            currentPage = 0;
        else
            currentPage++; // incrementing current page indicator

        // loading current page
        showCurrentPage();
    }

    // method called when home button is pressed
    public void homeControl(View view)
    {
        // setting current page to 5 which means home page
        currentPage = 5;

        // loading current page
        showCurrentPage();
    }

    // method called when return button is show logs page is clicked
    public void returnControl(View view)
    {
        // loading current page
        showCurrentPage();
    }

    // method to load current page based on currentPage variable
    public void showCurrentPage()
    {
        if(currentPage == 5) // if home page
        {
            // loading home page
            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            HomeFragment hf = new HomeFragment();
            ft.replace(R.id.cowPlace, hf);
            ft.commit();
        }
        else if (currentPage >= 0 && currentPage <= 4) // if cow data entry page
        {
            // loading data entry page with selected cow name as title
            CowFragment frag = new CowFragment();

            //Communicate the cow breed to the fragment
            Bundle args = new Bundle();
            args.putInt("cow", currentPage);
            frag.setArguments(args);
            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            ft.replace(R.id.cowPlace, frag).commit();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item)
    {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        if (id == R.id.action_send) // if send option is selected
        {
            // calling method to send entries
            sendAllEntries();
            return true;
        }
        else if (id == R.id.action_save) // if save option is selected
        {
            // calling method to save entries
            saveEntriesToDB();
            return true;
        }
        else if(id == R.id.action_profile) // if profile option is selected
        {
            // loading profile page
            FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
            ProfileFragment pf = new ProfileFragment();
            ft.replace(R.id.cowPlace, pf);
            ft.commit();

            return true;
        }
        else // default
        {
            return super.onOptionsItemSelected(item);
        }
    }

    // saving entries to database
    public void saveEntriesToDB()
    {
        // creating new DBAdapter object
        DBAdapter db  = new DBAdapter(this);

        // opening database
        db.open();
        // deleting all existing entries from database
        db.removeAll();

        // iterator to loop through entries and add to database
        Iterator<CowLogs> itr = cowLogsList.iterator();

        while (itr.hasNext())
        {
            CowLogs currentLog = itr.next();

            // inserting entry to database
            db.insertEntry(currentLog.getID(), String.valueOf(currentLog.getAge()),
                    String.valueOf(currentLog.getWeight()), currentLog.getCondition(),
                    String.valueOf(currentLog.getType()), currentLog.getDateTime(), currentLog.getLongitude(),
                    currentLog.getLatitude());
        }

        // closing database
        db.close();
    }

    // sending entries
    public void sendAllEntries()
    {
        // getting current context
        final Context ctx = this;

        // creating new DBAdapter object
        final DBAdapter db  = new DBAdapter(ctx);

        // showing alert dialog notifying all entries will be deleted
        new AlertDialog.Builder(this)
            .setTitle("Are you sure? This will delete all entries.")
            .setMessage("Save entries to DB first?")
            .setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener()
            {
                // if yes
                public void onClick(DialogInterface dialog, int which)
                {
                    db.open(); // open database
                    db.removeAll(); // delete all entries
                    db.close(); // close database

                    // sending email with all log entries as an background process
                    try
                    {
                        // creating new background process.
                        // profile user name is sent as a parameter
                        new DoBackgroundTask().execute(profileUsername);
                    }
                    catch (Exception ex)
                    {
                        ex.printStackTrace();
                    }

                    if(currentPage != 5) // if user was in a cow page
                    {
                        // loading entries page after sending email
                        // create new cow list fragment instance
                        CowList frag = new CowList();

                        //Communicate the cow breed to the fragment by passing the cow number as an argument
                        Bundle args = new Bundle();
                        args.putInt("cow", currentPage);
                        frag.setArguments(args);
                        FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
                        ft.replace(R.id.cowPlace, frag).commit();
                    }
                    else // if user was in home page
                    {
                        showCurrentPage();
                    }
                }
            })
            .setNegativeButton(android.R.string.cancel, null) // if no do nothing
            .setIcon(android.R.drawable.sym_def_app_icon) // setting alert icon
            .show();
    }

    // saving entries
    public void saveEntriesConfirmation()
    {
        // showing alert dialog asking to save entries to database when back button is pressed
        new AlertDialog.Builder(this)
                .setTitle("Database not saved")
                .setMessage("Save entries to DB first?")
                .setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener()
                {
                    // if yes
                    public void onClick(DialogInterface dialog, int which)
                    {
                        // save entries to database
                        saveEntriesToDB();
                        // close application
                        finish();
                    }
                })
                .setNegativeButton("No", new DialogInterface.OnClickListener()
                {
                    public void onClick(DialogInterface dialog, int which)
                    {
                        finish();
                    }
                }) // if no, close application without saving
                .setIcon(android.R.drawable.sym_def_app_icon) // setting icon
                .show();
    }

    // background process method to send mail
    private class DoBackgroundTask extends AsyncTask<String, Integer, Integer>
    {
        @Override
        protected Integer doInBackground(String... strings)
        {
            // setting recipient email addresses
            String[] to = {"mahbub.a.au@gmail.com"};
            String[] cc = {"i.v.abeyratne@cqumail.com"};

            // String builder to hold email body
            StringBuilder message = null;

            if(profileUsername != null) // if user has saved a profile
                 message = new StringBuilder(strings[0]);
            else // if user has not saved a profile
                message = new StringBuilder("Not Set");

            // looping through low logs list and creating email body
            for(int i = 0; i < cowLogsList.size(); i++)
            {
                message.append("\n").append(getTypeName(cowLogsList.get(i).getType()))
                        .append(" ").append(cowLogsList.get(i).getCondition())
                        .append(" ").append(cowLogsList.get(i).getDateTime())
                        .append(" ").append(cowLogsList.get(i).getID())
                        .append(" ").append(cowLogsList.get(i).getWeight())
                        .append(" ").append(cowLogsList.get(i).getAge());
            }

            // sending email in try catch block
            try
            {
                // calling method to send email.
                sendEmail(to, cc, "New Logger Data", message.toString());

                // initialising local arraylist to a new empty arraylist
                cowLogsList = new ArrayList<>();

                // return 1 if email sent successfully
                return 1;
            }
            catch (Exception ex)
            {
                // return 0 in case of an exception
                return 0;
            }
        }

        // method to get cow name based on type integer
        private String getTypeName(Integer type)
        {
            String cowType = null;

            // switch case to get cow type name
            switch (type)
            {
                case 0:
                    cowType = "Angus";
                    break;
                case 1:
                    cowType = "Hereford";
                    break;
                case 2:
                    cowType = "Brahman";
                    break;
                case 3:
                    cowType = "Shorthorn";
                    break;
                case 4:
                    cowType = "Brangus";
                    break;
                default:
                    break;
            }

            // return cow type name
            return cowType;
        }

        // method to send email
        private void sendEmail(String[] emailAddresses, String[] carbonCopies,
                               String subject, String message)
        {
            // creating Intent object and setting email properties
            Intent emailIntent = new Intent(Intent.ACTION_SEND);
            emailIntent.setData(Uri.parse("mailto:"));
            String[] to = emailAddresses;
            String[] cc = carbonCopies;
            emailIntent.putExtra(Intent.EXTRA_EMAIL, to);
            emailIntent.putExtra(Intent.EXTRA_CC, cc);
            emailIntent.putExtra(Intent.EXTRA_SUBJECT, subject);
            emailIntent.putExtra(Intent.EXTRA_TEXT, message);
            emailIntent.setType("message/rfc822");
            startActivity(Intent.createChooser(emailIntent, "Email")); // starting emailing process
        }
    }

    // method to get location access permission from android device
    public boolean checkLocationPermission()
    {
        // if permission not granted
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED)
        {
            // if an explanation is required to grant location access
            if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.ACCESS_FINE_LOCATION))
            {
                // showing alert dialog with explanation
                new AlertDialog.Builder(this)
                    .setTitle(R.string.title_location_permission)
                    .setMessage(R.string.text_location_permission)
                    .setPositiveButton("Yes", new DialogInterface.OnClickListener()
                    {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i)
                        {
                            //Prompt the user once explanation has been shown
                            ActivityCompat.requestPermissions(MainActivity.this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, MY_PERMISSIONS_REQUEST_LOCATION);
                        }
                    }).create().show();
            }
            else
            {
                // if no explanation is needed the default request permission alert dialog is shown
                ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, MY_PERMISSIONS_REQUEST_LOCATION);
            }

            return false;
        }
        else
        {
            return true;
        }
    }
}
