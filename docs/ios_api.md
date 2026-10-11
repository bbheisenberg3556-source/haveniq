# iOS API Endpoints

The web app and the iOS app share the exact same logic. iOS developers do not need to integrate with Gemini or Replicate; they just hit these endpoints.

## 1. Submit Room Config
Submit the JSON checklist. This immediately spins off a background job to generate the image and the personality profile.

- **Endpoint:** `POST /api/v1/rooms`
- **Body (JSON):**
  ```json
  {
      "checklist": {
          "shape_and_size_of_the_room": {
              "shape_of_the_room": "Square",
              "size": "Medium"
          }
      }
  }
  ```
- **Response (200 OK):**
  ```json
  {
      "message": "Room submitted successfully",
      "session_id": "cfd01c83-4a0a-4e60-92a1-a99749ab6683"
  }
  ```

## 2. Poll Room Status
Use the `session_id` returned from the POST request to poll for the result. Wait until `status` is `completed`.

- **Endpoint:** `GET /api/v1/rooms/{session_id}`
- **Response (200 OK) - Still processing:**
  ```json
  {
      "status": "pending",
      "room": null
  }
  ```
- **Response (200 OK) - Completed:**
  ```json
  {
      "status": "completed",
      "room": {
          "id": 1,
          "session_id": "cfd01c83-4a0a-4e60-92a1-a99749ab6683",
          "image_url": "https://api.yourdomain.com/storage/rooms/...",
          "profile": {
              "traits": [
                  {
                      "name": "Quiet Depth",
                      "score": 82,
                      "explanation": "..."
                  }
              ],
              "summary": "..."
          }
      }
  }
  ```
