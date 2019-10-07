package com.example.cowlogs;

import android.os.Bundle;
import android.support.v4.app.ListFragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;

import java.util.ArrayList;
import java.util.Iterator;

public class CowList extends ListFragment
{
    // arraylist declared to hold logs of selected cow
    ArrayList<String> curCowList = new ArrayList<>();

    // default constructor
    public CowList()
    {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState)
    {
        // initializing arraylist
        curCowList = new ArrayList<>();

        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.cow_list, container, false);

        // get cow number passed as an argument
        int cow = getArguments().getInt("cow");

        // update return button in show logs page with selected cow name
        Button returnButton = view.findViewById(R.id.return_btn);
        String buttonText = String.format(getResources().getString(R.string.return_button), MainActivity.pageNames[cow]);
        returnButton.setText(buttonText);

        // create iterator for arraylist of logs
        Iterator<CowLogs> itr = MainActivity.cowLogsList.iterator();

        // looping through arraylist
        while (itr.hasNext())
        {
            CowLogs curLog = itr.next();

            // if current log is of the selected cow type
            if(curLog.getType() == cow)
            {
                // add entry to arraylist holding currently displaying entries
                String currentLog = curLog.getCondition() + " " + curLog.getDateTime() + " - " + curLog.getLatitude() + " " + curLog.getLongitude() + " " + curLog.getID() + " " + curLog.getWeight() + " " + curLog.getAge();
                curCowList.add(currentLog);
            }
        }

        return view;
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState)
    {
        super.onViewCreated(view, savedInstanceState);

        String[] cowLogsDisplay = new String[curCowList.size()];

        // looping through selected cow's entries and displaying them in the android list
        for(int i =0;i<curCowList.size();i++)
        {
            cowLogsDisplay[i] = curCowList.get(i);
        }

        setListAdapter(new ArrayAdapter<>(getActivity(), android.R.layout.simple_list_item_1, cowLogsDisplay));
    }
}
