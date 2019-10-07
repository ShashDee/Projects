using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using UnityEngine.AI;

public class EnemyManager : MonoBehaviour
{
    public GameObject enemy;                // The enemy prefab to be spawned.
    public PlayerHealth playerHealth;       // Reference to the player's heatlh.
    public Transform[] spawnPoints;         // An array of the spawn points this enemy can spawn from.
   
    NavMeshAgent nav;                       // Reference to the nav mesh agent.
    float delayTime = 5f;                   // How long before spawning starts.
    float spawnTime = 10f;                  // How long between each spawn.
    int level1Threshold = 200;              // How much to score to complete level 1.
    int level2Threshold = 500;              // How much to score to complete level 2.
    string scoreText;                       // string variable to get score.
    bool isLeveledUp = false;               // boolean variable to check if level 2 has started
    bool gameWon = false;                   // boolean variable to check if game is won
    bool gameOver = false;                  // boolean variable to check if game is over

    void Awake()
    {
        // Setting up references
        scoreText = GameObject.Find("ScoreText").GetComponent<Text>().text;
        
        nav = enemy.GetComponent<NavMeshAgent>();
        
        // setting speed of nav mesh agent
        nav.speed = 0.5f;
        
    }

    void Start()
    {
        // Call the Spawn function after a delay of the delayTime and then continue to call after a delay of spawTime of time.
        InvokeRepeating("Spawn", delayTime, spawnTime);
    }

    void Update()
    {
        // if level 1 is reached
        if(ScoreManager.score == level1Threshold)
        {
            // if level up has not happened
            if (!isLeveledUp)
            {
                // set level up variable to true
                isLeveledUp = true;

                // stop current spawn
                if (IsInvoking("Spawn"))
                    CancelInvoke("Spawn");

                // set new spawn time and speed of nav mesh agent
                spawnTime = 6f;
                nav.speed = 1f;
                
                // restart spawn
                if (!IsInvoking("Spawn"))
                    InvokeRepeating("Spawn", delayTime, spawnTime);
            }
        }
        else if (ScoreManager.score == level2Threshold && !gameWon) // if game is complete
        {
            // set game won variable to true
            gameWon = true;

            // ... stop spawning and exit the function.
            CancelInvoke("Spawn");

            #pragma warning disable CS0618 // Type or member is obsolete
            nav.Stop();
            #pragma warning restore CS0618 // Type or member is obsolete
        }
    }

    void Spawn()
    {
        // If the player has no health left...
        if (playerHealth.currentHealth <= 0 && !gameOver)
        {
            // setting game over variable to true
            gameOver = true;

            // ... stop spawning and exit the function.
            CancelInvoke("Spawn");

            #pragma warning disable CS0618 // Type or member is obsolete
            nav.Stop();
            #pragma warning restore CS0618 // Type or member is obsolete

            // ... exit the function.
            return;
        }

        // Find a random index between zero and one less than the number of spawn points.
        int spawnPointIndex = Random.Range(0, spawnPoints.Length);

        // Create an instance of the enemy prefab at the randomly selected spawn point's position and rotation.
        Instantiate(enemy, spawnPoints[spawnPointIndex].position, spawnPoints[spawnPointIndex].rotation);
    }
}
 