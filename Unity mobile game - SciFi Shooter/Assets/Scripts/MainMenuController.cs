using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class MainMenuController : MonoBehaviour
{
    public void PlayGame()
    {
        // load game scene
        SceneManager.LoadScene("SciFi Shooter");
    }

    public void HowToPlay()
    {
        // load how to play scene
        SceneManager.LoadScene("HowToPlay");
    }

    public void ExitGame()
    {
        Debug.Log("Quit...!!");
        Application.Quit(); // quit application
    }
}
