using UnityEngine;
using UnityEngine.UI;

public class PlayerShooting : MonoBehaviour
{
    //public GameObject character;
    public float timeBetweenBullets = 0.15f;        // The time between each shot.
    public float range = 100f;                      // The distance the gun can fire.
    public ShooterButtonController shooterButton;   // reference to the shooter button 
    public int damagePerShot = 20;                  // how much life is lost per attack
    AudioSource gunAudio;                           // Reference to the audio source.

    Ray shootRay;                                   // reference to the rifle ray
    RaycastHit shootHit;                            // reference to rifle raycasthit
    ParticleSystem gunParticles;                    // reference to gun particles 
    LineRenderer gunLine;                           // reference to line renderer
    Light gunLight;                                 // reference to light
    float effectsDisplayTime = 0.2f;                // how long each shoot will last
    float timer;                                    // A timer to determine when to fire.
    int shootableMask;                              // A layer mask so the raycast only hits things on the shootable layer.
    Actions actions;                                // reference to player actions

    void Awake()
    {
        // Setting up references
        shooterButton = FindObjectOfType<ShooterButtonController>();
        gunAudio = GetComponent<AudioSource>();
        gunParticles = GetComponent<ParticleSystem>();
        gunLine = GetComponent<LineRenderer>();
        gunLight = GetComponent<Light>();

        // Create a layer mask for the Shootable layer.
        shootableMask = LayerMask.GetMask("Shootable");
    }

    void Update()
    {
        // Add the time since Update was last called to the timer.
        timer += Time.deltaTime;

        // if shoot button is pressed and break between each shoot has exceeded
        if (shooterButton.Pressed && timer >= timeBetweenBullets)
        {
            // shoot
            Shoot();

            shooterButton.Pressed = false; 
        }

        // stop gun shooting
        if (timer >= timeBetweenBullets * effectsDisplayTime)
        {
            DisableEffects();
        }
    }

    public void DisableEffects()
    {
        gunLine.enabled = false;
        gunLight.enabled = false;
    }

    void Shoot()
    {
        // Reset the timer.
        timer = 0f;

        // Play the gun shot audioclip.
        gunAudio.Play();

        gunLight.enabled = true;

        gunParticles.Stop();
        gunParticles.Play();

        gunLine.enabled = true;
        gunLine.SetPosition(0, transform.position);

        shootRay.origin = transform.position;
        shootRay.direction = transform.forward;

        if (Physics.Raycast(shootRay, out shootHit, range, shootableMask))
        { 
            // Try and find an EnemyHealth script on the gameobject hit.
            EnemyHealth enemyHealth = shootHit.collider.GetComponent<EnemyHealth>();

           // If the EnemyHealth component exist...
           if (enemyHealth != null)
           {
               // ... the enemy should take damage.
               enemyHealth.TakeDamage(damagePerShot, shootHit.point);
           }

           // Set the second position of the line renderer to the point the raycast hit.
           gunLine.SetPosition(1, shootHit.point);
        }
        else  // If the raycast didn't hit anything on the shootable layer...
        {
            // ... set the second position of the line renderer to the fullest extent of the gun's range.
            gunLine.SetPosition(1, shootRay.origin + shootRay.direction * range);
        }
    }
}