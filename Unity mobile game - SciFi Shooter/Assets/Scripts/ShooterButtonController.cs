using UnityEngine;
using UnityEngine.EventSystems;

public class ShooterButtonController : MonoBehaviour, IPointerUpHandler, IPointerDownHandler
{
    [HideInInspector]
    public bool Pressed;

    public void OnPointerDown(PointerEventData eventData)
    {
        Pressed = true;
    }

    public void OnPointerUp(PointerEventData eventData)
    {
        Pressed = false;
    }

    public void ShootStatus()
    {
        Pressed = true;
    }
}
