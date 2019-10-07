package com.example.cowlogs;

import android.os.Bundle;
import android.os.Debug;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;
import java.util.Calendar;

public class CowFragment extends Fragment {

    // string array to hold condition dropdown options
    String[] conditions;
    TrackGPS trackGPS;

    // default constructor
    public CowFragment()
    {
        // Required empty public constructor
    }

    @Override
    public void onStart()
    {
        super.onStart();

        trackGPS = new TrackGPS(this.getContext());
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.cow_fragment, container, false);

        // Get cow number passed as an argument to page
        int cow = getArguments().getInt("cow");

        //Modify label based on cow number
        TextView cowLabel = (TextView) view.findViewById(R.id.title_tv);
        cowLabel.setText(MainActivity.pageNames[cow]);

        return view;
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState)
    {
        super.onViewCreated(view, savedInstanceState);

        // getting all input components and buttons of data entry page
        final EditText idEditText = (EditText)getActivity().findViewById(R.id.id_ed);
        final EditText weightEditText = (EditText)getActivity().findViewById(R.id.weight_ed);
        final EditText ageEditText = (EditText)getActivity().findViewById(R.id.age_ed);
        final Spinner conditionSpinner = (Spinner)getActivity().findViewById(R.id.condition_sp);
        Button save = (Button)getActivity().findViewById(R.id.save_btn);
        Button showEntries = (Button)getActivity().findViewById(R.id.show_entries_btn);

        // loading options to condition dropdown
        conditions = getResources().getStringArray(R.array.condition_options); // loading string array declared in strings.xml file
        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this.getContext(), android.R.layout.simple_spinner_item, conditions);
        conditionSpinner.setAdapter(adapter); // setting adapter of condition dropdown

        // on click listener for save button
        save.setOnClickListener(new View.OnClickListener()
        {
            // declaring calendar object.
            Calendar calendar;

            // on click method
            @Override
            public void onClick(View v)
            {
                // boolean flag to check if data entered is valid or not
                boolean validData = true;

                // getting current date and time from the calendar object
                calendar = Calendar.getInstance();
                String date = String.valueOf(calendar.get(Calendar.DAY_OF_MONTH)) + "/" + String.valueOf(calendar.get(Calendar.MONTH) + 1) + "/" + String.valueOf(calendar.get(Calendar.YEAR));
                date += " " + String.valueOf(calendar.get(Calendar.HOUR_OF_DAY)) + ":" + String.valueOf(calendar.get(Calendar.MINUTE));

                // getting latitude and longitude using trackGPS class
                Double longitude = null;
                Double latitude = null;

                if(trackGPS.canGetLocation)
                {
                    longitude = trackGPS.getLongitude(); Log.d("longitude", String.valueOf(longitude));
                    latitude = trackGPS.getLatitude(); Log.d("latitude", String.valueOf(latitude));
                }

                // getting entered data
                String currentID = idEditText.getText().toString();
                String currentWeight = weightEditText.getText().toString();
                String currentAge = ageEditText.getText().toString();
                String currentCondition = conditionSpinner.getSelectedItem().toString();

                // getting cow number passed as an argument
                int currentCow = getArguments().getInt("cow");

                // checking if ID is entered and within range
                if(currentID.isEmpty() || Integer.parseInt(currentID) < 1000 || Integer.parseInt(currentID) > 9999)
                {
                    if(validData) // if ID is not entered or out of range
                        validData = false; // set boolean flag to false

                    // print toast message
                    Toast.makeText(getContext(), "ID must be an integer 1000-9999 and cannot be null.", Toast.LENGTH_SHORT).show();
                }

                // checking if weight is entered and within range
                if(currentWeight.isEmpty() || Integer.parseInt(currentWeight) < 1 || Integer.parseInt(currentWeight) > 5000)
                {
                    if (validData) // if weight is not entered or out of range
                        validData = false; // set boolean flag to false

                    // print toast message
                    Toast.makeText(getContext(), "Weight must be an integer 1-5000 and cannot be null.", Toast.LENGTH_SHORT).show();
                }

                // checking if age is entered an within range
                if(currentAge.isEmpty() || Integer.parseInt(currentAge) < 1 || Integer.parseInt(currentAge) > 120)
                {
                    if (validData) // if age is not entered or out of range
                        validData = false; // set boolean flag to false

                    // print toast message
                    Toast.makeText(getContext(), "Age must be an integer 1-120 and cannot be null.", Toast.LENGTH_SHORT).show();
                }

                // checking if location is available
                if(latitude == null || longitude == null)
                {
                    if (validData) // if latitude or longitude is not set
                        validData = false; // set boolean flag to false

                    // print toast message
                    Toast.makeText(getContext(), "Location is not available.", Toast.LENGTH_SHORT).show();
                }

                if(!validData) // if data not entered or not valid
                {
                    // print toast message
                    Toast.makeText(getContext(), "Entry not saved as not all data entered. Complete all entries and try again.", Toast.LENGTH_SHORT).show();
                }
                else // if all data entered and data is valid
                {
                    // creating a new cow log instance with data entered
                    CowLogs newLog = new CowLogs(currentID, Integer.parseInt(currentWeight), Integer.parseInt(currentAge), currentCondition, currentCow, date, String.format("%.1f", longitude), String.format("%.1f", latitude));
                    // adding cow log instance to arraylist
                    MainActivity.cowLogsList.add(newLog);

                    // reset form by emptying data entered
                    idEditText.setText("");
                    weightEditText.setText("");
                    ageEditText.setText("");
                    conditionSpinner.setSelection(0);

                    // print success toast message
                    Toast.makeText(getContext(),"Entry saved.",Toast.LENGTH_SHORT).show();
                }
            }
        });

        // on click listener for show logs button
        showEntries.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                // get cow number passed as an argument
                int cow  = getArguments().getInt("cow");

                // create new cow list fragment instance
                CowList frag = new CowList();

                //Communicate the cow breed to the fragment by passing the cow number as an argument
                Bundle args = new Bundle();
                args.putInt("cow", cow);
                frag.setArguments(args);
                FragmentManager fragmentManager = getFragmentManager();
                FragmentTransaction ft = fragmentManager.beginTransaction();
                ft.replace(R.id.cowPlace, frag).commit();
            }
        });
    }

    // terminate GPS functionality on destroy
    @Override
    public void onDestroy()
    {
        super.onDestroy();
        trackGPS.stopUsingGPS();
    }
}
