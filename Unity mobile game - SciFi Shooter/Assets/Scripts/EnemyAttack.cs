using UnityEngine;
using System.Collections;

public class EnemyAttack : MonoBehaviour
{
    GameObject character;                // Player game object reference.
    public GameObject enemy;             // enemy game object reference
    public int timeBetweenAttacks = 4;   // The time in seconds between each attack.
    public int attackDamage = 20;        // The amount of health taken away per attack.


    Actions actions;                     // Actions script object
    PlayerController controller;         // PlayerController script object.
    Animator anim;                       // Reference to the Animator component.
    GameObject player;                   // Reference to the player GameObject.
    PlayerHealth playerHealth;           // Reference to the player's health.
    EnemyHealth enemyHealth;             // Reference to this enemy's health.
    bool playerInRange;                  // Whether player is within the trigger collider and can be attacked.
    int timer = 0;                       // Timer for counting up to the next attack.
    bool gameOver = false;               // boolean variable for detecting when game is over

    void Awake()
    {
        // Setting up the references.
        anim = enemy.GetComponent<Animator>();
        player = GameObject.FindGameObjectWithTag("Player");
        character = GameObject.Find("Sci-Fi_Soldier");
        playerHealth = player.GetComponent<PlayerHealth>();
        enemyHealth = GetComponent<EnemyHealth>();
        actions = character.GetComponent<Actions>();
        controller = character.GetComponent<PlayerController>();
    }


    void OnTriggerEnter(Collider other)
    {
        // If the entering collider is the player...
        if (other.gameObject == player)
        {
            // ... the player is in range.
            playerInRange = true;
        }
    }


    void OnTriggerExit(Collider other)
    {
        // If the exiting collider is the player...
        if (other.gameObject == player)
        {
            // ... the player is no longer in range.
            playerInRange = false;
        }
    }


    void FixedUpdate()
    {

        // Add the time since Update was last called to the timer.
        timer++;

        // If the timer exceeds the time between attacks, the player is in range and this enemy is alive...
        if (timer >= timeBetweenAttacks && playerInRange && enemyHealth.currentHealth > 0)
        {
            // ... attack.
            Attack();
        }

        // If the player has zero or less health...
        if (playerHealth.currentHealth <= 0 && !gameOver)
        {
            gameOver = true;
            
            // call game over screen animation
            anim.SetTrigger("PlayerDeadWon");
        }
        else if(ScoreManager.score == 500)
        {
            // call win screen animation
            anim.SetTrigger("PlayerDeadWon");
        }
    }

    void Attack()
    {
        // Reset the timer.
        timer = 0;
        
        // Tell the animator to attack player.
        anim.SetTrigger("Attack");
        
        Invoke("PlayerDamage", 2f);

    }

    void PlayerDamage()
    {
        // If the player has health to lose...
        if (playerHealth.currentHealth > 0)
        {
            // ... damage the player.
            playerHealth.TakeDamage(attackDamage);

            // .... player damage animation
            actions.SendMessage("Damage", SendMessageOptions.DontRequireReceiver);
        }
    }
}