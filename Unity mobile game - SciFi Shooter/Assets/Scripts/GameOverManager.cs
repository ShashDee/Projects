using UnityEngine;

public class GameOverManager : MonoBehaviour
{
    public PlayerHealth playerHealth;       // Reference to the player's health.
    public GameObject joystickCanvas;       // Reference to the canvas with the joystick

    Animator anim;                          // Reference to the animator component.
    float restartTimer;                     // Timer to count up to restarting the level
    int level1Threshold = 200;              // How much to score to complete level 1.
    int level2Threshold = 500;              // How much to score to complete level 2.
    bool isLeveledUp = false;               // boolean variable to check if level 2 has started

    void Awake()
    {
        // Set up the reference.
        anim = GetComponent<Animator>();
    }


    void FixedUpdate()
    {
        // If the player has run out of health...
        if (playerHealth.currentHealth <= 0)
        {
            // ... tell the animator the game is over.
            anim.SetTrigger("GameOver");

            // disable the canvas with game controls
            joystickCanvas.SetActive(false);
            
            return;
        }
        else if (ScoreManager.score == level2Threshold) // if game is won
        {
            // disable the canvas with game controls
            joystickCanvas.SetActive(false);

            // ... tell the animator the game is over.
            anim.SetTrigger("GameWon");

            playerHealth.GameWon();
        }
    }
}