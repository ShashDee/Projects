using UnityEngine;
using UnityEngine.EventSystems;

public class ReplayButtonController : MonoBehaviour, IPointerUpHandler, IPointerDownHandler
{
    public void OnPointerDown(PointerEventData eventData)
    {
        // restart game when button is pressed
        RestartGame();
    }

    public void OnPointerUp(PointerEventData eventData)
    {
    }

    public void RestartGame()
    {
        // .. then reload the currently loaded level.
        #pragma warning disable CS0618 // Type or member is obsolete
        Application.LoadLevel(Application.loadedLevel);
        #pragma warning restore CS0618 // Type or member is obsolete
    }
}
