using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class ObjectController : MonoBehaviour
{
    public GameObject character;         // Player game object reference.
    public Joystick joystick;            // reference to joystick

    int healthPoints;                    // how much collecting one heart will add to current health of player
    float speed;                         // The speed that the player will move at.
    Actions actions;                     // Actions script object
    PlayerController controller;         // PlayerController script object.
    PlayerHealth playerHealth;           // PlayerHealth scipt object.

    void Awake()
    {
        // initializing variable and setting up references
        healthPoints = 10; // value of each heart
        speed = 1.6f; // speed of player
        actions = character.GetComponent<Actions>();
        controller = character.GetComponent<PlayerController>();
        playerHealth = GetComponent<PlayerHealth>();

        // Set player's initial position
        controller.SetArsenal("Rifle");
    }

    void Update()
    {
        Vector3 moveVector = (Vector3.right * joystick.Horizontal + Vector3.forward * joystick.Vertical);

        if (moveVector != Vector3.zero) // if player is moving
        {
            // rotate player in the direction of movement
            transform.rotation = Quaternion.LookRotation(moveVector);
            transform.Translate(moveVector * speed * Time.deltaTime, Space.World);

            // Tell the animator the player is walking.
            actions.SendMessage("Walk", SendMessageOptions.DontRequireReceiver);
            
        }
        else
        {
            // Tell the animator the player is idleing.
            actions.SendMessage("Stay", SendMessageOptions.DontRequireReceiver);
        }
    }

    void OnTriggerEnter(Collider other) // when player enters trigger collider of heart collectables
    {
        if (other.gameObject.CompareTag("Heart"))
        {
            // remove heart icon
            other.gameObject.SetActive(false);

            // add life
            Heal();
        }
    }

    void Heal()
    {
        // increase player health by 10 points
        playerHealth.AddLife(healthPoints);
    }
}
