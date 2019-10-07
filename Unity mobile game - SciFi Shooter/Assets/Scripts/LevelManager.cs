using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class LevelManager : MonoBehaviour
{
    public GameObject player;               // Reference to the player game object
    public Image levelUpImage;              // referenced to the Level up image
    public float flashSpeed = 5f;           // The speed the levelUpImage will fade at.
    public Color flashColour;               // The colour the levelUpImage is set to, to flash.

    Animator anim;                          // Reference to the animator component.
    PlayerHealth playerHealth;              // Reference to the player's heatlh.
    int level1Threshold = 200;              // How much to score to complete level 1.
    bool isLeveledUp = false;               // boolean variable to check if level 2 has started
    Text text;                              // Reference to the Text component.

    // Start is called before the first frame update
    void Awake()
    {
        // Set up the reference.
        anim = GetComponent<Animator>();
        playerHealth = player.GetComponent<PlayerHealth>();
        text = GetComponent<Text>();

        // setting levelUpImage flash colour
        flashColour = new Color(0.9622642f, 0.9232985f, 0.05900679f, 0.8f);
    }

    // Update is called once per frame
    void Update()
    {
        // if player has no health left
        if (playerHealth.currentHealth > 0)
        {
            // if level 1 is complete and level up has not occured
            if (ScoreManager.score == level1Threshold && !isLeveledUp)
            {
                // if level up has not occured
                if (!isLeveledUp)
                {
                    // setting level up to true
                    isLeveledUp = true;

                    // setting level text to level 2
                    text.text = "Level 2";

                    // ... set the colour of the levelUpImage to the flash colour.
                    levelUpImage.color = flashColour;
                    
                    // .... telling animator to level up
                    anim.SetTrigger("LeveledUp");
                }
            }
            else
            {
                // ... transition the colour back to clear.
                levelUpImage.color = Color.Lerp(levelUpImage.color, Color.clear, flashSpeed * Time.deltaTime);
            }
        }
    }
}
