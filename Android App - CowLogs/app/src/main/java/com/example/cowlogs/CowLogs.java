package com.example.cowlogs;

public class CowLogs
{
    // declaring properties of cow log class
    private String ID;
    private int weight;
    private int age;
    private String condition;
    private int Type;
    private String dateTime;
    private String longitude;
    private String latitude;

    // parameterised constructor
    public CowLogs(String Id, int cowWeight, int cowAge, String cowCondition, int cowType, String currentDate, String cowLongitude, String cowLatitude)
    {
        this.ID = Id;
        this.weight = cowWeight;
        this.age = cowAge;
        this.condition = cowCondition;
        this.Type = cowType;
        this.dateTime = currentDate;
        this.longitude = cowLongitude;
        this.latitude = cowLatitude;
    }

    // set and get methods of properties
    public String getID()
    {
        return ID;
    }

    public void setID(String ID)
    {
        this.ID = ID;
    }

    public int getWeight()
    {
        return weight;
    }

    public void setWeight(int weight)
    {
        this.weight = weight;
    }

    public int getAge()
    {
        return age;
    }

    public void setAge(int age)
    {
        this.age = age;
    }

    public String getCondition()
    {
        return condition;
    }

    public void setCondition(String condition)
    {
        this.condition = condition;
    }

    public int getType()
    {
        return Type;
    }

    public void setType(int type)
    {
        Type = type;
    }

    public String getDateTime()
    {
        return dateTime;
    }

    public void setDateTime(String dateTime)
    {
        this.dateTime = dateTime;
    }

    public String getLongitude() { return longitude; }

    public void setLongitude(String longitude) { this.longitude = longitude; }

    public String getLatitude() { return latitude; }

    public void setLatitude(String latitude) { this.latitude = latitude; }
}
