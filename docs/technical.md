# Technical Documentation

## Model Choices
1. **Replicate Image Model**: We use Black Forest Labs `flux-schnell`. It offers exceptional photorealism, incredibly fast generation times, and accurately follows architectural layout prompts.
2. **Gemini Personality Model**: We use Google's `gemini-3.5-flash-lite` as the primary engine (with a seamless fallback to `gemini-3.8-flash` via the Interactions API if needed). The Flash family inherently supports the multi-modality required to read the user's generated image alongside their checklist JSON.

## Prompt Engineering
The system prompt for Gemini has been meticulously structured to avoid sounding like a clinical psychology textbook. 
- It forces **second-person** phrasing ("You tend to...").
- It requires **short, human trait names** (e.g., "Quiet Depth").
- It requires **concrete grounding**, demanding that the AI explicitly cite items from the checklist (e.g., "your warm white walls").

If the prompt drifts in the future, you can edit the `$promptText` string directly inside `app/Services/GeminiService.php`.

## Retraining / Adjusting the Engine
If you decide to change the Image model on Replicate or update the API keys, modify the `.env` file variables. 
If the structure of the checklist changes, the frontend will dynamically adapt, and the backend will naturally pipe the new JSON directly into Gemini. No logic rewrites are needed to add/remove questions from `config/checklist.php`.
