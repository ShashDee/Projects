using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class LifePickUpsManager : MonoBehaviour
{
    public GameObject LifePickUp;          // The enemy prefab to be spawned.
    public PlayerHealth playerHealth;      // Reference to the player's heatlh.
    public Transform[] spawnPoints;        // An array of the spawn points this enemy can spawn from.
    
    float heartDelayTime = 2f;             // How long before spawning starts.
    float heartSpawnTime = 30f;            // How long between each spawn.
    int level2Threshold = 500;             // How much to score to complete the game.
    string scoreText;                      // string variable to get score.
    int currentScore;                      // variable to store current score
    bool isLeveledUp = false;              // boolean variable to check if level 2 has started
    bool gameWon = false;                  // boolean variable to check if game is won
    bool gameOver = false;                 // boolean variable to check if game is over

    void Start()
    {
        // Call the HeartSpawn function after a delay of the delayTime and then continue to call after a delay of spawTime of time.
        InvokeRepeating("HeartSpawn", heartDelayTime, heartSpawnTime);
    }

    void Update()
    {
        // if game is complete and game won as not occurred
        if (ScoreManager.score == level2Threshold && !gameWon)
        {
            // setting game won to true
            gameWon = true;

            // ... stop spawning and exit the function.
            CancelInvoke("HeartSpawn");
        }
    }

    void HeartSpawn()
    {
        // If the player has no health left...
        if (playerHealth.currentHealth <= 0 && !gameOver)
        {
            // setting game over to true
            gameOver = true;
            
            // ... stop spawning and exit the function.
            CancelInvoke("HeartSpawn");

            // ... exit the function.
            return;
        }

        // Find a random index between zero and one less than the number of spawn points.
        int spawnPointIndex = Random.Range(0, spawnPoints.Length);

        // getting position of spawn point
        Vector3 spawnPoint = spawnPoints[spawnPointIndex].position;

        // checking if a heart is already available at spawn point and return if yes
        if (Physics.CheckSphere(spawnPoint, 0.1f))
            return;

        // Create an instance of the enemy prefab at the randomly selected spawn point's position and rotation.
        Instantiate(LifePickUp, spawnPoint, spawnPoints[spawnPointIndex].rotation);
    }
}
