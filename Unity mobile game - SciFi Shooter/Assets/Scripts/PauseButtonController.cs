using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.EventSystems;

public class PauseButtonController : MonoBehaviour, IPointerUpHandler, IPointerDownHandler
{
    [HideInInspector]
    public bool pausePressed;    // boolean vairable to hold whether the pause button clicked

    public void OnPointerDown(PointerEventData eventData)
    {
        pausePressed = true;
    }

    public void OnPointerUp(PointerEventData eventData)
    {
        pausePressed = false;
    }

    public void PauseStatus()
    {
        pausePressed = true;
    }
}
