package com.example.cowlogs;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

public class ProfileFragment extends Fragment
{
    // default constructor
    public ProfileFragment()
    {
        // Required empty public constructor
    }


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState)
    {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.profile_fragment, container, false);
    }

    @Override
    public void onViewCreated(View view, Bundle savedInstanceState)
    {
        // getting inputs and buttons in profile page
        final EditText usernameEditText = (EditText)getActivity().findViewById(R.id.username_ed);
        final EditText passwordEditText = (EditText)getActivity().findViewById(R.id.password_ed);
        final EditText repeatPassswordEditText = (EditText)getActivity().findViewById(R.id.repeat_password_ed);

        Button saveProfile = (Button)getActivity().findViewById(R.id.save_profile_btn);
        Button cancelProfile = (Button)getActivity().findViewById(R.id.cancel_profile_btn);

        // when save button is pressed
        saveProfile.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                // get entered data
                String username = usernameEditText.getText().toString();
                String password = passwordEditText.getText().toString();
                String repeatPassword = repeatPassswordEditText.getText().toString();

                // if all data not entered
                if(username.isEmpty() || password.isEmpty() || repeatPassword.isEmpty())
                {
                    // print toast message
                    Toast.makeText(getContext(),"Profile not saved as not all data entered. Complete all entries and try again.",Toast.LENGTH_SHORT).show();
                }
                else // if all data entered
                {
                    // checking if password and repeat password match
                    if (password.equals(repeatPassword)) // if password and repeat password match
                    {
                        // save username and password in local variables
                        MainActivity.profileUsername = username;
                        MainActivity.profilePassword = password;

                        // print success toast message
                        Toast.makeText(getContext(),"Profile saved.",Toast.LENGTH_SHORT).show();

                        // load home page
                        LoadHomePage();
                    }
                    else // if password and repeat password does not match
                    {
                        // print error toast message
                        Toast.makeText(getContext(), "Password and Repeat Password does not match. Re-enter password and try again.", Toast.LENGTH_SHORT).show();
                    }
                }
            }
        });

        // when cancel button is pressed
        cancelProfile.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View v)
            {
                // load home page
                LoadHomePage();
            }
        });
    }

    // method to load home page
    public void LoadHomePage()
    {
        HomeFragment hf = new HomeFragment();
        FragmentManager fragmentManager = getFragmentManager();
        FragmentTransaction ft = fragmentManager.beginTransaction();
        ft.replace(R.id.cowPlace, hf).commit();
    }

}
